@php
  use App\Models\Ad;
  use Illuminate\Support\Str;

  // Allowed input:
  // - position: string (legacy slot identifier, e.g. 'search-ad-1', 'home-top')
  // - placement: string (one of 'search','dashboard','article')
  // - placement_target: string (slug or id when placement == 'article')
  //
  // Examples of include:
  // - @include('layouts.partials.ad', ['position' => 'search-ad-1'])
  // - @include('layouts.partials.ad', ['placement' => 'search'])
  // - @include('layouts.partials.ad', ['placement' => 'article', 'placement_target' => $article->slug])
  //

  $position = $position ?? ($slot ?? null);
  $placement = $placement ?? null;
  $placementTarget = $placement_target ?? ($placement_target ?? null);

  $ad = null;
  try {
      $query = Ad::query()->active();

      if ($placement === 'article' && $placementTarget) {
          // exact match for article-targeted ad
          $query->where('placement', 'article')
                ->where('placement_target', $placementTarget);
      } elseif ($placement) {
          // placement-based: prefer placement+position if both provided
          if ($position) {
              $query->where('placement', $placement)
                    ->where('position', $position);
          } else {
              $query->where('placement', $placement);
          }
      } elseif ($position) {
          // legacy: lookup by position
          $query->where('position', $position);
      }

      $ad = $query->orderBy('priority')->first();

      // fallback: if nothing found but we have a position, try fallback to position-only search
      if (!$ad && $position) {
          $ad = Ad::active()->where('position', $position)->orderBy('priority')->first();
      }
  } catch (\Throwable $e) {
      // On error, gracefully fallback to static banner
      \Log::warning('Ad partial query failed: ' . $e->getMessage());
      $ad = null;
  }

  // Fallback static images by common position keys (you can extend)
  $fallback = $fallback ?? [
      'search-ad-1' => asset('images/ads/ad-1.png'),
      'search-ad-2' => asset('images/ads/ad-2.png'),
      'home-top'    => asset('images/ads/ad-home-top.png'),
  ];

  if ($ad && $ad->image_path) {
      $img = $ad->imageUrl();
      $href = route('ads.out', $ad->id);
      $alt  = $ad->name ?? 'Advertisement';
  } else {
      // If no DB ad, try to show fallback based on provided position, else the first fallback
      if ($position && isset($fallback[$position])) {
          $img = $fallback[$position];
      } else {
          // pick a default fallback (first value)
          $img = reset($fallback);
      }
      $href = $href ?? '#';
      $alt  = 'Advertisement';
  }
@endphp

<div class="ad-slot text-center my-3" aria-label="Advertisement">
  <a href="{{ $href }}" target="_blank" rel="noopener noreferrer">
    <img src="{{ $img }}" alt="{{ e($alt) }}" loading="lazy" decoding="async"
         style="max-width:100%; height:auto; display:inline-block; border:1px solid #eee; border-radius:6px;">
  </a>
</div>