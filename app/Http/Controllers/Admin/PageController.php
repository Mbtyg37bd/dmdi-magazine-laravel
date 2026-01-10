<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        'title_en' => 'required|string|max: 255',
        'slug' => 'nullable|string|max:255|unique:pages,slug',
        'content_id' => 'nullable|string',
        'content_en' => 'nullable|string',
        'meta_description_id' => 'nullable|string|max:255',
        'meta_description_en' => 'nullable|string|max:255',
        'is_active' => 'nullable|boolean',
        'show_in_footer' => 'nullable|boolean',  // ← TAMBAHKAN
        'footer_order' => 'nullable|integer|min:0',  // ← TAMBAHKAN
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
        $validated['slug'] = $originalSlug . '-' . $counter;
        $counter++;
    }

    $validated['is_active'] = $request->has('is_active') ? 1 : 0;
    $validated['show_in_footer'] = $request->has('show_in_footer') ? 1 : 0;  // ← TAMBAHKAN
    $validated['footer_order'] = $request->input('footer_order', 0);  // ← TAMBAHKAN

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
            'title_en' => 'required|string|max: 255',
            'slug' => 'nullable|string|max: 255|unique:pages,slug,' . $page->id,
            'content_id' => 'nullable|string',
            'content_en' => 'nullable|string',
            'meta_description_id' => 'nullable|string|max:255',
            'meta_description_en' => 'nullable|string|max: 255',
            'is_active' => 'nullable|boolean',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title_en']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $page->update($validated);

        return redirect()->route('admin.pages.index')
                        ->with('success', 'Halaman berhasil diperbarui!');
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('admin.pages.index')
                        ->with('success', 'Halaman berhasil dihapus!');
    }
}