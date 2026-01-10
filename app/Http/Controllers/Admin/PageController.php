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
        // Delete old image if exists
        if ($page->image) {
            Storage::delete('public/pages/' .  $page->image);
        }
        
        $image = $request->file('image');
        $imageName = time() . '_' .  Str::slug($validated['title_en']) . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/pages', $imageName);
        $validated['image'] = $imageName;
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