@extends('admin.layouts.admin')

@section('title', 'Create Ad')

@section('content')
<div class="container">
  <div class="mb-3">
    <h1 class="h3">Create Ad</h1>
    <a href="{{ route('admin.ads.index') }}" class="btn btn-link">Back to list</a>
  </div>

  <div class="card">
    <div class="card-body">
      @include('admin.ads._form', [
        'action' => route('admin.ads.store'),
        'method' => 'POST',
      ])
    </div>
  </div>
</div>
@endsection