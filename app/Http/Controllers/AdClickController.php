<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\AdClick;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class AdClickController extends Controller
{
    /**
     * Increment click_count, log the click to ad_clicks, and redirect to ad URL (external).
     * route: GET out/ad/{ad}
     */
    public function out(Ad $ad): RedirectResponse
    {
        Log::info('AdClickController::out called for ad_id=' . $ad->id . ' url=' . ($ad->url ?? '-'));

        try {
            $ad->increment('click_count');
            Log::info('Ad click_count incremented for ad_id=' . $ad->id);
        } catch (\Throwable $e) {
            Log::warning('Failed to increment ad click_count: '.$e->getMessage());
        }

        try {
            AdClick::create([
                'ad_id'      => $ad->id,
                'ip'         => request()->ip(),
                'user_agent' => request()->userAgent(),
                'referrer'   => request()->headers->get('referer'),
            ]);
            Log::info('AdClick created for ad_id=' . $ad->id);
        } catch (\Throwable $e) {
            Log::warning('Failed to log ad click: '.$e->getMessage());
        }

        $url = $ad->url ?? url('/');
        return redirect()->away($url);
    }
}