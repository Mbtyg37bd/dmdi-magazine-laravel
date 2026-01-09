@extends('admin.layouts.admin')

@section('title', 'Kelola Halaman - DMDI Admin')
@section('page-title', 'Kelola Halaman')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-file-earmark-text me-2"></i>
            Daftar Halaman
        </h5>
        <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Tambah Halaman
        </a>
    </div>
    
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($pages->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 25%;">Judul (ID)</th>
                            <th style="width: 25%;">Judul (EN)</th>
                            <th style="width: 20%;">Slug</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pages as $page)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $page->title_id }}</strong>
                            </td>
                            <td>{{ $page->title_en }}</td>
                            <td>
                                <code>{{ $page->slug }}</code>
                            </td>
                            <td>
                                @if($page->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('frontend.page.show', ['locale' => 'id', 'slug' => $page->slug]) }}" 
                                       class="btn btn-outline-info"
                                       target="_blank"
                                       data-bs-toggle="tooltip"
                                       title="Preview">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.pages.edit', $page->id) }}" 
                                       class="btn btn-outline-primary"
                                       data-bs-toggle="tooltip"
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.pages.destroy', $page->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus halaman ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-outline-danger"
                                                data-bs-toggle="tooltip"
                                                title="Hapus">
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
        @else
            <div class="text-center py-5">
                <i class="bi bi-file-earmark-text fs-1 text-muted"></i>
                <h5 class="text-muted mt-3">Belum ada halaman</h5>
                <p class="text-muted">Mulai dengan menambahkan halaman pertama</p>
                <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>
                    Tambah Halaman
                </a>
            </div>
        @endif
    </div>
</div>

<div class="alert alert-info mt-4">
    <i class="bi bi-info-circle me-2"></i>
    <strong>Petunjuk:</strong> Halaman yang dibuat di sini akan bisa diakses melalui URL:  <code>/id/page/{slug}</code> atau <code>/en/page/{slug}</code>
</div>
@endsection