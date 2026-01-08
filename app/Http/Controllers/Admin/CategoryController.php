<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories
     */
    public function index()
    {
        $categories = Category::withCount('articles')
                             ->orderBy('created_at', 'desc')
                             ->paginate(15);

        return view('admin/categories/index', compact('categories'));
    }

    /**
     * Show the form for creating a new category
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created category
     */
public function store(Request $request)
{
    $validated = $request->validate([
        'name_id' => 'required|string|max:255',
        'name_en' => 'required|string|max: 255|unique:categories,name_en',
        'description_id' => 'nullable|string',
        'description_en' => 'nullable|string',
        'is_active' => 'nullable|boolean',
        'show_in_main_menu' => 'nullable|boolean',
        'show_in_dropdown' => 'nullable|boolean',
    ]);

    $slug = \Str::slug($validated['name_en']);
    $originalSlug = $slug;
    $counter = 1;
    
    while (\App\Models\Category::where('slug', $slug)->exists()) {
        $slug = $originalSlug . '-' . $counter;
        $counter++;
    }
    
    $validated['slug'] = $slug;
    $validated['is_active'] = $request->has('is_active') ? 1 : 0;
    $validated['show_in_main_menu'] = $request->has('show_in_main_menu') ? 1 : 0;
    $validated['show_in_dropdown'] = $request->has('show_in_dropdown') ? 1 : 0;
    
    // Backward compatibility
    $validated['show_in_header'] = $validated['show_in_main_menu'] || $validated['show_in_dropdown'];

    \App\Models\Category::create($validated);

    return redirect()->route('admin.categories.index')
                    ->with('success', 'Kategori berhasil dibuat! ');
}

    /**
     * Display the specified category
     */
    public function show(Category $category)
    {
        $category->loadCount('articles');
        $recentArticles = $category->articles()
                                  ->orderBy('created_at', 'desc')
                                  ->take(10)
                                  ->get();

        return view('admin.categories.show', compact('category', 'recentArticles'));
    }

    /**
     * Show the form for editing the specified category
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category
     */
public function update(Request $request, \App\Models\Category $category)
{
    $validated = $request->validate([
        'name_id' => 'required|string|max:255',
        'name_en' => 'required|string|max:255|unique:categories,name_en,' . $category->id,
        'description_id' => 'nullable|string',
        'description_en' => 'nullable|string',
        'is_active' => 'nullable|boolean',
        'show_in_main_menu' => 'nullable|boolean',
        'show_in_dropdown' => 'nullable|boolean',
    ]);

    $validated['is_active'] = $request->has('is_active') ? 1 : 0;
    $validated['show_in_main_menu'] = $request->has('show_in_main_menu') ? 1 : 0;
    $validated['show_in_dropdown'] = $request->has('show_in_dropdown') ? 1 : 0;
    
    // Backward compatibility
    $validated['show_in_header'] = $validated['show_in_main_menu'] || $validated['show_in_dropdown'];

    $category->update($validated);

    return redirect()->route('admin.categories.index')
                    ->with('success', 'Kategori berhasil diperbarui!');
}

    /**
     * Remove the specified category
     */
    public function destroy(Category $category)
    {
        // Check if category has articles
        if ($category->articles()->count() > 0) {
            return redirect()->route('admin.categories.index')
                           ->with('error', 'Tidak dapat menghapus kategori yang masih memiliki artikel!');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
                        ->with('success', 'Kategori berhasil dihapus!');
    }
}