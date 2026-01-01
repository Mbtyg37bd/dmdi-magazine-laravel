@extends('layouts.frontend')

@section('title', ($locale == 'id' ? $category->name_id : $category->name_en) . ' - DMDI Magazine')

@section('meta')
<meta name="description" content="{{ $locale == 'id' ? ($category->description_id ?? 'Artikel kategori ' . $category->name_id) : ($category->description_en ??  'Articles in ' . $category->name_en) }}">
<meta property="og:title" content="{{ $locale == 'id' ? $category->name_id : $category->name_en }} - DMDI Magazine">
<meta property="og:description" content="{{ $locale == 'id' ? ($category->description_id ??  '') : ($category->description_en ??  '') }}">
<meta property="og:type" content="website">
<meta property="og: url" content="{{ url()->current() }}">
<meta name="twitter:card" content="summary_large_image">
@endsection

@section('content')
<!-- Category Header -->
<section class="category-header py-5" style="background:  linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bold mb-3">{{ $locale == 'id' ? $category->name_id : $category->name_en }}</h1>
            @if($locale == 'id' && $category->description_id)
                <p class="lead mb-0">{{ $category->description_id }}</p>
            @elseif($locale == 'en' && $category->description_en)
                <p class="lead mb-0">{{ $category->description_en }}</p>
            @endif
            <div class="mt-3">
                <span class="badge bg-white text-dark px-3 py-2">
                    {{ $articles->total() }} {{ $locale == 'id' ?  'Artikel' : 'Articles' }}
                </span>
            </div>
        </div>
    </div>
</section>

<!-- Articles Grid -->
<section class="container py-5">
    <div class="row gx-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            @if($articles->count() > 0)
                <div class="row g-4">
                    @foreach($articles as $article)
                        <div class="col-md-6">
                            <article class="card border-0 shadow-sm h-100 hover-lift">
                                <a href="{{ url($locale .  '/article/' . $article->slug) }}" class="text-decoration-none">
                                    @if($article->featured_image)
                                        <div style="height: 250px; overflow: hidden; border-radius: 0.375rem 0.375rem 0 0;">
                                            <img src="{{ asset('storage/' . $article->featured_image) }}" 
                                                 alt="{{ $locale == 'id' ? $article->title_id : $article->title_en }}"
                                                 class="w-100 h-100"
                                                 style="object-fit: cover;">
                                        </div>
                                    @else
                                        <div style="height: 250px; background:  linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%); border-radius: 0.375rem 0.375rem 0 0;"
                                             class="d-flex align-items-center justify-content-center">
                                            <i class="bi bi-image fs-1 text-muted"></i>
                                        </div>
                                    @endif
                                    
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge bg-primary me-2">{{ $locale == 'id' ? $category->name_id : $category->name_en }}</span>
                                            <small class="text-muted">{{ $article->created_at->format('M d, Y') }}</small>
                                        </div>
                                        
                                        <h5 class="card-title fw-bold text-dark mb-2">
                                            {{ \Illuminate\Support\Str:: limit($locale == 'id' ? $article->title_id : $article->title_en, 80) }}
                                        </h5>
                                        
                                        <p class="card-text text-muted small mb-3">
                                            {{ \Illuminate\Support\Str:: limit($locale == 'id' ? $article->excerpt_id :  $article->excerpt_en, 120) }}
                                        </p>
                                        
                                        <div class="d-flex align-items-center justify-content-between">
                                            <small class="text-muted">
                                                <i class="bi bi-person me-1"></i>{{ $article->author }}
                                            </small>
                                            <small class="text-muted">
                                                <i class="bi bi-eye me-1"></i>{{ $article->view_count ??  0 }}
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
                    {{ $articles->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                    <h5 class="text-muted mt-3">{{ $locale == 'id' ?  'Belum ada artikel' : 'No articles yet' }}</h5>
                    <p class="text-muted">{{ $locale == 'id' ? 'Kategori ini belum memiliki artikel' : 'This category has no articles yet' }}</p>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <aside class="col-lg-4">
            <!-- All Categories -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">{{ $locale == 'id' ? 'Semua Kategori' : 'All Categories' }}</h5>
                    <div class="list-group list-group-flush">
                        @foreach($categories as $cat)
                            <a href="{{ url($locale . '/category/' .  $cat->slug) }}" 
                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $cat->id == $category->id ? 'active' : '' }}">
                                <span>{{ $locale == 'id' ? $cat->name_id : $cat->name_en }}</span>
                                <span class="badge {{ $cat->id == $category->id ? 'bg-white text-primary' : 'bg-primary' }} rounded-pill">
                                    {{ $cat->articles()->where('is_published', true)->count() }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

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
                                        <div style="width: 80px; height: 60px; background: #f3f4f6; border-radius: 0.25rem;"
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

            <!-- Ad Space -->
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <small class="text-muted d-block mb-2">{{ $locale == 'id' ?  'IKLAN' : 'ADVERTISEMENT' }}</small>
                    @include('layouts.partials.ad', ['position' => 'category-sidebar'])
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