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
              placeholder="Category description in English... ">{{ old('description_en') }}</textarea>
    @error('description_en')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- NEW:  Menu Order -->
<div class="mb-4">
    <label for="menu_order" class="form-label fw-semibold">
        Urutan Menu
    </label>
    <input type="number" 
           class="form-control @error('menu_order') is-invalid @enderror" 
           id="menu_order" 
           name="menu_order" 
           value="{{ old('menu_order', 0) }}"
           min="0"
           placeholder="0">
    @error('menu_order')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <div class="form-text">
        Semakin kecil angka, semakin depan posisinya di menu.  <br>
        Contoh: 0 = pertama, 10 = kedua, 20 = ketiga
    </div>
</div>

<!-- Display Settings -->
<div class="mb-4">
    <h6 class="fw-bold mb-3">Pengaturan Tampilan</h6>
    
    <!-- Switch:  Aktifkan Kategori -->
    <div class="form-check form-switch mb-3">
        <input class="form-check-input" 
               type="checkbox" 
               id="is_active" 
               name="is_active" 
               value="1"
               {{ old('is_active', true) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">
            <i class="bi bi-check-circle me-1"></i>
            Aktifkan Kategori
        </label>
        <div class="form-text">Kategori aktif akan tampil di website</div>
    </div>

    <!-- Switch: Tampilkan di Main Menu -->
    <div class="form-check form-switch mb-3">
        <input class="form-check-input" 
               type="checkbox" 
               id="show_in_main_menu" 
               name="show_in_main_menu" 
               value="1"
               {{ old('show_in_main_menu', false) ? 'checked' : '' }}>
        <label class="form-check-label" for="show_in_main_menu">
            <i class="bi bi-menu-button me-1"></i>
            Tampilkan di Menu Utama
        </label>
        <div class="form-text">
            Kategori akan muncul sebagai menu utama di navbar (sejajar dengan HOME, POLITIK, dll)
        </div>
    </div>

    <!-- Switch: Tampilkan di Dropdown -->
    <div class="form-check form-switch">
        <input class="form-check-input" 
               type="checkbox" 
               id="show_in_dropdown" 
               name="show_in_dropdown" 
               value="1"
               {{ old('show_in_dropdown', false) ? 'checked' : '' }}>
        <label class="form-check-label" for="show_in_dropdown">
            <i class="bi bi-menu-button-wide me-1"></i>
            Tampilkan di Dropdown "Kategori"
        </label>
        <div class="form-text">
            Kategori akan muncul di dalam dropdown "Kategori" di navbar
        </div>
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