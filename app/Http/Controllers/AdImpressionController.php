<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdImpressionController extends Controller
{
    /**
     * POST /ads/impression/{ad}
     * Called by frontend JS when an ad image becomes visible.
     */
    public function store(Request $request, Ad $ad)
    {
        try {
            $ad->increment('impression_count');
        } catch (\Throwable $e) {
            \Log::warning('Failed to increment ad impression: ' . $e->getMessage());
        }

        return response()->noContent(); // 204
    }
}