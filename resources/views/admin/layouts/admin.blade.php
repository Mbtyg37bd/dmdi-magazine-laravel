<! DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - DMDI Magazine')</title>
    
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons. css" rel="stylesheet">
    
    <!-- BLOCK TINYMCE -->
    <script>
        window.tinymce = undefined;
        if (typeof tinymce !== 'undefined') {
            delete window.tinymce;
        }
    </script>
    
    <style>
        .sidebar {
            min-height: 100vh;
            background: #2c3e50;
        }
        
        .sidebar .nav-link {
            color: #ecf0f1;
            padding: 0.75rem 1rem;
            border-radius: 0.25rem;
            margin: 0.25rem 0;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link. active {
            background: #34495e;
            color: #3498db;
        }
        
        .main-content {
            background: #f8f9fa;
            min-height: 100vh;
        }
        
        .navbar-admin {
            background: #fff;
            border-bottom: 1px solid #dee2e6;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="p-3">
                    <h4 class="text-white text-center mb-4">
                        <i class="bi bi-journal-text"></i>
                        DMDI ADMIN
                    </h4>
                    
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" 
                               href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2 me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/articles*') ? 'active' : '' }}" 
                               href="{{ route('admin.articles.index') }}">
                                <i class="bi bi-newspaper me-2"></i>
                                Artikel
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}" 
                               href="{{ route('admin.categories.index') }}">
                                <i class="bi bi-folder me-2"></i>
                                Kategori
                            </a>
                        </li>

                        

                        @auth
                            @if(auth()->user()->is_admin)
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/ads*') ? 'active' : '' }}" 
                                       href="{{ route('admin.ads.index') }}">
                                        <i class="bi bi-megaphone me-2"></i>
                                        Iklan
                                    </a>
                                </li>
                            @endif
                        @endauth

                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-image me-2"></i>
                                Media
                            </a>
                        </li>
                        <li class="nav-item mt-4">
                            <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="nav-link text-danger border-0 bg-transparent w-100 text-start">
                                    <i class="bi bi-box-arrow-right me-2"></i>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content p-0">
                <!-- Top Navbar -->
                <nav class="navbar navbar-admin">
                    <div class="container-fluid">
                        <span class="navbar-brand mb-0 h6">
                            <i class="bi bi-house me-2"></i>
                            @yield('page-title', 'Dashboard')
                        </span>
                        
                        <div class="d-flex align-items-center">
                            <span class="text-muted small me-3">
                                <i class="bi bi-person me-1"></i>
                                {{ Auth::user()->name }}
                            </span>
                        </div>
                    </div>
                </nav>
                
                <!-- Page Content -->
                <main class="p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>