<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request, $locale = 'id')
    {
        // Set locale
        app()->setLocale($locale);
        session(['app_lang' => $locale]);

        // Get search query
        $query = $request->input('q', '');
        $categoryFilter = $request->input('category', '');

        // Build search query
        $articlesQuery = Article::where('is_published', true);

        if (! empty($query)) {
            $articlesQuery->where(function ($q) use ($query, $locale) {
                if ($locale == 'id') {
                    $q->where('title_id', 'LIKE', '%' . $query . '%')
                      ->orWhere('excerpt_id', 'LIKE', '%' . $query . '%')
                      ->orWhere('content_id', 'LIKE', '%' . $query . '%');
                } else {
                    $q->where('title_en', 'LIKE', '%' . $query . '%')
                      ->orWhere('excerpt_en', 'LIKE', '%' . $query . '%')
                      ->orWhere('content_en', 'LIKE', '%' . $query . '%');
                }
            });
        }

        // Filter by category if specified
        if (! empty($categoryFilter)) {
            $articlesQuery->where('category_id', $categoryFilter);
        }

        // Get results with pagination
        $articles = $articlesQuery->orderBy('created_at', 'desc')->paginate(12);

        // Get all categories for filter
        $categories = Category::where('is_active', true)->get();

        // Get popular articles for sidebar
        $popularArticles = Article::where('is_published', true)
                                 ->orderBy('view_count', 'desc')
                                 ->take(5)
                                 ->get();

        return view('frontend.search', compact('articles', 'categories', 'popularArticles', 'query', 'categoryFilter', 'locale'));
    }
}