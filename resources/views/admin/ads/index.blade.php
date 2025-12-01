@extends('admin.layouts.admin')

@section('title', 'Ads Management')

@section('content')
<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Ads</h1>
    <a href="{{ route('ads.create') }}" class="btn btn-primary">Create Ad</a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card shadow-sm">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th style="width:80px">Preview</th>
              <th>Name / Position</th>
              <th>Placement</th>
              <th>Active</th>
              <th>Starts At</th>
              <th>Clicks</th>
              <th>Impressions</th>
              <th style="width:140px">Priority</th>
              <th style="width:160px">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($ads as $ad)
              <tr>
                <td>
                  @if($ad->image_path)
                    <img src="{{ $ad->imageUrl() }}" alt="{{ $ad->name }}" style="max-width:72px; height:auto; border-radius:4px; border:1px solid #e9ecef;">
                  @else
                    <div class="bg-light text-muted text-center" style="width:72px;height:48px;display:flex;align-items:center;justify-content:center;border-radius:4px;">—</div>
                  @endif
                </td>
                <td>
                  <div class="fw-bold">{{ $ad->name ?? '—' }}</div>
                  <small class="text-muted">{{ $ad->position ?? '—' }}</small>
                </td>
                <td>
                  <span class="badge bg-secondary text-white">{{ ucfirst($ad->placement) }}</span>
                  @if($ad->placement === 'article' && $ad->placement_target)
                    <div class="small text-muted">target: {{ $ad->placement_target }}</div>
                  @endif
                </td>
                <td>
                  @if($ad->is_active)
                    <span class="badge bg-success">Active</span>
                  @else
                    <span class="badge bg-danger">Inactive</span>
                  @endif
                </td>
                <td>
                  <small class="text-muted">{{ $ad->starts_at ? $ad->starts_at->format('Y-m-d H:i') : '-' }}</small>
                </td>
                <td>
                  <span class="badge bg-info text-dark">{{ $ad->click_count ?? 0 }}</span>
                </td>
                <td>
                  <span class="badge bg-light text-dark">{{ $ad->impression_count ?? 0 }}</span>
                </td>
                <td>
                  <div>{{ $ad->priority ?? 0 }}</div>
                </td>
                <td>
                  <a href="{{ route('ads.edit', $ad->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                  <form action="{{ route('ads.destroy', $ad->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this ad?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="9" class="text-center text-muted py-4">No ads yet. <a href="{{ route('ads.create') }}">Create one</a>.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-footer">
      {{ $ads->links() }}
    </div>
  </div>
</div>
@endsection
