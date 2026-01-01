```blade
{{-- Partial: admin.ads._table
     Expects $ads (LengthAwarePaginator or Collection) --}}
<table class="table table-sm table-striped mb-0">
  <thead class="thead-light">
    <tr>
      <th style="width:90px">Preview</th>
      <th>Name / Position</th>
      <th>Placement</th>
      <th>Active</th>
      <th>Starts At</th>
      <th>Clicks</th>
      <th>Impressions</th>
      <th style="width:120px">Priority</th>
      <th style="width:150px">Actions</th>
    </tr>
  </thead>
  <tbody>
    @forelse($ads as $ad)
      <tr>
        <td class="align-middle">
          @if($ad->image_path)
            <img src="{{ asset($ad->image_path) }}" alt="{{ $ad->name ?? 'ad' }}" style="max-width:80px; max-height:48px; object-fit:contain; border-radius:4px;">
          @else
            <div style="width:80px; height:48px; background:#f5f5f5; display:flex;align-items:center;justify-content:center;color:#999;border-radius:4px;">
              No image
            </div>
          @endif
        </td>

        <td class="align-middle">
          <div><strong>{{ $ad->name ?? '—' }}</strong></div>
          <small class="text-muted">{{ $ad->position }}</small>
        </td>

        <td class="align-middle">
          <span class="badge bg-secondary" style="text-transform:capitalize;">{{ $ad->placement }}</span>
          @if($ad->placement === 'article' && $ad->placement_target)
            <div><small class="text-muted">target: {{ $ad->placement_target }}</small></div>
          @endif
        </td>

        <td class="align-middle">
          @if($ad->is_active)
            <span class="badge bg-success">Active</span>
          @else
            <span class="badge bg-secondary">Inactive</span>
          @endif
        </td>

        <td class="align-middle">
          {{ $ad->starts_at ? \Carbon\Carbon::parse($ad->starts_at)->format('Y-m-d H:i') : '-' }}
        </td>

        <td class="align-middle">
          <span class="badge bg-info text-dark">{{ $ad->click_count ?? 0 }}</span>
        </td>

        <td class="align-middle">
          <span class="text-muted">{{ $ad->impression_count ?? 0 }}</span>
        </td>

        <td class="align-middle">
          {{ $ad->priority ?? '-' }}
        </td>

        <td class="align-middle">
          <div class="d-flex gap-2">
            <a href="{{ route('ads.edit', $ad->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>

            <form action="{{ route('ads.destroy', $ad->id) }}" method="POST" onsubmit="return confirm('Delete this ad?');" style="display:inline-block;">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-outline-danger">Delete</button>
            </form>
          </div>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="9" class="text-center text-muted py-4">No ads found.</td>
      </tr>
    @endforelse
  </tbody>
</table>

@if(method_exists($ads, 'links'))
  <div class="p-3">
    {{ $ads->onEachSide(1)->links() }}
  </div>
@endif
```