@extends('admin.layouts.admin')

@section('title', 'Kelola Kategori - DMDI Admin')
@section('page-title', 'Kelola Kategori')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-folder me-2"></i>
            Daftar Kategori
        </h5>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Kategori Baru
        </a>
    </div>
    
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($categories->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 30%;">Nama Kategori</th>
                            <th style="width: 35%;">Deskripsi</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width:  10%;">Artikel</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>
                                <div>
                                    <strong class="d-block">{{ $category->name_id }}</strong>
                                    <small class="text-muted">{{ $category->name_en }}</small>
                                    <div class="mt-1">
                                        <code class="small">{{ $category->slug }}</code>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ Str::limit($category->description_id ??  '-', 80) }}
                                </small>
                            </td>
                            <td>
                                @if($category->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-primary rounded-pill">
                                    {{ $category->articles_count }} artikel
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ url('id/category/' . $category->slug) }}" 
                                       target="_blank"
                                       class="btn btn-outline-success"
                                       data-bs-toggle="tooltip"
                                       title="Lihat Kategori">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" 
                                       class="btn btn-outline-primary"
                                       data-bs-toggle="tooltip"
                                       title="Edit Kategori">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Hapus kategori ini?  (Kategori dengan artikel tidak dapat dihapus)')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-outline-danger"
                                                data-bs-toggle="tooltip"
                                                title="Hapus Kategori"
                                                {{ $category->articles_count > 0 ? 'disabled' : '' }}>
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan {{ $categories->firstItem() }} - {{ $categories->lastItem() }} dari {{ $categories->total() }} kategori
                </div>
                {{ $categories->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-folder fs-1 text-muted"></i>
                <h5 class="text-muted mt-3">Belum ada kategori</h5>
                <p class="text-muted">Mulai dengan membuat kategori pertama Anda</p>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>
                    Buat Kategori Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (el) {
        return new bootstrap. Tooltip(el)
    });
});
</script>
@endpush