<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index($locale = 'id')
    {
        // Pastikan aplikasi menggunakan locale dari route param
        app()->setLocale($locale);
        session(['app_lang' => $locale]);

        // Get featured articles
        $featuredArticles = Article::where('is_published', true)
                                 ->where('is_featured', true)
                                 ->orderBy('created_at', 'desc')
                                 ->take(3)
                                 ->get();

        // Get latest articles
        $latestArticles = Article::where('is_published', true)
                               ->orderBy('created_at', 'desc')
                               ->take(9)
                               ->get();

        // Get categories
        $categories = Category::where('is_active', true)->get();

        return view('frontend.home', compact('featuredArticles', 'latestArticles', 'categories', 'locale'));
    }
}