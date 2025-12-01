@extends('admin.layouts.admin')

@section('title', 'Ad Details')

@section('content')
<div class="container">
  <div class="mb-3">
    <a href="{{ route('ads.index') }}" class="btn btn-link">← Back</a>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md-4 text-center">
          @if($ad->image_path)
            <img src="{{ $ad->imageUrl() }}" class="img-fluid rounded" alt="{{ $ad->name }}">
          @else
            <div class="bg-light p-5">No image</div>
          @endif
        </div>
        <div class="col-md-8">
          <h4>{{ $ad->name }}</h4>
          <p><strong>Position:</strong> {{ $ad->position }}</p>
          <p><strong>Placement:</strong> {{ $ad->placement }}</p>
          @if($ad->placement === 'article' && $ad->placement_target)
            <p><strong>Placement target:</strong> {{ $ad->placement_target }}</p>
          @endif
          <p><strong>Active:</strong> {{ $ad->is_active ? 'Yes' : 'No' }}</p>
          <p><strong>Starts at:</strong> {{ $ad->starts_at ? $ad->starts_at->toDateTimeString() : '-' }}</p>
          <p><strong>Clicks:</strong> {{ $ad->click_count ?? 0 }}</p>
          <p><strong>Impressions:</strong> {{ $ad->impression_count ?? 0 }}</p>
          <div class="mt-3">
            <a href="{{ route('ads.edit', $ad->id) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('ads.index') }}" class="btn btn-secondary">Back</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
