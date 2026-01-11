<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::latest()->get();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_id' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',  // ← MAX 2MB
            'content_id' => 'nullable|string',
            'content_en' => 'nullable|string',
            'meta_description_id' => 'nullable|string|max:255',
            'meta_description_en' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'show_in_footer' => 'nullable|boolean',
            'footer_order' => 'nullable|integer|min:0',
        ], [
            'image.max' => 'Ukuran gambar maksimal 2MB (2048 KB).',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus:  JPEG, JPG, PNG, atau WebP.',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title_en']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        // Ensure unique slug
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Page::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug .  '-' . $counter;
            $counter++;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($validated['title_en']) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/pages', $imageName);
            $validated['image'] = $imageName;
        }

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $validated['show_in_footer'] = $request->has('show_in_footer') ? 1 : 0;
        $validated['footer_order'] = $request->input('footer_order', 0);

        Page::create($validated);

        return redirect()->route('admin.pages.index')
                        ->with('success', 'Halaman berhasil dibuat! ');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

public function update(Request $request, Page $page)
{
    $validated = $request->validate([
        'title_id' => 'required|string|max:255',
        'title_en' => 'required|string|max:255',
        'slug' => [
            'nullable',
            'string',
            'max:255',
            \Illuminate\Validation\Rule:: unique('pages', 'slug')->ignore($page->id),
        ],
        'image' => 'nullable|image|mimes: jpeg,jpg,png,webp|max:2048',
        'content_id' => 'nullable|string',
        'content_en' => 'nullable|string',
        'meta_description_id' => 'nullable|string|max:255',
        'meta_description_en' => 'nullable|string|max: 255',
        'is_active' => 'nullable|boolean',
        'show_in_footer' => 'nullable|boolean',
        'footer_order' => 'nullable|integer|min: 0',
        'remove_image' => 'nullable|boolean',
    ], [
        'image.max' => 'Ukuran gambar maksimal 2MB (2048 KB).',
        'image.image' => 'File harus berupa gambar.',
        'image. mimes' => 'Format gambar harus:  JPEG, JPG, PNG, atau WebP.',
    ]);

    // Generate slug if not provided
    if (empty($validated['slug'])) {
        $validated['slug'] = Str::slug($validated['title_en']);
    } else {
        $validated['slug'] = Str::slug($validated['slug']);
    }

    // Handle remove image
    if ($request->has('remove_image') && $page->image) {
        Storage::delete('public/pages/' . $page->image);
        $validated['image'] = null;
    }

// Handle image upload (new image)
if ($request->hasFile('image')) {
    $image = $request->file('image');
    
    \Log::info('=== IMAGE UPLOAD DEBUG ===');
    \Log::info('Original name: ' . $image->getClientOriginalName());
    \Log::info('Size: ' . $image->getSize());
    \Log::info('Mime: ' . $image->getMimeType());
    \Log::info('Valid: ' . ($image->isValid() ? 'YES' : 'NO'));
    
    // Check target directory
    $targetDir = storage_path('app/public/pages');
    \Log::info('Target dir:  ' . $targetDir);
    \Log::info('Dir exists: ' . (is_dir($targetDir) ? 'YES' : 'NO'));
    
    // Create directory if not exists
    if (!is_dir($targetDir)) {
        \Log::info('Creating directory.. .');
        mkdir($targetDir, 0755, true);
        \Log::info('Directory created:  ' . (is_dir($targetDir) ? 'YES' : 'NO'));
    }
    
    \Log::info('Dir writable: ' . (is_writable($targetDir) ? 'YES' : 'NO'));
    
    // Delete old image if exists
    if ($page->image) {
        Storage::delete('public/pages/' .  $page->image);
    }
    
    $imageName = time() . '_' . Str::slug($validated['title_en']) . '.' . $image->getClientOriginalExtension();
    
    \Log::info('Target filename: ' . $imageName);
    
    // Store file
    try {
        $result = $image->storeAs('public/pages', $imageName);
        \Log::info('storeAs result: ' . ($result ? $result : 'NULL'));
        
        // Verify
        $finalPath = storage_path('app/public/pages/' .  $imageName);
        \Log::info('Final path: ' . $finalPath);
        \Log::info('File exists: ' . (file_exists($finalPath) ? 'YES' : 'NO'));
        
        if (file_exists($finalPath)) {
            \Log::info('File size: ' . filesize($finalPath));
        }
        
        $validated['image'] = $imageName;
        \Log::info('=== UPLOAD SUCCESS ===');
    } catch (\Exception $e) {
        \Log::error('=== UPLOAD FAILED ===');
        \Log::error('Error: ' . $e->getMessage());
    }
}
    $validated['is_active'] = $request->has('is_active') ? 1 : 0;
    $validated['show_in_footer'] = $request->has('show_in_footer') ? 1 : 0;
    $validated['footer_order'] = $request->input('footer_order', 0);

    $page->update($validated);

    return redirect()->route('admin.pages.index')
                    ->with('success', 'Halaman berhasil diperbarui!');
}

    public function destroy(Page $page)
    {
        // Delete image if exists
        if ($page->image) {
            Storage:: delete('public/pages/' . $page->image);
        }

        $page->delete();

        return redirect()->route('admin.pages.index')
                        ->with('success', 'Halaman berhasil dihapus! ');
    }
}