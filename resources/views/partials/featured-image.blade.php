@php
/**
 * Usage:
 * @include('partials.featured-image', [
 *   'path' => $article->featured_image, // relative path in storage/app/public
 *   'alt' => $article->title_id ?? 'Featured image',
 *   'class' => 'img-fluid rounded',
 *   'sizes' => '(max-width: 768px) 100vw, 1200px'  // optional sizes attribute
 * ])
 */
$path = $path ?? null;
$alt = $alt ?? '';
$cssClass = $class ?? 'img-fluid';
$sizesAttr = $sizes ?? '(max-width: 768px) 100vw, 1200px';
$placeholder = asset('images/placeholder.png'); // ensure this file exists in public/images/

if ($path && Storage::disk('public')->exists($path)) {
    $basename = basename($path);
    $p1200 = 'uploads/articles/1200/' . $basename;
    $p768  = 'uploads/articles/768/' . $basename;
    $p480  = 'uploads/articles/480/' . $basename;
    $pthumb= 'uploads/articles/thumb/' . $basename;

    $p1200w = preg_replace('/\.[^.]+$/', '.webp', $p1200);
    $p768w  = preg_replace('/\.[^.]+$/', '.webp', $p768);
    $p480w  = preg_replace('/\.[^.]+$/', '.webp', $p480);

    $has1200 = Storage::disk('public')->exists($p1200);
    $has768  = Storage::disk('public')->exists($p768);
    $has480  = Storage::disk('public')->exists($p480);
    $hasThumb= Storage::disk('public')->exists($pthumb);

    $has1200w = Storage::disk('public')->exists($p1200w);
    $has768w  = Storage::disk('public')->exists($p768w);
    $has480w  = Storage::disk('public')->exists($p480w);

    $srcset_jpg = collect([])
        ->when($has480, fn($c) => $c->push(asset('storage/' . $p480) . ' 480w'))
        ->when($has768, fn($c) => $c->push(asset('storage/' . $p768) . ' 768w'))
        ->when($has1200, fn($c) => $c->push(asset('storage/' . $p1200) . ' 1200w'))
        ->implode(', ');

    $srcset_webp = collect([])
        ->when($has480w, fn($c) => $c->push(asset('storage/' . $p480w) . ' 480w'))
        ->when($has768w, fn($c) => $c->push(asset('storage/' . $p768w) . ' 768w'))
        ->when($has1200w, fn($c) => $c->push(asset('storage/' . $p1200w) . ' 1200w'))
        ->implode(', ');

    $fallback = $has1200 ? asset('storage/' . $p1200)
              : ($has768 ? asset('storage/' . $p768)
              : ($has480 ? asset('storage/' . $p480)
              : asset('storage/' . $path)));
} else {
    $fallback = $placeholder;
    $srcset_jpg = '';
    $srcset_webp = '';
}
@endphp

<picture>
    @if(!empty($srcset_webp))
        <source type="image/webp" srcset="{{ $srcset_webp }}" sizes="{{ $sizesAttr }}">
    @endif

    @if(!empty($srcset_jpg))
        <source type="image/jpeg" srcset="{{ $srcset_jpg }}" sizes="{{ $sizesAttr }}">
    @endif

    <img
        src="{{ $fallback }}"
        alt="{{ e($alt) }}"
        class="{{ $cssClass }}"
        loading="lazy"
        decoding="async"
        style="width:100%;height:auto;object-fit:cover;"
    />
</picture>