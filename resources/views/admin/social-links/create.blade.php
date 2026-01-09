@extends('admin.layouts.admin')

@section('title', 'Tambah Social Media - DMDI Admin')
@section('page-title', 'Tambah Social Media')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-plus-circle me-2"></i>
                    Form Tambah Social Media
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.social-links.store') }}" method="POST">
                    @csrf

                    <!-- Platform -->
                    <div class="mb-4">
                        <label for="platform" class="form-label fw-semibold">
                            Platform <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('platform') is-invalid @enderror" 
                                id="platform" 
                                name="platform" 
                                required>
                            <option value="">Pilih Platform</option>
                            <option value="x" {{ old('platform') == 'x' ? 'selected' : '' }}>X (Twitter)</option>
                            <option value="tiktok" {{ old('platform') == 'tiktok' ?  'selected' : '' }}>TikTok</option>
                            <option value="youtube" {{ old('platform') == 'youtube' ? 'selected' : '' }}>YouTube</option>
                            <option value="facebook" {{ old('platform') == 'facebook' ? 'selected' : '' }}>Facebook</option>
                            <option value="instagram" {{ old('platform') == 'instagram' ? 'selected' : '' }}>Instagram</option>
                            <option value="whatsapp" {{ old('platform') == 'whatsapp' ?  'selected' : '' }}>WhatsApp</option>
                        </select>
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
                               value="{{ old('name') }}"
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
                               value="{{ old('url') }}"
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
                               value="{{ old('icon') }}"
                               placeholder="instagram.svg"
                               required>
                        @error('icon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                               value="{{ old('order', 0) }}"
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
                                   {{ old('is_active') ? 'checked' : '' }}>
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
                            Simpan
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

    <!-- Sidebar:  Panduan -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-info-circle me-2"></i>
                    Panduan
                </h6>
                <ul class="small text-muted">
                    <li>Pilih platform social media dari dropdown</li>
                    <li>URL boleh dikosongkan jika belum punya akun</li>
                    <li>Icon filename harus sesuai dengan file SVG di folder <code>public/images/</code></li>
                    <li>Urutan menentukan posisi tampil di footer (kecil = depan)</li>
                    <li>Social media hanya muncul jika aktif DAN URL terisi</li>
                </ul>

                <h6 class="fw-bold mt-4 mb-3">Icon Tersedia</h6>
                <div class="d-flex flex-wrap gap-2">
                    <img src="{{ asset('images/x. svg') }}" alt="X" style="width: 24px; height: 24px;">
                    <img src="{{ asset('images/tiktok.svg') }}" alt="TikTok" style="width: 24px; height: 24px;">
                    <img src="{{ asset('images/youtube.svg') }}" alt="YouTube" style="width: 24px; height: 24px;">
                    <img src="{{ asset('images/facebook. svg') }}" alt="Facebook" style="width: 24px; height: 24px;">
                    <img src="{{ asset('images/instagram.svg') }}" alt="Instagram" style="width: 24px; height: 24px;">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Auto-fill icon filename based on platform selection
document.getElementById('platform').addEventListener('change', function() {
    const platform = this.value;
    const iconInput = document.getElementById('icon');
    const nameInput = document.getElementById('name');
    
    if (platform) {
        iconInput.value = platform + '.svg';
        
        // Auto-fill name
        const names = {
            'x': 'X (Twitter)',
            'tiktok': 'TikTok',
            'youtube': 'YouTube',
            'facebook': 'Facebook',
            'instagram': 'Instagram',
            'whatsapp': 'WhatsApp'
        };
        
        if (names[platform] && ! nameInput.value) {
            nameInput.value = names[platform];
        }
    }
});
</script>
@endpush