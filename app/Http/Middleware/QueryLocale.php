<?php
name=app/Http/Middleware/QueryLocale.php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class QueryLocale
{
    /**
     * Set locale using (in order of precedence):
     * 1) route parameter 'locale' (e.g. /en/...)
     * 2) first URI segment (e.g. /en...)
     * 3) query parameter 'lang' (e.g. ?lang=en)
     * 4) session stored 'app_lang'
     * 5) default 'id'
     */
    public function handle(Request $request, Closure $next)
    {
        // 1) route parameter (preferred for routes like /{locale}/...)
        $routeLocale = null;
        if ($request->route()) {
            try {
                $routeLocale = $request->route('locale');
            } catch (\Throwable $e) {
                $routeLocale = null;
            }
        }

        // 2) first URI segment fallback (handles plain /en when route param not present)
        $segmentLocale = $request->segment(1);

        // 3) query param
        $queryLocale = $request->query('lang');

        // 4) session stored locale
        $sessionLocale = session('app_lang');

        $allowed = ['id', 'en'];

        if ($routeLocale && in_array($routeLocale, $allowed, true)) {
            $lang = $routeLocale;
        } elseif ($segmentLocale && in_array($segmentLocale, $allowed, true)) {
            $lang = $segmentLocale;
        } elseif ($queryLocale && in_array($queryLocale, $allowed, true)) {
            $lang = $queryLocale;
        } elseif ($sessionLocale && in_array($sessionLocale, $allowed, true)) {
            $lang = $sessionLocale;
        } else {
            $lang = 'id';
        }

        app()->setLocale($lang);
        // persist last choice
        session(['app_lang' => $lang]);

        return $next($request);
    }
}