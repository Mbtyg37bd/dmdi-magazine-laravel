@extends('admin.layouts.admin')

@section('title', 'Kelola Social Media - DMDI Admin')
@section('page-title', 'Kelola Social Media')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-share me-2"></i>
            Daftar Social Media Links
        </h5>
        <a href="{{ route('admin. social-links.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Tambah Social Media
        </a>
    </div>
    
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($socialLinks->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 10%;">Order</th>
                            <th style="width: 15%;">Platform</th>
                            <th style="width: 20%;">Nama</th>
                            <th style="width: 30%;">URL</th>
                            <th style="width: 10%;">Icon</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width:  15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($socialLinks as $link)
                        <tr>
                            <td>
                                <span class="badge bg-secondary">{{ $link->order }}</span>
                            </td>
                            <td>
                                <strong>{{ ucfirst($link->platform) }}</strong>
                            </td>
                            <td>{{ $link->name }}</td>
                            <td>
                                @if($link->url)
                                    <a href="{{ $link->url }}" target="_blank" class="text-primary">
                                        {{ Str::limit($link->url, 30) }}
                                        <i class="bi bi-box-arrow-up-right small"></i>
                                    </a>
                                @else
                                    <span class="text-muted">Belum diatur</span>
                                @endif
                            </td>
                            <td>
                                <img src="{{ asset('images/' . $link->icon) }}" 
                                     alt="{{ $link->platform }}" 
                                     style="width: 24px; height: 24px;"
                                     onerror="this.style.display='none'">
                            </td>
                            <td>
                                @if($link->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.social-links.edit', $link->id) }}" 
                                       class="btn btn-outline-primary"
                                       data-bs-toggle="tooltip"
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.social-links.destroy', $link->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus social media link ini?')">
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
                <i class="bi bi-share fs-1 text-muted"></i>
                <h5 class="text-muted mt-3">Belum ada social media link</h5>
                <p class="text-muted">Mulai dengan menambahkan social media pertama</p>
                <a href="{{ route('admin. social-links.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>
                    Tambah Social Media
                </a>
            </div>
        @endif
    </div>
</div>

<div class="alert alert-info mt-4">
    <i class="bi bi-info-circle me-2"></i>
    <strong>Petunjuk:</strong> Hanya social media dengan status "Aktif" dan URL terisi yang akan muncul di footer website. 
</div>
@endsection