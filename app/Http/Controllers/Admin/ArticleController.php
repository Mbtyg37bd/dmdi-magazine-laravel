<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Services\AutoTranslator;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('category')
                         ->orderBy('created_at', 'desc')
                         ->paginate(10);

        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request, AutoTranslator $translator)
    {
        $validated = $request->validate([
            'title_id'     => 'required|string|max:255',
            'title_en'     => 'nullable|string|max:255',
            'excerpt_id'   => 'required|string|max:500',
            'excerpt_en'   => 'nullable|string|max:500',
            'content_id'   => 'required|string',
            'content_en'   => 'nullable|string',
            'category_id'  => 'required|exists:categories,id',
            'author'       => 'required|string|max:255',
            'is_published' => 'boolean',
            'is_featured'  => 'boolean',
        ]);

        // Generate unique slug
        $slug = Str::slug($validated['title_id']);
        $originalSlug = $slug;
        $counter = 1;
        while (Article::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        $validated['slug'] = $slug;

        // Auto-translate if empty
        if (empty($validated['title_en'])) {
            $validated['title_en'] = $translator->translate($validated['title_id'] ?? '');
        }
        if (empty($validated['excerpt_en'])) {
            $validated['excerpt_en'] = $translator->translate($validated['excerpt_id'] ?? '');
        }
        if (empty($validated['content_en'])) {
            $validated['content_en'] = $translator->translateHtml($validated['content_id'] ?? '');
        }

        // Upload featured image (multiple sizes + webp where possible)
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $paths = $this->saveImageSizes($image);
            $validated['featured_image'] = $paths['medium']; // alias to 1200
        }

        Article::create($validated);

        return redirect()->route('articles.index')
                        ->with('success', 'Artikel berhasil dibuat (EN otomatis).');
    }

    public function show(Article $article)
    {
        return view('admin.articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article, AutoTranslator $translator)
    {
        $validated = $request->validate([
            'title_id'     => 'required|string|max:255',
            'title_en'     => 'nullable|string|max:255',
            'excerpt_id'   => 'required|string|max:500',
            'excerpt_en'   => 'nullable|string|max:500',
            'content_id'   => 'required|string',
            'content_en'   => 'nullable|string',
            'category_id'  => 'required|exists:categories,id',
            'author'       => 'required|string|max:255',
            'is_published' => 'boolean',
            'is_featured'  => 'boolean',
        ]);

        // Auto-translate when empty
        if (empty($validated['title_en']) && !empty($validated['title_id'])) {
            $validated['title_en'] = $translator->translate($validated['title_id']);
        }
        if (empty($validated['excerpt_en']) && !empty($validated['excerpt_id'])) {
            $validated['excerpt_en'] = $translator->translate($validated['excerpt_id']);
        }
        if (empty($validated['content_en']) && !empty($validated['content_id'])) {
            $validated['content_en'] = $translator->translateHtml($validated['content_id']);
        }

        // Handle featured image upload (delete old sizes)
        if ($request->hasFile('featured_image')) {
            if ($article->featured_image) {
                $this->deleteImageSizesByMediumPath($article->featured_image);
            }

            $image = $request->file('featured_image');
            $paths = $this->saveImageSizes($image);
            $validated['featured_image'] = $paths['medium'];
        }

        $article->update($validated);

        return redirect()->route('articles.index')
                        ->with('success', 'Artikel berhasil diperbarui (EN otomatis).');
    }

    public function destroy(Article $article)
    {
        if ($article->featured_image) {
            $this->deleteImageSizesByMediumPath($article->featured_image);
        }

        if ($article->qr_code_path) {
            Storage::disk('public')->delete($article->qr_code_path);
        }

        $article->delete();

        return redirect()->route('articles.index')
                        ->with('success', 'Artikel berhasil dihapus!');
    }

public function generateQR($id)
{
    try {
        $article = Article::findOrFail($id);
        
        // URL artikel dalam bahasa Inggris
        $url = url('en/article/' . $article->slug);
        
        // Generate QR Code menggunakan chillerlan (GD-based, no Imagick needed)
        $options = new \chillerlan\QRCode\QROptions([
            'version'      => -1,  // Auto-detect version (bisa sampai version 40)
            'outputType'   => \chillerlan\QRCode\QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel'     => \chillerlan\QRCode\Common\EccLevel::M,  // Medium (balance antara size & error correction)
            'scale'        => 8,   // Size: 8px per module (optimal untuk web)
            'imageBase64'  => false,
            'imageTransparent' => false,
        ]);
        
        $qrcode = new \chillerlan\QRCode\QRCode($options);
        $qrCodePng = $qrcode->render($url);
        
        // Path untuk save QR code
        $filename = 'qrcodes/article-' . $article->id .  '-en.png';
        
        // Pastikan folder qrcodes ada
        $qrcodesPath = storage_path('app/public/qrcodes');
        if (!file_exists($qrcodesPath)) {
            mkdir($qrcodesPath, 0755, true);
        }
        
        // Save file
        Storage::disk('public')->put($filename, $qrCodePng);
        
        // Update artikel dengan path QR code
        $article->update(['qr_code_path' => $filename]);
        
        \Log:: info('QR Code generated successfully', [
            'article_id' => $article->id,
            'filename' => $filename,
            'url' => $url,
            'url_length' => strlen($url)
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'QR Code berhasil digenerate! ',
            'qr_url' => asset('storage/' . $filename)
        ]);
        
    } catch (\Exception $e) {
        \Log::error('QR Code generation failed:  ' . $e->getMessage(), [
            'article_id' => $id,
            'url' => url('en/article/' . Article::find($id)?->slug),
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Gagal generate QR Code: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Save multiple sizes + webp versions for given UploadedFile.
     * Returns array with relative storage paths.
     */
    private function saveImageSizes($uploadedFile)
    {
        $ext = strtolower($uploadedFile->getClientOriginalExtension() ?: 'jpg');
        $basename = 'article-' . time() . '-' . Str::random(6);

        $baseDir = 'uploads/articles';
        $originalPath = $baseDir . '/original/' . $basename . '.' . $ext;
        $p1200 = $baseDir . '/1200/' . $basename . '.' . $ext;
        $p768  = $baseDir . '/768/' . $basename . '.' . $ext;
        $p480  = $baseDir . '/480/' . $basename . '.' . $ext;
        $thumb = $baseDir . '/thumb/' . $basename . '.' . $ext;

        // Save original
        Storage::disk('public')->putFileAs($baseDir . '/original', $uploadedFile, $basename . '.' . $ext);

        $saveEncoded = function ($path, $imageInstance, $format, $quality = 85) {
            try {
                $encoded = (string) $imageInstance->encode($format, $quality);
                Storage::disk('public')->put($path, $encoded);
                return true;
            } catch (\Throwable $e) {
                \Log::error('Failed to save encoded image ' . $path . ': ' . $e->getMessage());
                return false;
            }
        };

        try {
            if (class_exists(\Intervention\Image\ImageManagerStatic::class)) {
                // 1200
                $img1200 = Image::make($uploadedFile)->orientate();
                $img1200->resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $saveEncoded($p1200, $img1200, $ext, 85);
                $saveEncoded(str_replace('.' . $ext, '.webp', $p1200), $img1200, 'webp', 80);

                // 768
                $img768 = Image::make($uploadedFile)->orientate();
                $img768->resize(768, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $saveEncoded($p768, $img768, $ext, 85);
                $saveEncoded(str_replace('.' . $ext, '.webp', $p768), $img768, 'webp', 80);

                // 480
                $img480 = Image::make($uploadedFile)->orientate();
                $img480->resize(480, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $saveEncoded($p480, $img480, $ext, 85);
                $saveEncoded(str_replace('.' . $ext, '.webp', $p480), $img480, 'webp', 80);

                // thumb
                $imgThumb = Image::make($uploadedFile)->orientate();
                $imgThumb->fit(300, 200, function ($constraint) {
                    $constraint->upsize();
                });
                $saveEncoded($thumb, $imgThumb, $ext, 85);
                $saveEncoded(str_replace('.' . $ext, '.webp', $thumb), $imgThumb, 'webp', 80);
            } else {
                // fallback: copy original to other folders
                Storage::disk('public')->copy($baseDir . '/original/' . $basename . '.' . $ext, $p1200);
                Storage::disk('public')->copy($baseDir . '/original/' . $basename . '.' . $ext, $p768);
                Storage::disk('public')->copy($baseDir . '/original/' . $basename . '.' . $ext, $p480);
                Storage::disk('public')->copy($baseDir . '/original/' . $basename . '.' . $ext, $thumb);
            }
        } catch (\Throwable $e) {
            // ensure copies exist
            if (!Storage::disk('public')->exists($p1200)) {
                Storage::disk('public')->copy($baseDir . '/original/' . $basename . '.' . $ext, $p1200);
            }
            if (!Storage::disk('public')->exists($p768)) {
                Storage::disk('public')->copy($baseDir . '/original/' . $basename . '.' . $ext, $p768);
            }
            if (!Storage::disk('public')->exists($p480)) {
                Storage::disk('public')->copy($baseDir . '/original/' . $basename . '.' . $ext, $p480);
            }
            if (!Storage::disk('public')->exists($thumb)) {
                Storage::disk('public')->copy($baseDir . '/original/' . $basename . '.' . $ext, $thumb);
            }
            \Log::error('Image processing failed: ' . $e->getMessage());
        }

        return [
            'original' => $originalPath,
            '1200' => $p1200,
            '768' => $p768,
            '480' => $p480,
            'thumb' => $thumb,
            'medium' => $p1200,
        ];
    }

    private function deleteImageSizesByMediumPath($mediumPath)
    {
        if (! $mediumPath) return;

        $basename = basename($mediumPath);

        $paths = [
            'uploads/articles/1200/' . $basename,
            'uploads/articles/768/' . $basename,
            'uploads/articles/480/' . $basename,
            'uploads/articles/thumb/' . $basename,
            'uploads/articles/original/' . $basename,
            // webp siblings
            'uploads/articles/1200/' . preg_replace('/\.[^.]+$/', '.webp', $basename),
            'uploads/articles/768/' . preg_replace('/\.[^.]+$/', '.webp', $basename),
            'uploads/articles/480/' . preg_replace('/\.[^.]+$/', '.webp', $basename),
            'uploads/articles/thumb/' . preg_replace('/\.[^.]+$/', '.webp', $basename),
        ];

        foreach ($paths as $p) {
            if (Storage::disk('public')->exists($p)) {
                Storage::disk('public')->delete($p);
            }
        }
    }
}