@php
/**
 * Partial: ad.blade.php
 * Usage:
 *   @include('layouts.partials.ad', ['position' => 'search-ad-1'])
 *   or
 *   @include('layouts.partials.ad', ['slot' => 'search-ad-1'])
 *
 * Behavior:
 * - Try to load an active Ad record from DB by position.
 * - If found and has image_path, use Ad::imageUrl() and Ad->url.
 * - On any error or if no DB ad, fall back to public/images/ads/* files.
 *
 * Note:
 * - This partial wraps DB read in try/catch so pages don't break when DB/migrations not present.
 * - Image paths stored by admin controller are expected to be like 'storage/ads/filename.png'
 *   or absolute URLs; fallback expects public/images/ads/<name>.png
 */
use App\Models\Ad;

$position = $position ?? ($slot ?? 'search-ad-1');

$ad = null;
try {
    // safe DB read (will throw if DB unavailable; catch below)
    $ad = Ad::where('position', $position)->active()->orderBy('priority')->first();
} catch (\Throwable $e) {
    $ad = null;
}

// fallback mapping for positions -> static images in public/images/ads/
$fallback = [
    'search-ad-1' => asset('images/ads/ad-1.png'),
    'search-ad-2' => asset('images/ads/ad-2.png'),
    'home-top'    => asset('images/ads/ad-home-top.png'),
];

$img = ($ad && $ad->image_path) ? $ad->imageUrl() : ($fallback[$position] ?? $fallback['search-ad-1']);
$link = ($ad && $ad->url) ? $ad->url : '#';
$alt  = $ad->name ?? 'Advertisement';
@endphp

<div class="ad-slot text-center my-3" aria-label="Advertisement">
  <a href="{{ $link }}" target="_blank" rel="noopener noreferrer">
    <img src="{{ $img }}" alt="{{ e($alt) }}" style="max-width:100%; height:auto; display:inline-block; border:1px solid #eee; border-radius:6px;">
  </a>
</div>