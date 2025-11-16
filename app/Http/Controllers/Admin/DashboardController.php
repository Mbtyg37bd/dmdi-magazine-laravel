<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_articles' => Article::count(),
            'published_articles' => Article::where('is_published', true)->count(),
            'draft_articles' => Article::where('is_published', false)->count(),
            'total_categories' => Category::count(),
            'featured_articles' => Article::where('is_featured', true)->count(),
        ];

        $recent_articles = Article::with('category')
                                ->orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();

        return view('admin.dashboard', compact('stats', 'recent_articles'));
    }
}