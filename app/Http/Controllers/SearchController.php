<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display search results.
     * Route: GET /{locale}/search?q=...
     */
    public function index(Request $request, $locale)
    {
        app()->setLocale($locale);
        session(['app_lang' => $locale]);

        $q = trim($request->query('q', ''));

        if ($q === '') {
            // empty query -> no results (or optionally show popular)
            $articles = collect();
            return view('frontend.search', compact('articles', 'q', 'locale'));
        }

        // choose fields depending on locale; adjust field names to your Article model
        $titleField = $locale === 'en' ? 'title_en' : 'title_id';
        $excerptField = $locale === 'en' ? 'excerpt_en' : 'excerpt_id';

        $term = '%' . str_replace('%', '\\%', $q) . '%';

        $articles = Article::where('is_published', true)
            ->where(function ($query) use ($titleField, $excerptField, $term) {
                $query->where($titleField, 'like', $term)
                      ->orWhere($excerptField, 'like', $term);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->appends(['q' => $q]);

        return view('frontend.search', compact('articles', 'q', 'locale'));
    }
}