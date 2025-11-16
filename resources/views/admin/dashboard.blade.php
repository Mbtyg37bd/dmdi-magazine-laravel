@extends('admin.layouts.admin')

@section('title', 'Dashboard - DMDI Admin')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Statistics Cards -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="bi bi-newspaper text-primary fs-1"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5 class="card-title text-muted mb-0">Total Artikel</h5>
                        <h2 class="mb-0 fw-bold">{{ $stats['total_articles'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="bi bi-check-circle text-success fs-1"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5 class="card-title text-muted mb-0">Artikel Publik</h5>
                        <h2 class="mb-0 fw-bold">{{ $stats['published_articles'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="bi bi-file-earmark text-warning fs-1"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5 class="card-title text-muted mb-0">Artikel Draft</h5>
                        <h2 class="mb-0 fw-bold">{{ $stats['draft_articles'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="bi bi-star text-info fs-1"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5 class="card-title text-muted mb-0">Artikel Unggulan</h5>
                        <h2 class="mb-0 fw-bold">{{ $stats['featured_articles'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Articles -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-clock-history me-2"></i>
                    Artikel Terbaru
                </h5>
            </div>
            <div class="card-body">
                @if($recent_articles->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_articles as $article)
                                <tr>
                                    <td>
                                        <strong>{{ $article->title_id }}</strong>
                                        @if($article->is_featured)
                                            <span class="badge bg-warning ms-1">Featured</span>
                                        @endif
                                    </td>
                                    <td>{{ $article->category->name_id ?? '-' }}</td>
                                    <td>
                                        @if($article->is_published)
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-secondary">Draft</span>
                                        @endif
                                    </td>
                                    <td>{{ $article->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('articles.edit', $article->id) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-inbox fs-1 text-muted"></i>
                        <p class="text-muted mt-2">Belum ada artikel</p>
                        <a href="{{ route('articles.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i>
                            Buat Artikel Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Aksi Cepat</h5>
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('articles.create') }}" class="btn btn-primary w-100">
                            <i class="bi bi-plus-circle me-1"></i>
                            Artikel Baru
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('articles.index') }}" class="btn btn-outline-dark w-100">
                            <i class="bi bi-list-ul me-1"></i>
                            Kelola Artikel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection