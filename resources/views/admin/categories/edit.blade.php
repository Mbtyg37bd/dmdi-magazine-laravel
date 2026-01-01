@extends('admin.layouts.admin')

@section('title', 'Edit Kategori - DMDI Admin')
@section('page-title', 'Edit Kategori')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-pencil-square me-2"></i>
                    Form Edit Kategori
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nama Kategori (Indonesia) -->
                    <div class="mb-4">
                        <label for="name_id" class="form-label fw-semibold">
                            Nama Kategori (Bahasa Indonesia) <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('name_id') is-invalid @enderror" 
                               id="name_id" 
                               name="name_id" 
                               value="{{ old('name_id', $category->name_id) }}"
                               required>
                        @error('name_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nama Kategori (English) -->
                    <div class="mb-4">
                        <label for="name_en" class="form-label fw-semibold">
                            Nama Kategori (English) <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('name_en') is-invalid @enderror" 
                               id="name_en" 
                               name="name_en" 
                               value="{{ old('name_en', $category->name_en) }}"
                               required>
                        @error('name_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Slug saat ini:  <code>{{ $category->slug }}</code></small>
                    </div>

                    <!-- Deskripsi (Indonesia) -->
                    <div class="mb-4">
                        <label for="description_id" class="form-label fw-semibold">
                            Deskripsi (Bahasa Indonesia)
                        </label>
                        <textarea class="form-control @error('description_id') is-invalid @enderror" 
                                  id="description_id" 
                                  name="description_id" 
                                  rows="3">{{ old('description_id', $category->description_id) }}</textarea>
                        @error('description_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Deskripsi (English) -->
                    <div class="mb-4">
                        <label for="description_en" class="form-label fw-semibold">
                            Deskripsi (English)
                        </label>
                        <textarea class="form-control @error('description_en') is-invalid @enderror" 
                                  id="description_en" 
                                  name="description_en" 
                                  rows="3">{{ old('description_en', $category->description_en) }}</textarea>
                        @error('description_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_active" 
                                   name="is_active"
                                   {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_active">
                                Aktifkan Kategori
                            </label>
                            <div class="form-text">Kategori aktif akan tampil di website</div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>
                            Update Kategori
                        </button>
                        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-1"></i>
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2"></i>Informasi Kategori</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2">
                        <strong>Slug:</strong> <code>{{ $category->slug }}</code>
                    </li>
                    <li class="mb-2">
                        <strong>Total Artikel:</strong> 
                        <span class="badge bg-primary">{{ $category->articles()->count() }}</span>
                    </li>
                    <li class="mb-2">
                        <strong>Dibuat:</strong> {{ $category->created_at->format('d/m/Y H:i') }}
                    </li>
                    <li class="mb-2">
                        <strong>Diupdate:</strong> {{ $category->updated_at->format('d/m/Y H:i') }}
                    </li>
                </ul>
                <hr>
                <a href="{{ url('id/category/' . $category->slug) }}" target="_blank" class="btn btn-sm btn-outline-primary w-100">
                    <i class="bi bi-box-arrow-up-right me-1"></i>
                    Lihat di Website
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3 text-danger"><i class="bi bi-exclamation-triangle me-2"></i>Peringatan</h6>
                <p class="small text-muted mb-0">
                    Kategori dengan artikel tidak dapat dihapus. Nonaktifkan kategori jika tidak ingin ditampilkan di website.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection