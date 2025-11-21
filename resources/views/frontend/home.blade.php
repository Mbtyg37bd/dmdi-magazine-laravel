@extends('layouts.frontend')

@section('title', $locale == 'id' ? 'Beranda - DMDI Magazine' : 'Home - DMDI Magazine')

@section('meta')
<meta name="description" content="{{ $locale == 'id' ? 'DMDI Magazine - Media terpercaya untuk berita dan informasi terkini dalam Bahasa Indonesia dan English' : 'DMDI Magazine - Trusted media for the latest news and information in Indonesian and English' }}">
<meta property="og:title" content="{{ $locale == 'id' ? 'Beranda - DMDI Magazine' : 'Home - DMDI Magazine' }}">
<meta property="og:description" content="{{ $locale == 'id' ? 'Media terpercaya untuk berita dan informasi terkini' : 'Trusted media for the latest news and information' }}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta name="twitter:card" content="summary_large_image">
@endsection

@section('content')
@php
  $featured = $featuredArticles ?? collect();
  $latest = $latestArticles ?? collect();
@endphp

<section class="hero-section py-4">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-8">
        @if($featured->count())
          @php $hero = $featured->first(); @endphp
          <div class="main-featured-article">
            <a href="{{ url($locale . '/article/' . $hero->slug) }}" class="d-block">
              @if($hero->featured_image)
                <img src="{{ asset('storage/' . $hero->featured_image) }}" alt="{{ $locale == 'id' ? $hero->title_id : $hero->title_en }}">
              @else
                <div style="height:520px; background:#f3f4f6;"></div>
              @endif
              <div class="hero-overlay">
                <div class="badge bg-light text-dark small mb-2">{{ $hero->category->name ?? '' }}</div>
                <h2 class="article-title">{{ $locale == 'id' ? $hero->title_id : $hero->title_en }}</h2>
                @if(!empty($hero->excerpt_id) || !empty($hero->excerpt_en))
                  <p class="text-white/90 mt-2">{{ $locale == 'id' ? $hero->excerpt_id : $hero->excerpt_en }}</p>
                @endif
              </div>
            </a>
          </div>

          <!-- featured row similar to Esquire: two stacked big rows -->
          <div class="featured-row">
            @foreach($featured->skip(1)->take(3) as $f)
              <article class="featured-card">
                <a href="{{ url($locale . '/article/' . $f->slug) }}" class="text-decoration-none text-dark">
                  @if($f->featured_image)
                    <img src="{{ asset('storage/' . $f->featured_image) }}" alt="{{ $locale == 'id' ? $f->title_id : $f->title_en }}">
                  @endif
                  <div class="meta">
                    <div class="text-muted small">{{ $f->created_at->format('M d, Y') }}</div>
                    <h3 class="title">{{ \Illuminate\Support\Str::limit($locale == 'id' ? $f->title_id : $f->title_en, 90) }}</h3>
                  </div>
                </a>
              </article>
            @endforeach
          </div>
        @endif
      </div>

      <div class="col-lg-4">
        <aside>
          <div class="card-article mb-4">
            <h5 class="mb-3">Latest</h5>
            <div class="list-unstyled">
              @foreach($latest->take(6) as $a)
                <a href="{{ url($locale . '/article/' . $a->slug) }}" class="d-flex gap-3 mb-3 text-decoration-none text-dark">
                  <img src="{{ $a->featured_image ? asset('storage/' . $a->featured_image) : asset('images/placeholder-120x80.jpg') }}" alt="" style="width:88px; height:62px; object-fit:cover; border-radius:6px;">
                  <div>
                    <div class="text-muted small">{{ $a->category->name ?? '' }}</div>
                    <div class="fw-semibold">{{ \Illuminate\Support\Str::limit($locale == 'id' ? $a->title_id : $a->title_en, 70) }}</div>
                  </div>
                </a>
              @endforeach
            </div>
          </div>

          <div class="card-article mb-4">
            <h5 class="mb-3">Popular</h5>
            <ul class="list-unstyled">
              @foreach($latest->slice(0,5) as $p)
                <li class="mb-3">
                  <a href="{{ url($locale . '/article/' . $p->slug) }}" class="text-decoration-none text-dark d-flex gap-3 align-items-center">
                    <img src="{{ $p->featured_image ? asset('storage/' . $p->featured_image) : asset('images/placeholder-80x60.jpg') }}" alt="" style="width:72px;height:52px;object-fit:cover;border-radius:6px;">
                    <div class="small">{{ \Illuminate\Support\Str::limit($locale == 'id' ? $p->title_id : $p->title_en, 80) }}</div>
                  </a>
                </li>
              @endforeach
            </ul>
          </div>

          <div class="ad-space card-article text-center">
            <small class="text-muted d-block mb-2">{{ $locale == 'id' ? 'IKLAN' : 'ADVERTISEMENT' }}</small>
            <div style="min-height:200px; background:#f8f8f8; border-radius:6px;"></div>
          </div>
        </aside>
      </div>
    </div>
  </div>
