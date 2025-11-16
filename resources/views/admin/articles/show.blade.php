@extends('admin.layouts.admin')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8">
      <h1>{{ $article->title_id }}</h1>
      <p class="text-muted">Oleh {{ $article->author }} • {{ $article->created_at->format('d M Y') }}</p>

      @include('partials.featured-image', [
        'path' => $article->featured_image,
        'alt' => $article->title_id,
        'class' => 'img-fluid rounded mb-3'
      ])

      <div class="article-content">
        {!! $article->content_id !!}
      </div>
    </div>

    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <p><strong>Kategori:</strong> {{ $article->category->name_id ?? '-' }}</p>
          <p><strong>Slug:</strong> {{ $article->slug }}</p>
          <p><strong>Published:</strong> {{ $article->is_published ? 'Ya' : 'Tidak' }}</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection