@extends('admin.layouts. admin')

@section('title', 'Tambah Halaman - DMDI Admin')
@section('page-title', 'Tambah Halaman')

@section('content')
<form action="{{ route('admin.pages. store') }}" method="POST">
    @csrf
    
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        Informasi Halaman
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
                               value="{{ old('title_id') }}"
                               placeholder="Contoh: Tentang Kami"
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
                               value="{{ old('title_en') }}"
                               placeholder="Example: About Us"
                               required>
                        @error('title_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Slug akan otomatis dibuat dari judul English</small>
                    </div>

                    <!-- Slug (Optional) -->
                    <div class="mb-4">
                        <label for="slug" class="form-label fw-semibold">
                            Slug (Optional)
                        </label>
                        <input type="text" 
                               class="form-control @error('slug') is-invalid @enderror" 
                               id="slug" 
                               name="slug" 
                               value="{{ old('slug') }}"
                               placeholder="about-us">
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Kosongkan untuk generate otomatis dari judul</small>
                    </div>

                    <!-- Content ID -->
                    <div class="mb-4">
                        <label for="content_id" class="form-label fw-semibold">
                            Konten (Bahasa Indonesia)
                        </label>
                        <textarea class="form-control @error('content_id') is-invalid @enderror" 
                                  id="content_id" 
                                  name="content_id" 
                                  rows="15">{{ old('content_id') }}</textarea>
                        @error('content_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Gunakan HTML untuk formatting (h2, h3, p, ul, li, dll)</small>
                    </div>

                    <!-- Content EN -->
                    <div class="mb-4">
                        <label for="content_en" class="form-label fw-semibold">
                            Konten (English)
                        </label>
                        <textarea class="form-control @error('content_en') is-invalid @enderror" 
                                  id="content_en" 
                                  name="content_en" 
                                  rows="15">{{ old('content_en') }}</textarea>
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
                        <textarea class="form-control @error('meta_description_id') is-invalid @enderror" 
                                  id="meta_description_id" 
                                  name="meta_description_id" 
                                  rows="3"
                                  maxlength="160">{{ old('meta_description_id') }}</textarea>
                        @error('meta_description_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Max 160 karakter</small>
                    </div>

                    <!-- Meta Description EN -->
                    <div class="mb-3">
                        <label for="meta_description_en" class="form-label fw-semibold">
                            Meta Description (EN)
                        </label>
                        <textarea class="form-control @error('meta_description_en') is-invalid @enderror" 
                                  id="meta_description_en" 
                                  name="meta_description_en" 
                                  rows="3"
                                  maxlength="160">{{ old('meta_description_en') }}</textarea>
                        @error('meta_description_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                    <div class="form-check form-switch">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="is_active" 
                               name="is_active" 
                               value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Aktifkan Halaman
                        </label>
                        <div class="form-text">Halaman aktif akan bisa diakses publik</div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>
                            Simpan Halaman
                        </button>
                        <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-1"></i>
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
// Auto-generate slug from title_en
document.getElementById('title_en').addEventListener('input', function() {
    const slugInput = document.getElementById('slug');
    if (! slugInput.value) {
        const slug = this.value
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
        slugInput.value = slug;
    }
});
</script>
@endpush