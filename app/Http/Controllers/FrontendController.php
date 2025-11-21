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
        
        // Get related articles (same category)
        $relatedArticles = Article::where('category_id', $article->category_id)
                                ->where('id', '!=', $article->id)
                                ->where('is_published', true)
                                ->orderBy('created_at', 'desc')
                                ->take(4)
                                ->get();

        return view('frontend.article', compact('article', 'relatedArticles', 'locale'));
    }

    public function showCategory($locale, $category)
    {
        // Set locale for category pages as well
        app()->setLocale($locale);
        session(['app_lang' => $locale]);

        // Implementasi halaman kategori nanti
        return "Category page for: " . $category . " in " . $locale;
    }
}