@extends('layouts.frontend')

{{-- Meta tags for social sharing --}}
@section('meta')
    @php
        // fallback image url
        $ogImage = $article->featured_image ? asset('storage/' . $article->featured_image) : asset('images/placeholder.png');
        $ogDesc = $article->excerpt_id ? strip_tags($article->excerpt_id) : (Str::limit(strip_tags($article->content_id), 160));
        $canonical = url(app()->getLocale() . '/article/' . $article->slug);
    @endphp

    <link rel="canonical" href="{{ $canonical }}" />
    <meta name="description" content="{{ e($ogDesc) }}">

    <!-- Open Graph -->
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ e($article->title_id) }}" />
    <meta property="og:description" content="{{ e($ogDesc) }}" />
    <meta property="og:url" content="{{ $canonical }}" />
    <meta property="og:image" content="{{ $ogImage }}" />
    <meta property="og:image:alt" content="{{ e($article->title_id) }}" />
    <meta property="og:site_name" content="{{ config('app.name', 'DMDI') }}" />

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ e($article->title_id) }}" />
    <meta name="twitter:description" content="{{ e($ogDesc) }}" />
    <meta name="twitter:image" content="{{ $ogImage }}" />
@endsection

@section('title', $article->title_id)

@section('content')
<main class="container py-4">
  <article class="article-single mx-auto" style="max-width:1100px;">
    <header class="article-header mb-4">
      <h1 class="display-5 fw-bold mb-2" style="letter-spacing: -0.02em;">{{ $article->title_id }}</h1>
      <p class="text-muted mb-3" style="font-size:0.95rem;">
        Oleh <strong>{{ $article->author }}</strong> • {{ $article->created_at->format('d M Y') }}
      </p>

      <div class="article-featured mb-3" style="width:100%; aspect-ratio: 16/9; overflow:hidden; border-radius:6px;">
        @include('partials.featured-image', [
            'path' => $article->featured_image,
            'alt' => $article->title_id,
            'class' => 'w-100 h-100 d-block',
            'sizes' => '(max-width: 768px) 100vw, 1100px'
        ])
      </div>
    </header>

    <div class="article-body" style="font-size:1.05rem; line-height:1.75; color:#222;">
      {!! $article->content_id !!}
    </div>

    <footer class="article-footer mt-5">
      <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start">
        <div class="mt-3">
          <small class="text-muted">Kategori: {{ $article->category->name_id ?? '-' }}</small>
        </div>

        <div class="mt-3">
          {{-- placeholder for social share buttons --}}
          <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($canonical) }}" target="_blank" class="btn btn-outline-secondary btn-sm me-2">
            <i class="bi bi-facebook"></i> Share
          </a>
          <a href="https://twitter.com/intent/tweet?url={{ urlencode($canonical) }}&text={{ urlencode($article->title_id) }}" target="_blank" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-twitter"></i> Tweet
          </a>
        </div>
      </div>
    </footer>
  </article>
</main>

{{-- JSON-LD minimal --}}
@push('scripts')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": {!! json_encode($article->title_id) !!},
  "image": {!! json_encode($ogImage) !!},
  "author": {
    "@type": "Person",
    "name": {!! json_encode($article->author) !!}
  },
  "datePublished": {!! json_encode($article->created_at->toIso8601String()) !!},
  "description": {!! json_encode($ogDesc) !!}
}
</script>
@endpush
@endsection