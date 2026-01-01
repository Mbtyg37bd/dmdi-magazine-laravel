<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function showArticle($locale, $slug)
    {
        // Set locale dari route param dan simpan ke session
        app()->setLocale($locale);
        session(['app_lang' => $locale]);

        $article = Article::where('slug', $slug)
                          ->where('is_published', true)
                          ->firstOrFail();
        
        // Increment view count
        $article->increment('view_count');
        
        // Get related articles (same category)
        $relatedArticles = Article::where('category_id', $article->category_id)
                                ->where('id', '!=', $article->id)
                                ->where('is_published', true)
                                ->orderBy('created_at', 'desc')
                                ->take(4)
                                ->get();

        return view('frontend.article', compact('article', 'relatedArticles', 'locale'));
    }

    public function showCategory($locale, $slug)
    {
        // Set locale for category pages
        app()->setLocale($locale);
        session(['app_lang' => $locale]);

        // Find category by slug
        $category = Category::where('slug', $slug)
                           ->where('is_active', true)
                           ->firstOrFail();

        // Get articles in this category with pagination
        $articles = Article:: where('category_id', $category->id)
                          ->where('is_published', true)
                          ->orderBy('created_at', 'desc')
                          ->paginate(12);

        // Get all categories for sidebar
        $categories = Category::where('is_active', true)->get();

        // Get popular articles (by view count)
        $popularArticles = Article::where('is_published', true)
                                 ->orderBy('view_count', 'desc')
                                 ->take(5)
                                 ->get();

        return view('frontend.category', compact('category', 'articles', 'categories', 'popularArticles', 'locale'));
    }
}