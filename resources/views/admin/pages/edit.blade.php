@extends('admin.layouts.admin')

@section('title', 'Edit Halaman - DMDI Admin')
@section('page-title', 'Edit Halaman')

@section('content')
<form action="{{ route('admin.pages.update', $page->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        Edit:  {{ $page->title_id }}
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Title ID -->
                    <div class="mb-4">
                        <label for="title_id" class="form-label fw-semibold">
                            Judul (Bahasa Indonesia) <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('title_id') is-invalid @enderror" 
                               id="title_id" 
                               name="title_id" 
                               value="{{ old('title_id', $page->title_id) }}"
                               required>
                        @error('title_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Title EN -->
                    <div class="mb-4">
                        <label for="title_en" class="form-label fw-semibold">
                            Judul (English) <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('title_en') is-invalid @enderror" 
                               id="title_en" 
                               name="title_en" 
                               value="{{ old('title_en', $page->title_en) }}"
                               required>
                        @error('title_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

  <!-- Slug -->
<div class="mb-4">
    <label for="slug" class="form-label fw-semibold">
        Slug
    </label>
    <input type="text" 
           class="form-control @error('slug') is-invalid @enderror" 
           id="slug" 
           name="slug" 
           value="{{ old('slug', $page->slug) }}">
    @error('slug')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- IMAGE UPLOAD (NEW) -->
<div class="mb-4">
    <label for="image" class="form-label fw-semibold">
        <i class="bi bi-image me-1"></i>
        Gambar Header (Optional)
    </label>
    
    @if($page->image)
    <!-- Current Image Display -->
    <div class="mb-3 p-3 border rounded bg-light">
        <p class="small text-muted mb-2"><strong>Gambar Saat Ini:</strong></p>
        <img src="{{ $page->getImageUrl() }}" 
             alt="{{ $page->title_en }}" 
             class="img-thumbnail mb-2"
             style="max-width:  400px; max-height: 250px; object-fit: cover;">
        <div class="form-check">
            <input class="form-check-input" 
                   type="checkbox" 
                   id="remove_image" 
                   name="remove_image" 
                   value="1">
            <label class="form-check-label text-danger" for="remove_image">
                <i class="bi bi-trash me-1"></i>
                <strong>Hapus gambar ini</strong>
            </label>
        </div>
    </div>
    @endif
    
    <input type="file" 
           class="form-control @error('image') is-invalid @enderror" 
           id="image" 
           name="image"
           accept="image/jpeg,image/jpg,image/png,image/webp"
           onchange="previewImage(event)">
    @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <div class="alert alert-info mt-2 py-2 px-3">
        <small>
            <i class="bi bi-info-circle me-1"></i>
            <strong>Format: </strong> JPEG, JPG, PNG, WebP | 
            <strong>Ukuran maksimal:</strong> <span class="text-danger fw-bold">2MB (2048 KB)</span>
        </small>
    </div>
    
    <!-- New Image Preview -->
    <div id="imagePreview" class="mt-3" style="display: none;">
        <p class="small text-muted mb-2"><strong>Preview Gambar Baru:</strong></p>
        <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 400px; max-height: 250px;">
        <div id="imageInfo" class="small text-muted mt-2"></div>
    </div>
</div>
                    <!-- Content ID -->
                    <div class="mb-4">
                        <label for="content_id" class="form-label fw-semibold">
                            Konten (Bahasa Indonesia)
                        </label>
                        <textarea class="form-control @error('content_id') is-invalid @enderror" 
                                  id="content_id" 
                                  name="content_id" 
                                  rows="15">{{ old('content_id', $page->content_id) }}</textarea>
                        @error('content_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Content EN -->
                    <div class="mb-4">
                        <label for="content_en" class="form-label fw-semibold">
                            Konten (English)
                        </label>
                        <textarea class="form-control @error('content_en') is-invalid @enderror" 
                                  id="content_en" 
                                  name="content_en" 
                                  rows="15">{{ old('content_en', $page->content_en) }}</textarea>
                        @error('content_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- SEO -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0 fw-bold">
                        <i class="bi bi-search me-2"></i>
                        SEO
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Meta Description ID -->
                    <div class="mb-3">
                        <label for="meta_description_id" class="form-label fw-semibold">
                            Meta Description (ID)
                        </label>
                        <textarea class="form-control" 
                                  id="meta_description_id" 
                                  name="meta_description_id" 
                                  rows="3"
                                  maxlength="160">{{ old('meta_description_id', $page->meta_description_id) }}</textarea>
                        <small class="text-muted">Max 160 karakter</small>
                    </div>

                    <!-- Meta Description EN -->
                    <div class="mb-3">
                        <label for="meta_description_en" class="form-label fw-semibold">
                            Meta Description (EN)
                        </label>
                        <textarea class="form-control" 
                                  id="meta_description_en" 
                                  name="meta_description_en" 
                                  rows="3"
                                  maxlength="160">{{ old('meta_description_en', $page->meta_description_en) }}</textarea>
                        <small class="text-muted">Max 160 characters</small>
                    </div>
                </div>
            </div>

 <!-- Status -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h6 class="mb-0 fw-bold">
            <i class="bi bi-gear me-2"></i>
            Status
        </h6>
    </div>
    <div class="card-body">
        <div class="form-check form-switch mb-3">
            <input class="form-check-input" 
                   type="checkbox" 
                   id="is_active" 
                   name="is_active" 
                   value="1"
                   {{ old('is_active', $page->is_active) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">
                Aktifkan Halaman
            </label>
        </div>

        <div class="form-check form-switch mb-3">
            <input class="form-check-input" 
                   type="checkbox" 
                   id="show_in_footer" 
                   name="show_in_footer" 
                   value="1"
                   {{ old('show_in_footer', $page->show_in_footer) ? 'checked' : '' }}>
            <label class="form-check-label" for="show_in_footer">
                Tampilkan di Footer
            </label>
            <div class="form-text">Halaman akan muncul di footer website</div>
        </div>

        <div class="mb-0">
            <label for="footer_order" class="form-label fw-semibold">
                Urutan di Footer
            </label>
            <input type="number" 
                   class="form-control" 
                   id="footer_order" 
                   name="footer_order" 
                   value="{{ old('footer_order', $page->footer_order) }}"
                   min="0">
            <small class="text-muted">Angka kecil muncul lebih dulu</small>
        </div>
    </div>
</div>

            <!-- Actions -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-1"></i>
                            Batal
                        </a>
                    </div>
                </div>
            </div>

            <!-- Preview -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <a href="{{ route('frontend.page.show', ['locale' => 'id', 'slug' => $page->slug]) }}" 
                       class="btn btn-outline-info w-100" 
                       target="_blank">
                        <i class="bi bi-eye me-1"></i>
                        Preview Halaman
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection