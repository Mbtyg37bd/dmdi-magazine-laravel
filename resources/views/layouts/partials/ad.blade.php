@php
  use App\Models\Ad;
  use Illuminate\Support\Str;

  $position = $position ?? ($slot ?? 'search-ad-1');

  $ad = null;
  try {
      $ad = Ad::where('position', $position)->active()->orderBy('priority')->first();
  } catch (\Throwable $e) {
      $ad = null;
  }

  $fallback = [
      'search-ad-1' => asset('images/ads/ad-1.png'),
      'search-ad-2' => asset('images/ads/ad-2.png'),
      'home-top'    => asset('images/ads/ad-home-top.png'),
  ];

  // If DB ad present, build route to click tracker. Otherwise fallback to static image + optional link.
  if ($ad && $ad->image_path) {
      $img = $ad->imageUrl();
      // use tracking route to increment clicks then redirect
      $href = route('ads.out', $ad->id);
  } else {
      $img = $fallback[$position] ?? $fallback['search-ad-1'];
      $href = '#'; // or change to external link if you want
  }

  $alt  = $ad->name ?? 'Advertisement';
@endphp

<div class="ad-slot text-center my-3" aria-label="Advertisement">
  <a href="{{ $href }}" target="_blank" rel="noopener noreferrer">
    <img src="{{ $img }}" alt="{{ e($alt) }}" loading="lazy" decoding="async" style="max-width:100%; height:auto; display:inline-block; border:1px solid #eee; border-radius:6px;">
  </a>
</div>