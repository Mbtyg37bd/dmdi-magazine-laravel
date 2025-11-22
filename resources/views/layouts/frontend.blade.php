<!DOCTYPE html>
<html lang="{{ app()->getLocale() ?? 'id' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DMDI Magazine')</title>
    
    @yield('meta')
    
    <!-- Bootstrap 5 (fallback utilities) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Vite managed assets (Tailwind + app JS) -->
    @vite(['resources/css/app.css','resources/js/app.js'])
    
    @stack('styles')
</head>
<body class="antialiased bg-white text-gray-900">
    @php
      // current locale and current path, used for language links
      $currentLocale = app()->getLocale() ?? 'id';
      $path = request()->getRequestUri();
      // normalize path so '/id/...' doesn't become '/id/id/...'
      $path = preg_replace('#^/(id|en)#', '', $path);
      if ($path === '') { $path = '/'; }
    @endphp

    <!-- Header (made sticky via .site-header) -->
    <header class="site-header border-b bg-white">
      <div class="container mx-auto px-4">
        <div class="d-flex align-items-center justify-content-between py-3" style="display:flex; position:relative;">
          <!-- Left nav (desktop) -->
          <nav class="d-none d-md-flex align-items-center gap-3 text-uppercase" style="gap:1rem;">
            <a href="{{ route('frontend.home', ['locale' => $currentLocale]) }}" class="nav-link">{{ __('nav.home') }}</a>
            <a href="{{ url('/' . $currentLocale . '#politics') }}" class="nav-link">{{ __('nav.politics') }}</a>
            <a href="{{ url('/' . $currentLocale . '#culture') }}" class="nav-link">{{ __('nav.culture') }}</a>
            <a href="{{ url('/' . $currentLocale . '#lifestyle') }}" class="nav-link">{{ __('nav.lifestyle') }}</a>
          </nav>

          <!-- Logo (center on desktop) -->
          <div class="flex-grow-1 d-flex justify-content-center">
            <a href="{{ route('frontend.home', ['locale' => $currentLocale]) }}" class="logo text-center">
              DMDI
            </a>
          </div>

          <!-- Right controls: SEARCH + Locale + mobile toggles -->
          <div class="d-flex align-items-center gap-2">
            <!-- Desktop search form -->
            <form action="{{ route('frontend.search', ['locale' => $currentLocale]) }}" method="GET" class="d-none d-md-flex align-items-center me-3" role="search" style="gap:.5rem;">
              <input
                name="q"
                type="search"
                value="{{ request()->query('q', '') }}"
                placeholder="{{ $currentLocale == 'en' ? 'Search articles...' : 'Cari artikel...' }}"
                class="form-control form-control-sm"
                style="width:220px; padding: .35rem .6rem;"
                aria-label="{{ $currentLocale == 'en' ? 'Search' : 'Cari' }}"
              >
              <button type="submit" class="btn btn-sm btn-outline-secondary" aria-label="Search">
                <i class="bi bi-search"></i>
              </button>
            </form>

            <!-- Locale buttons (desktop) -->
            <div class="d-none d-md-flex align-items-center gap-2" aria-label="{{ __('nav.change_language') }}">
              <a href="{{ url('/id' . $path) }}" class="btn btn-sm {{ $currentLocale == 'id' ? 'btn-secondary' : 'btn-outline-secondary' }}" aria-pressed="{{ $currentLocale == 'id' ? 'true' : 'false' }}">ID</a>
              <a href="{{ url('/en' . $path) }}" class="btn btn-sm {{ $currentLocale == 'en' ? 'btn-secondary' : 'btn-outline-secondary' }}" aria-pressed="{{ $currentLocale == 'en' ? 'true' : 'false' }}">EN</a>
            </div>

            <!-- Mobile search toggle -->
            <button id="mobileSearchToggle" class="d-md-none btn btn-sm me-2" aria-label="Open search">
              <i class="bi bi-search"></i>
            </button>

            <!-- Mobile menu toggle -->
            <button id="mobileMenuToggle" aria-label="Toggle menu" class="d-md-none p-2 border rounded">
              <i class="bi bi-list"></i>
            </button>
          </div>
        </div>

        <!-- Mobile nav (hidden by default) -->
        <div id="mobileNav" class="d-none d-md-none mt-3">
          <nav class="d-flex flex-column gap-2 text-uppercase">
            <a href="{{ route('frontend.home', ['locale' => $currentLocale]) }}" class="block px-2 py-2">{{ __('nav.home') }}</a>
            <a href="{{ url('/' . $currentLocale . '#politics') }}" class="block px-2 py-2">{{ __('nav.politics') }}</a>
            <a href="{{ url('/' . $currentLocale . '#culture') }}" class="block px-2 py-2">{{ __('nav.culture') }}</a>
            <a href="{{ url('/' . $currentLocale . '#lifestyle') }}" class="block px-2 py-2">{{ __('nav.lifestyle') }}</a>

            <div class="border-top mt-2 pt-2 d-flex gap-2 px-2 align-items-center">
              <a href="{{ url('/id' . $path) }}" class="btn btn-sm {{ $currentLocale == 'id' ? 'btn-secondary' : 'btn-outline-secondary' }}">ID</a>
              <a href="{{ url('/en' . $path) }}" class="btn btn-sm {{ $currentLocale == 'en' ? 'btn-secondary' : 'btn-outline-secondary' }}">EN</a>
            </div>
          </nav>
        </div>

        <!-- Mobile inline search bar (hidden by default) -->
        <div id="mobileSearchBar" class="d-none mt-3">
          <form action="{{ route('frontend.search', ['locale' => $currentLocale]) }}" method="GET" class="d-flex" role="search">
            <input name="q" type="search" class="form-control form-control-sm" placeholder="{{ $currentLocale == 'en' ? 'Search articles' : 'Cari artikel' }}" aria-label="Search">
            <button type="submit" class="btn btn-sm btn-outline-secondary ms-2"><i class="bi bi-search"></i></button>
          </form>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer: include the partial footer file -->
    @include('layouts.partials.footer')

    <!-- Small inline script for legacy menu toggle (kept) -->
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('mobileMenuToggle');
        const mobileNav = document.getElementById('mobileNav');
        if (btn && mobileNav) {
          btn.addEventListener('click', () => {
            mobileNav.classList.toggle('d-none');
            mobileNav.classList.toggle('show');
          });
        }
      });
    </script>

    @stack('scripts')
</body>
</html>