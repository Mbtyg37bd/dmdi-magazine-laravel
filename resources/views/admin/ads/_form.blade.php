@php
    $isEdit = isset($ad) && $ad;
    $placement = old('placement', $ad->placement ?? 'search');
    $placementTarget = old('placement_target', $ad->placement_target ?? '');
@endphp

<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $ad->name ?? '') }}">
        @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- Position tetap ada untuk backward compatibility (slot identifier) --}}
    <div class="mb-3">
        <label class="form-label">Position (contoh: search-ad-1)</label>
        <input type="text" name="position" class="form-control" value="{{ old('position', $ad->position ?? '') }}" required>
        @error('position') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- New: Placement (search, dashboard, article) --}}
    <div class="mb-3">
        <label class="form-label">Placement</label>
        <select name="placement" id="placement" class="form-select">
            <option value="search" {{ $placement === 'search' ? 'selected' : '' }}>Search (halaman pencarian)</option>
            <option value="dashboard" {{ $placement === 'dashboard' ? 'selected' : '' }}>Dashboard (admin)</option>
            <option value="article" {{ $placement === 'article' ? 'selected' : '' }}>Article (per artikel)</option>
        </select>
        @error('placement') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- target untuk placement article (slug atau id) --}}
    <div class="mb-3" id="placement-target-row" style="display: {{ $placement === 'article' ? 'block' : 'none' }};">
        <label class="form-label">Placement target (Article slug atau ID)</label>
        <input type="text" name="placement_target" class="form-control" value="{{ $placementTarget }}" placeholder="Masukkan slug artikel atau ID (mis. jamiyah-singapore)">
        <div class="form-text">Isi hanya jika memilih "Article". Bisa memasukkan slug atau ID artikel.</div>
        @error('placement_target') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">URL (target ketika diklik)</label>
        <input type="url" name="url" class="form-control" value="{{ old('url', $ad->url ?? '') }}">
        @error('url') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Active</label>
            <div class="form-check">
                <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" {{ old('is_active', $ad->is_active ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Aktif</label>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Priority</label>
            <input type="number" name="priority" class="form-control" value="{{ old('priority', $ad->priority ?? 10) }}">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Tanggal mulai</label>
            <input type="datetime-local" name="starts_at" class="form-control" value="{{ old('starts_at', isset($ad->starts_at) ? $ad->starts_at->format('Y-m-d\TH:i') : '') }}">
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Image (png/jpg)</label>
        @if($isEdit && $ad->image_path)
            <div class="mb-2">
                <img src="{{ asset(ltrim($ad->image_path, '/')) }}" alt="preview" style="max-width:300px; height:auto;">
            </div>
        @endif
        <input type="file" name="image" class="form-control">
        @error('image') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <button class="btn btn-primary">{{ $isEdit ? 'Update' : 'Create' }}</button>
        <a href="{{ route('ads.index') }}" class="btn btn-secondary ms-2">Cancel</a>
    </div>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const placementSelect = document.getElementById('placement');
    const placementTargetRow = document.getElementById('placement-target-row');

    function togglePlacementTarget() {
        if (!placementSelect) return;
        if (placementSelect.value === 'article') {
            placementTargetRow.style.display = 'block';
        } else {
            placementTargetRow.style.display = 'none';
        }
    }

    if (placementSelect) {
        placementSelect.addEventListener('change', togglePlacementTarget);
        togglePlacementTarget();
    }
});
</script>
@endpush