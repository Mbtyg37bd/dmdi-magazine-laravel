@php
  use App\Models\Ad;
  use Illuminate\Support\Str;
  use Carbon\Carbon;

  // Input (allowed):
  // - position: slot identifier (ex: 'home-top')
  // - placement: 'search'|'dashboard'|'article'
  // - placement_target: slug or id when placement == 'article'
  // - showFallback: bool (optional) -> only show fallback image when true

  $position = $position ?? ($slot ?? null);
  $placement = $placement ?? null;
  $placementTarget = $placement_target ?? ($placement_target ?? null);
  $showFallback = $showFallback ?? false; // default: don't show fallback

  $ad = null;
  try {
      $query = Ad::query()->active();

      if ($placement === 'article' && $placementTarget) {
          $query->where('placement', 'article')
                ->where('placement_target', $placementTarget);
      } elseif ($placement) {
          if ($position) {
              $query->where('placement', $placement)
                    ->where('position', $position);
          } else {
              $query->where('placement', $placement);
          }
      } elseif ($position) {
          $query->where('position', $position);
      }

      $ad = $query->orderBy('priority')->first();

      // fallback position-only search (if placement search failed but position exists)
      if (!$ad && $position) {
          $ad = Ad::active()->where('position', $position)->orderBy('priority')->first();
      }

      // Do not show admin-only ads on public pages
      $isAdminContext = request()->is('admin/*') || (request()->route() && Str::startsWith(optional(request()->route())->getName(), 'admin.'));
      if ($ad && $ad->placement === 'dashboard' && !$isAdminContext) {
          $ad = null;
      }
  } catch (\Throwable $e) {
      \Log::warning('Ad partial query failed: ' . $e->getMessage());
      $ad = null;
  }

  // Optional fallback map (only used when $showFallback === true)
  $fallback = $fallback ?? [
      'search-ad-1' => asset('images/ads/ad-1.png'),
      'search-ad-2' => asset('images/ads/ad-2.png'),
      'home-top'    => asset('images/ads/ad-home-top.png'),
  ];

  // Determine output values
  if ($ad && $ad->image_path) {
      $img = $ad->imageUrl();
      $href = route('ads.out', $ad->id);
      $alt  = $ad->name ?? 'Advertisement';
  } else {
      if ($showFallback) {
          if ($position && isset($fallback[$position])) {
              $img = $fallback[$position];
          } else {
              $img = reset($fallback);
          }
          $href = $href ?? '#';
          $alt  = 'Advertisement';
      } else {
          // nothing to render
          $img = null;
          $href = null;
          $alt = null;
      }
  }
@endphp

@if($img)
  <div class="ad-slot text-center my-3" aria-label="Advertisement">
    <a href="{{ $href }}" @if(Str::startsWith($href, 'http')) target="_blank" rel="noopener noreferrer" @endif>
      <img src="{{ $img }}" alt="{{ e($alt) }}" loading="lazy" decoding="async"
           style="max-width:100%; height:auto; display:inline-block; border:1px solid #eee; border-radius:6px;">
    </a>
  </div>
@endif