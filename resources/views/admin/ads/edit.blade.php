@extends('admin.layouts.admin')

@section('title', 'Edit Ad')

@section('content')
<div class="container">
  <div class="mb-3 d-flex justify-content-between align-items-center">
    <h1 class="h3">Edit Ad</h1>
    <a href="{{ route('ads.index') }}" class="btn btn-link">Back to list</a>
  </div>

  <div class="card">
    <div class="card-body">
      @include('admin.ads._form', [
        'action' => route('ads.update', $ad->id),
        'method' => 'PUT',
        // $ad and $articles should be available from controller
      ])
    </div>
  </div>
</div>
@endsection
