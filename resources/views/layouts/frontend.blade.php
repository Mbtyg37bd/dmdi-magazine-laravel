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
    <!-- Header -->
    <header class="main-header py-4 border-b">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between">
                <a href="{{ url('/' . (app()->getLocale() ?? 'id')) }}" class="logo text-2xl font-display font-bold tracking-tight">
                    DMDI
                </a>

                <div class="hidden md:flex items-center gap-6">
                    <nav class="flex gap-4 text-sm uppercase tracking-wider">
                        <a href="{{ url('/' . (app()->getLocale() ?? 'id')) }}" class="nav-link">HOME</a>
                        <a href="{{ url('/' . (app()->getLocale() ?? 'id') . '#politics') }}" class="nav-link">POLITIK</a>
                        <a href="{{ url('/' . (app()->getLocale() ?? 'id') . '#culture') }}" class="nav-link">BUDAYA</a>
                        <a href="{{ url('/' . (app()->getLocale() ?? 'id') . '#lifestyle') }}" class="nav-link">GAYA HIDUP</a>
                    </nav>

                    <div class="lang-switcher">
                        @include('layouts.partials.lang-toggle')
                    </div>
                </div>

                <button id="mobileMenuToggle" class="md:hidden p-2">
                    <i class="bi bi-list text-2xl"></i>
                </button>
            </div>
            <!-- Mobile nav (hidden by default) -->
            <div id="mobileNav" class="hidden mt-3 md:hidden">
                <nav class="flex flex-col gap-2 text-sm uppercase">
                    <a href="{{ url('/' . (app()->getLocale() ?? 'id')) }}" class="nav-link">HOME</a>
                    <a href="{{ url('/' . (app()->getLocale() ?? 'id') . '#politics') }}" class="nav-link">POLITIK</a>
                    <a href="{{ url('/' . (app()->getLocale() ?? 'id') . '#culture') }}" class="nav-link">BUDAYA</a>
                    <a href="{{ url('/' . (app()->getLocale() ?? 'id') . '#lifestyle') }}" class="nav-link">GAYA HIDUP</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-200 py-8 mt-12">
        <div class="container mx-auto px-4">
            <div class="text-center text-sm">© {{ date('Y') }} DMDI Magazine</div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>