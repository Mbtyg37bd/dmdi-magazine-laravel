@extends('layouts.frontend')

@section('title', $page->getTitle())

@section('meta')
    <meta name="description" content="{{ $page->getMetaDescription() }}">
    <meta property="og:title" content="{{ $page->getTitle() }}">
    <meta property="og:description" content="{{ $page->getMetaDescription() }}">
    <meta property="og:type" content="website">
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('frontend.home', ['locale' => app()->getLocale()]) }}">
                            {{ __('nav.home') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $page->getTitle() }}
                    </li>
                </ol>
            </nav>

            <!-- Page Title (HANYA SATU) -->
            <h1 class="display-4 fw-bold mb-4" style="font-family: 'Playfair Display', serif;">
                {{ $page->getTitle() }}
            </h1>


            <!-- Page Content -->
            <div class="page-content prose">
                {!! $page->getContent() !!}
            </div>

            <!-- Back to Home -->
            <div class="mt-5 pt-4 border-top">
                <a href="{{ route('frontend.home', ['locale' => app()->getLocale()]) }}" 
                   class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-2"></i>
                    {{ app()->getLocale() == 'id' ? 'Kembali ke Beranda' : 'Back to Home' }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Page Content Styling */
.page-content {
    font-size: 1.05rem;
    line-height:  1.8;
    color: #333;
}

. page-content h2 {
    font-family:  'Playfair Display', serif;
    font-size:  2rem;
    font-weight: 700;
    margin-top: 2.5rem;
    margin-bottom: 1rem;
    color: #111827;
}

.page-content h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.5rem;
    font-weight: 600;
    margin-top: 2rem;
    margin-bottom: 0.75rem;
    color: #111827;
}

.page-content p {
    margin-bottom: 1.25rem;
}

.page-content ul,
.page-content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.page-content li {
    margin-bottom: 0.5rem;
}

.page-content a {
    color: #2563eb;
    text-decoration: underline;
}

.page-content a:hover {
    color: #1d4ed8;
}

. page-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin:  1.5rem 0;
}

. page-content blockquote {
    border-left: 4px solid #e5e7eb;
    padding-left: 1.5rem;
    margin: 1.5rem 0;
    font-style: italic;
    color: #6b7280;
}

.breadcrumb {
    background:  transparent;
    padding: 0;
    margin-bottom: 1rem;
}

.breadcrumb-item a {
    color: #6b7280;
    text-decoration: none;
}

.breadcrumb-item a:hover {
    color: #111827;
    text-decoration: underline;
}

.breadcrumb-item. active {
    color: #111827;
}
</style>
@endpush