@php
    $isEdit = isset($ad) && $ad;
    $placement = old('placement', $ad->placement ?? 'search');
    $placementTarget = old('placement_target', $ad->placement_target ?? '');
    $positions = [
        'home-top' => 'Home Top (leaderboard)',
        'home-sidebar' => 'Home Sidebar (right)',
        'article-inline' => 'Article Inline',
        'search-ad-1' => 'Search Ad 1',
        'ad-1' => 'Legacy: ad-1',
        'ad-2' => 'Legacy: ad-2',
    ];
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

    <div class="mb-3">
        <label class="form-label">Position</label>
        <select name="position" class="form-select" required>
            @foreach($positions as $key => $label)
                <option value="{{ $key }}" {{ old('position', $ad->position ?? '') === $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        <div class="form-text">Pilih slot iklan yang tersedia.</div>
        @error('position') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Placement</label>
        <select name="placement" id="placement" class="form-select">
            <option value="search" {{ $placement === 'search' ? 'selected' : '' }}>Search (halaman publik)</option>
            <option value="dashboard" {{ $placement === 'dashboard' ? 'selected' : '' }}>Dashboard (admin)</option>
            <option value="article" {{ $placement === 'article' ? 'selected' : '' }}>Article</option>
        </select>
        @error('placement') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3" id="placement-target-row" style="display: {{ $placement === 'article' ? 'block' : 'none' }};">
        <label class="form-label">Placement target (Article)</label>
        <select name="placement_target" class="form-select">
            <option value="">{{ __('-- pilih artikel --') }}</option>
            @if(isset($articles) && count($articles))
                @foreach($articles as $article)
                    <option value="{{ $article->slug }}" {{ $placementTarget == $article->slug ? 'selected' : '' }}>
                        {{ $article->title }}
                    </option>
                @endforeach
            @else
                <option disabled>Belum ada daftar artikel (atau controller belum kirimkan)</option>
            @endif
        </select>
        <div class="form-text">Pilih artikel jika placement = Article.</div>
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
        placementTargetRow.style.display = placementSelect.value === 'article' ? 'block' : 'none';
    }

    if (placementSelect) {
        placementSelect.addEventListener('change', togglePlacementTarget);
        togglePlacementTarget();
    }
});
</script>
@endpush