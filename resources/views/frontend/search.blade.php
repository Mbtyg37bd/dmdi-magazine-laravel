@extends('layouts.frontend')

@section('title', ($q ? ($locale == 'id' ? "Hasil Pencarian: $q" : "Search results: $q") : ($locale == 'id' ? 'Pencarian' : 'Search')) . ' - DMDI')

@section('content')
<div class="container py-4">
  <!-- Search header: input + sort -->
  <div class="search-top d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
    <form action="{{ route('frontend.search', ['locale' => $locale]) }}" method="GET" class="d-flex w-100" role="search">
      <input name="q" type="search" value="{{ request()->query('q', $q ?? '') }}" class="form-control me-2" placeholder="{{ $locale == 'id' ? 'Cari artikel...' : 'Search articles...' }}" aria-label="Search" />
      <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
    </form>

    <div class="d-flex align-items-center gap-2">
      <div class="text-muted small">{{ ($articles instanceof \Illuminate\Pagination\LengthAwarePaginator ? $articles->total() : (is_countable($articles) ? count($articles) : 0)) }} {{ $locale == 'id' ? 'hasil untuk' : 'results for' }} <strong class="ms-1">{{ e($q) }}</strong></div>

      <form id="sortForm" class="d-flex align-items-center ms-3" aria-label="Sort">
        <label for="sort" class="me-2 small text-muted d-none d-md-inline">{{ $locale == 'id' ? 'Urutkan' : 'Sort' }}</label>
        <select id="sort" name="sort" class="form-select form-select-sm" onchange="document.getElementById('sortForm').submit()">
          <option value="relevance"{{ request('sort') === 'relevance' ? ' selected' : '' }}>Relevance</option>
          <option value="newest"{{ request('sort') === 'newest' ? ' selected' : '' }}>{{ $locale == 'id' ? 'Terbaru' : 'Newest' }}</option>
          <option value="oldest"{{ request('sort') === 'oldest' ? ' selected' : '' }}>{{ $locale == 'id' ? 'Terlama' : 'Oldest' }}</option>
        </select>
      </form>
    </div>
  </div>

  <!-- Main grid -->
  <div id="searchGrid" class="row g-4">
    @php $adShown = false; @endphp

    @foreach($articles as $index => $article)
      <div class="col-6 col-md-4">
        <article class="search-card h-100">
          <a href="{{ url($locale . '/article/' . $article->slug) }}" class="text-decoration-none text-dark d-block h-100">
            @if(!empty($article->featured_image))
              <div class="thumb mb-2 overflow-hidden" style="height:160px;">
                <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $locale == 'id' ? $article->title_id : $article->title_en }}" class="w-100 h-100" style="object-fit:cover;">
              </div>
            @else
              <div class="thumb-placeholder mb-2" style="height:160px;background:#f5f5f5;"></div>
            @endif

            <div class="card-body p-0">
              <div class="mb-1 text-muted small">{{ $article->category->name ?? '' }} • {{ $article->created_at->format('M d, Y') }}</div>
              <h5 class="h6 mb-1">{{ \Illuminate\Support\Str::limit($locale == 'id' ? $article->title_id : $article->title_en, 80) }}</h5>
              <p class="text-muted small mb-0">{{ \Illuminate\Support\Str::limit($locale == 'id' ? $article->excerpt_id : $article->excerpt_en, 110) }}</p>
            </div>
          </a>
        </article>
      </div>

      <!-- Insert ad after the 6th item (desktop visual break) -->
      @if(($index + 1) == 6)
        <div class="col-12">
          @include('layouts.partials.ad', ['position' => 'search-ad-1'])
        </div>
        @php $adShown = true; @endphp
      @endif

      <!-- Insert second ad after 18th item -->
      @if(($index + 1) == 18)
        <div class="col-12">
          @include('layouts.partials.ad', ['position' => 'search-ad-2'])
        </div>
        @php $adShown = true; @endphp
      @endif
    @endforeach

    {{-- If we never showed an ad (e.g. total results < 6), show primary ad here --}}
    @if(!$adShown)
      <div class="col-12">
        @include('layouts.partials.ad', ['position' => 'search-ad-1'])
      </div>
    @endif
  </div>

  <!-- Pagination / See more -->
  <div class="mt-4 d-flex justify-content-center">
    @if($articles instanceof \Illuminate\Pagination\LengthAwarePaginator)
      <button id="loadMoreBtn" class="btn btn-outline-secondary" data-next-page="{{ $articles->nextPageUrl() }}">{{ $articles->hasMorePages() ? ($locale=='id' ? 'Lihat lebih banyak' : 'See more') : ($locale=='id' ? 'Tidak ada lagi' : 'No more') }}</button>
    @else
      <!-- fallback: no pagination -->
    @endif
  </div>
</div>
@endsection