<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', config('app.name')) — Admin</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons. css" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  @stack('styles')
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="{{ url('/') }}">
      <i class="bi bi-journal-text me-2"></i>
      {{ config('app.name') }}
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="adminNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" 
             href="{{ route('admin. dashboard') }}">
            <i class="bi bi-speedometer2 me-1"></i>
            Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('admin/articles*') ? 'active' : '' }}" 
             href="{{ route('admin.articles. index') }}">
            <i class="bi bi-newspaper me-1"></i>
            Articles
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}" 
             href="{{ route('admin. categories.index') }}">
            <i class="bi bi-folder me-1"></i>
            Categories
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('admin/ads*') ? 'active' : '' }}" 
             href="{{ route('admin.ads.index') }}">
            <i class="bi bi-megaphone me-1"></i>
            Ads
          </a>
        </li>
      </ul>

      <ul class="navbar-nav ms-auto">
        @auth
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" data-bs-toggle="dropdown">
              <i class="bi bi-person-circle me-1"></i>
              {{ auth()->user()->name ?? auth()->user()->email }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item" href="{{ url('/id') }}" target="_blank">
                  <i class="bi bi-box-arrow-up-right me-2"></i>
                  View Site
                </a>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form method="POST" action="{{ route('admin.logout') }}" class="m-0">
                  @csrf
                  <button class="dropdown-item text-danger" type="submit">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    Logout
                  </button>
                </form>
              </li>
            </ul>
          </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid mt-4">
  <div class="row">
    <aside class="col-md-2 mb-4">
      <div class="card shadow-sm">
        <div class="card-header bg-white">
          <h6 class="mb-0 fw-bold">Navigation</h6>
        </div>
        <div class="list-group list-group-flush">
          <a href="{{ route('admin.dashboard') }}" 
             class="list-group-item list-group-item-action {{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2 me-2"></i>
            Dashboard
          </a>
          <a href="{{ route('admin.articles.index') }}" 
             class="list-group-item list-group-item-action {{ request()->is('admin/articles*') ? 'active' : '' }}">
            <i class="bi bi-newspaper me-2"></i>
            Articles
          </a>
          <a href="{{ route('admin.categories.index') }}" 
             class="list-group-item list-group-item-action {{ request()->is('admin/categories*') ? 'active' : '' }}">
            <i class="bi bi-folder me-2"></i>
            Categories
          </a>
          <a href="{{ route('admin.ads.index') }}" 
             class="list-group-item list-group-item-action {{ request()->is('admin/ads*') ? 'active' : '' }}">
            <i class="bi bi-megaphone me-2"></i>
            Ads
          </a>
        </div>
      </div>
    </aside>

    <main class="col-md-10">
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="bi bi-check-circle me-2"></i>
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif
      
      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="bi bi-exclamation-triangle me-2"></i>
          {{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      @yield('content')
    </main>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>