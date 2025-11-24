<?php
namespace App\Http\Controllers;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdClickController extends Controller
{
    public function out(Ad $ad)
    {
        // contoh: increment counter (but better store in separate table for analytics)
        try {
            $ad->increment('click_count');
        } catch (\Throwable $e) {
            Log::warning('Ad click log failed: '.$e->getMessage());
        }

        return redirect()->away($ad->url ?? '/');
    }
}