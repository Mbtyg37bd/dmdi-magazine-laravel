@extends('admin.layouts.admin')

@section('title', 'Tambah Kategori - DMDI Admin')
@section('page-title', 'Tambah Kategori Baru')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-folder-plus me-2"></i>
                    Form Kategori Baru
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf

                    <!-- Nama Kategori (Indonesia) -->
                    <div class="mb-4">
                        <label for="name_id" class="form-label fw-semibold">
                            Nama Kategori (Bahasa Indonesia) <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('name_id') is-invalid @enderror" 
                               id="name_id" 
                               name="name_id" 
                               value="{{ old('name_id') }}"
                               placeholder="Contoh:   Warisan & Peradaban"
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
                               value="{{ old('name_en') }}"
                               placeholder="Example:   Heritage & Civilization"
                               required>
                        @error('name_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Slug akan otomatis dibuat dari nama bahasa Inggris</small>
                    </div>

                    <!-- Deskripsi (Indonesia) -->
                    <div class="mb-4">
                        <label for="description_id" class="form-label fw-semibold">
                            Deskripsi (Bahasa Indonesia)
                        </label>
                        <textarea class="form-control @error('description_id') is-invalid @enderror" 
                                  id="description_id" 
                                  name="description_id" 
                                  rows="3"
                                  placeholder="Deskripsi kategori dalam Bahasa Indonesia... ">{{ old('description_id') }}</textarea>
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
                                  rows="3"
                                  placeholder="Category description in English...">{{ old('description_en') }}</textarea>
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
                                   value="1"
                                   {{ old('is_active', true) ? 'checked' :  '' }}>
                            <label class="form-check-label" for="is_active">
                                Aktifkan Kategori
                            </label>
                            <div class="form-text">Kategori aktif akan tampil di website</div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>
                            Simpan Kategori
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-1"></i>
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Panduan (Sidebar) -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-info-circle me-2"></i>
                    Panduan
                </h6>
                <ul class="small text-muted">
                    <li>Nama kategori harus unik dan jelas</li>
                    <li>Gunakan bahasa yang mudah dipahami pembaca</li>
                    <li>Deskripsi kategori membantu SEO</li>
                    <li>Slug otomatis dibuat dari nama bahasa Inggris</li>
                    <li>Kategori nonaktif tidak tampil di website</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection