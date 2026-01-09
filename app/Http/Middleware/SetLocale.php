<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request. 
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get locale from route parameter
        $locale = $request->route('locale');
        
        // Validate and set locale (only 'id' or 'en' allowed)
        if (in_array($locale, ['id', 'en'])) {
            App:: setLocale($locale);
        } else {
            // Default to Indonesian
            App::setLocale('id');
        }
        
        return $next($request);
    }
}