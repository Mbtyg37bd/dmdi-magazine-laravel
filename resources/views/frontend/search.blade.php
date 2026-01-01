@extends('layouts.frontend')

@section('title', ($locale == 'id' ? 'Hasil Pencarian' :  'Search Results') . ((! empty($query)) ? ' - ' . $query :  '') . ' - DMDI Magazine')

@section('meta')
<meta name="description" content="{{ $locale == 'id' ? 'Hasil pencarian untuk: ' . $query : 'Search results for: ' . $query }}">
<meta property="og:title" content="{{ $locale == 'id' ? 'Hasil Pencarian' :  'Search Results' }} - DMDI Magazine">
<meta property="og:type" content="website">
<meta name="robots" content="noindex, follow">
@endsection

@section('content')
<!-- Search Header -->
<section class="search-header py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-4 text-center">
                    {{ $locale == 'id' ?  'Hasil Pencarian' : 'Search Results' }}
                </h1>
                
                <!-- Search Form -->
                <form action="{{ route('frontend.search', ['locale' => $locale]) }}" method="GET" class="mb-4">
                    <div class="input-group input-group-lg shadow-sm">
                        <input type="text" 
                               name="q" 
                               class="form-control" 
                               placeholder="{{ $locale == 'id' ? 'Cari artikel...' : 'Search articles.. .' }}"
                               value="{{ $query }}"
                               required>
                        <button class="btn btn-primary px-4" type="submit">
                            <i class="bi bi-search me-1"></i>
                            {{ $locale == 'id' ? 'Cari' : 'Search' }}
                        </button>
                    </div>
                </form>

                @if(! empty($query))
                    <div class="text-center">
                        <p class="text-muted mb-1">
                            {{ $locale == 'id' ? 'Menampilkan hasil untuk: ' : 'Showing results for:' }}
                        </p>
                        <h5 class="fw-bold">"{{ $query }}"</h5>
                        <p class="text-muted">
                            {{ $articles->total() }} {{ $locale == 'id' ? 'artikel ditemukan' : 'articles found' }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Search Results -->
<section class="container py-5">
    <div class="row gx-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Category Filter -->
            <div class="mb-4">
                <form action="{{ route('frontend.search', ['locale' => $locale]) }}" method="GET" class="d-flex gap-2 align-items-center flex-wrap">
                    <input type="hidden" name="q" value="{{ $query }}">
                    <label class="fw-semibold me-2">{{ $locale == 'id' ? 'Filter: ' : 'Filter: ' }}</label>
                    <select name="category" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                        <option value="">{{ $locale == 'id' ? 'Semua Kategori' : 'All Categories' }}</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $categoryFilter == $cat->id ? 'selected' : '' }}>
                                {{ $locale == 'id' ? $cat->name_id : $cat->name_en }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            @if($articles->count() > 0)
                <div class="row g-4">
                    @foreach($articles as $article)
                        <div class="col-md-6">
                            <article class="card border-0 shadow-sm h-100 hover-lift">
                                <a href="{{ url($locale . '/article/' . $article->slug) }}" class="text-decoration-none">
                                    @if($article->featured_image)
                                        <div style="height: 200px; overflow: hidden; border-radius: 0.375rem 0.375rem 0 0;">
                                            <img src="{{ asset('storage/' . $article->featured_image) }}" 
                                                 alt="{{ $locale == 'id' ? $article->title_id : $article->title_en }}"
                                                 class="w-100 h-100"
                                                 style="object-fit: cover;">
                                        </div>
                                    @else
                                        <div style="height: 200px; background:  linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%); border-radius: 0.375rem 0.375rem 0 0;"
                                             class="d-flex align-items-center justify-content-center">
                                            <i class="bi bi-image fs-1 text-muted"></i>
                                        </div>
                                    @endif
                                    
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge bg-primary me-2">{{ $locale == 'id' ? ($article->category->name_id ?? '') : ($article->category->name_en ?? '') }}</span>
                                            <small class="text-muted">{{ $article->created_at->format('M d, Y') }}</small>
                                        </div>
                                        
                                        <h5 class="card-title fw-bold text-dark mb-2">
                                            {{ \Illuminate\Support\Str::limit($locale == 'id' ? $article->title_id : $article->title_en, 70) }}
                                        </h5>
                                        
                                        <p class="card-text text-muted small mb-3">
                                            {{ \Illuminate\Support\Str::limit($locale == 'id' ? $article->excerpt_id : $article->excerpt_en, 100) }}
                                        </p>
                                        
                                        <div class="d-flex align-items-center justify-content-between">
                                            <small class="text-muted">
                                                <i class="bi bi-person me-1"></i>{{ $article->author }}
                                            </small>
                                            <small class="text-muted">
                                                <i class="bi bi-eye me-1"></i>{{ $article->view_count ?? 0 }}
                                            </small>
                                        </div>
                                    </div>
                                </a>
                            </article>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-5 d-flex justify-content-center">
                    {{ $articles->appends(['q' => $query, 'category' => $categoryFilter])->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-search fs-1 text-muted"></i>
                    <h5 class="text-muted mt-3">{{ $locale == 'id' ? 'Tidak ada hasil' : 'No results found' }}</h5>
                    <p class="text-muted">
                        {{ $locale == 'id' ? 'Coba gunakan kata kunci yang berbeda' : 'Try using different keywords' }}
                    </p>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <aside class="col-lg-4">
            <!-- Popular Articles -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">{{ $locale == 'id' ? 'Artikel Populer' : 'Popular Articles' }}</h5>
                    <ul class="list-unstyled">
                        @foreach($popularArticles as $popular)
                            <li class="mb-3">
                                <a href="{{ url($locale . '/article/' . $popular->slug) }}" class="text-decoration-none text-dark d-flex gap-3">
                                    @if($popular->featured_image)
                                        <img src="{{ asset('storage/' . $popular->featured_image) }}" 
                                             alt="" 
                                             style="width: 80px; height: 60px; object-fit: cover; border-radius: 0.25rem;">
                                    @else
                                        <div style="width: 80px; height: 60px; background:  #f3f4f6; border-radius: 0.25rem;"
                                             class="d-flex align-items-center justify-content-center">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                    <div class="flex-grow-1">
                                        <div class="small fw-semibold">
                                            {{ \Illuminate\Support\Str::limit($locale == 'id' ? $popular->title_id : $popular->title_en, 60) }}
                                        </div>
                                        <small class="text-muted">
                                            <i class="bi bi-eye me-1"></i>{{ $popular->view_count ?? 0 }}
                                        </small>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- All Categories -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">{{ $locale == 'id' ? 'Kategori' : 'Categories' }}</h5>
                    <div class="list-group list-group-flush">
                        @foreach($categories->take(8) as $cat)
                            <a href="{{ url($locale . '/category/' .  $cat->slug) }}" 
                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <span>{{ $locale == 'id' ? $cat->name_id : $cat->name_en }}</span>
                                <span class="badge bg-primary rounded-pill">
                                    {{ $cat->articles()->where('is_published', true)->count() }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Ad Space -->
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <small class="text-muted d-block mb-2">{{ $locale == 'id' ?  'IKLAN' : 'ADVERTISEMENT' }}</small>
                    @include('layouts.partials.ad', ['position' => 'search-sidebar'])
                </div>
            </div>
        </aside>
    </div>
</section>

<style>
. hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}
</style>
@endsection