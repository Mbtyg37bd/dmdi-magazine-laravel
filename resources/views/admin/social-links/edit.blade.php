@extends('admin.layouts.admin')

@section('title', 'Edit Social Media - DMDI Admin')
@section('page-title', 'Edit Social Media')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-pencil me-2"></i>
                    Edit Social Media Link
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.social-links.update', $socialLink->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Platform -->
                    <div class="mb-4">
                        <label for="platform" class="form-label fw-semibold">
                            Platform <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('platform') is-invalid @enderror" 
                               id="platform" 
                               name="platform" 
                               value="{{ old('platform', $socialLink->platform) }}"
                               placeholder="Contoh: instagram"
                               required>
                        @error('platform')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Name -->
                    <div class="mb-4">
                        <label for="name" class="form-label fw-semibold">
                            Nama Tampilan <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $socialLink->name) }}"
                               placeholder="Contoh: Instagram"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- URL -->
                    <div class="mb-4">
                        <label for="url" class="form-label fw-semibold">
                            URL Profile
                        </label>
                        <input type="url" 
                               class="form-control @error('url') is-invalid @enderror" 
                               id="url" 
                               name="url" 
                               value="{{ old('url', $socialLink->url) }}"
                               placeholder="https://www.instagram.com/dmdi_magazine">
                        @error('url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Kosongkan jika belum punya akun</small>
                    </div>

                    <!-- Icon -->
                    <div class="mb-4">
                        <label for="icon" class="form-label fw-semibold">
                            Icon Filename <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('icon') is-invalid @enderror" 
                               id="icon" 
                               name="icon" 
                               value="{{ old('icon', $socialLink->icon) }}"
                               placeholder="instagram.svg"
                               required>
                        @error('icon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror>
                        <small class="text-muted">File SVG harus ada di folder public/images/</small>
                    </div>

                    <!-- Order -->
                    <div class="mb-4">
                        <label for="order" class="form-label fw-semibold">
                            Urutan Tampil
                        </label>
                        <input type="number" 
                               class="form-control @error('order') is-invalid @enderror" 
                               id="order" 
                               name="order" 
                               value="{{ old('order', $socialLink->order) }}"
                               min="0">
                        @error('order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Semakin kecil angka, semakin depan posisinya</small>
                    </div>

                    <!-- Is Active -->
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', $socialLink->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Aktifkan di Website
                            </label>
                            <div class="form-text">Social media akan muncul di footer jika diaktifkan dan URL sudah terisi</div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.social-links.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-1"></i>
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Preview -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-eye me-2"></i>
                    Preview Icon
                </h6>
                <div class="text-center">
                    <img src="{{ asset('images/' . $socialLink->icon) }}" 
                         alt="{{ $socialLink->platform }}" 
                         style="width: 48px; height: 48px;"
                         onerror="this.src='{{ asset('images/placeholder.png') }}'">
                    <p class="small text-muted mt-2">{{ $socialLink->icon }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection