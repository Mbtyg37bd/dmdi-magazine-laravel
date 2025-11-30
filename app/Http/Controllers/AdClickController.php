<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\RedirectResponse;

class AdClickController extends Controller
{
    /**
     * Increment click_count and redirect to ad URL (external).
     * route: GET out/ad/{ad}
     */
    public function out(Ad $ad): RedirectResponse
    {
        try {
            // increment safely
            $ad->increment('click_count');
        } catch (\Throwable $e) {
            // jangan gagal total kalau DB read-only, tapi log jika perlu
            \Log::warning('Failed to increment ad click_count: '.$e->getMessage());
        }

        // if URL set, redirect there; otherwise redirect home
        $url = $ad->url ?? url('/');
        return redirect()->away($url);
    }
}