</section>

<!-- MOST READ -->
<section class="section-most-read container py-5">
  <h3 class="section-header font-display mb-3">{{ $locale == 'id' ? 'Paling Banyak Dibaca' : 'Most read' }}</h3>
  <div class="grid">
    @foreach($latest->slice(0,8) as $m)
      <div class="most-read-card">
        <a href="{{ url($locale . '/article/' . $m->slug) }}" class="text-decoration-none text-dark d-block">
          <img src="{{ $m->featured_image ? asset('storage/' . $m->featured_image) : asset('images/placeholder-400x300.jpg') }}" alt="">
          <div style="padding:10px;">
            <div class="text-muted small">{{ $m->category->name ?? '' }}</div>
            <div class="fw-semibold">{{ \Illuminate\Support\Str::limit($locale == 'id' ? $m->title_id : $m->title_en, 90) }}</div>
          </div>
        </a>
      </div>
    @endforeach
  </div>
</section>

<!-- GRID FEED -->
<section class="container py-5">
  <div class="row gx-4">
    <div class="col-lg-8">
      <div class="article-grid">
        @foreach($latest->slice(8)->take(12) as $art)
          <article class="card-article">
            <a href="{{ url($locale . '/article/' . $art->slug) }}" class="text-decoration-none text-dark d-block">
              <img src="{{ $art->featured_image ? asset('storage/' . $art->featured_image) : asset('images/placeholder-400x300.jpg') }}" alt="" style="width:100%; height:200px; object-fit:cover; border-radius:6px;">
              <div style="padding:12px;">
                <div class="text-muted small">{{ $art->category->name ?? '' }}</div>
                <h4 class="fw-bold mb-2">{{ \Illuminate\Support\Str::limit($locale == 'id' ? $art->title_id : $art->title_en, 120) }}</h4>
                <p class="text-muted small mb-0">{{ \Illuminate\Support\Str::limit($locale == 'id' ? $art->excerpt_id : $art->excerpt_en, 140) }}</p>
              </div>
            </a>
          </article>
        @endforeach
      </div>

      <div class="text-center mt-4">
        <a href="#" class="btn btn-outline-secondary">Load more</a>
      </div>
    </div>

    <aside class="col-lg-4">
      <div class="card-article">
        <h5 class="mb-3">{{ $locale == 'id' ? 'Populer' : 'Popular' }}</h5>
        <ul class="list-unstyled">
          @foreach($latest->take(6) as $p)
            <li class="mb-3 d-flex gap-3">
              <img src="{{ $p->featured_image ? asset('storage/' . $p->featured_image) : asset('images/placeholder-80x60.jpg') }}" alt="" style="width:84px; height:62px; object-fit:cover; border-radius:6px;">
              <div class="small">{{ \Illuminate\Support\Str::limit($locale == 'id' ? $p->title_id : $p->title_en, 90) }}</div>
            </li>
          @endforeach
        </ul>
      </div>

      <div class="mt-4 card-article">
        <h5 class="mb-3">{{ $locale == 'id' ? 'Ikuti Kami' : 'Follow us' }}</h5>
        <div class="d-flex gap-2">
          <a class="btn btn-outline-secondary btn-sm" href="#"><i class="bi bi-facebook"></i></a>
          <a class="btn btn-outline-secondary btn-sm" href="#"><i class="bi bi-twitter"></i></a>
          <a class="btn btn-outline-secondary btn-sm" href="#"><i class="bi bi-instagram"></i></a>
        </div>
      </div>
    </aside>
  </div>
</section>
@endsection