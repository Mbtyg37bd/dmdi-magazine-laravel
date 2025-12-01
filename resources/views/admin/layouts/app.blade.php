<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', config('app.name')) — Admin</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  @stack('styles')
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>

    <div class="collapse navbar-collapse" id="adminNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="{{ route('ads.index') }}">Ads</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ url('/admin') }}">Dashboard</a></li>
      </ul>

      <ul class="navbar-nav ms-auto">
        @auth
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              {{ auth()->user()->name ?? auth()->user()->email }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
              <li><a class="dropdown-item" href="{{ url('/') }}" target="_blank">View site</a></li>

              {{-- Only show logout form/link if logout route exists --}}
              @if (Route::has('logout'))
                <li>
                  <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button class="dropdown-item" type="submit">Logout</button>
                  </form>
                </li>
              @else
                {{-- Fallback: if no logout route, show a safe link or nothing --}}
                <li><a class="dropdown-item" href="{{ url('/admin/logout') }}">Logout</a></li>
              @endif

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
      <div class="card">
        <div class="list-group list-group-flush">
          <a href="{{ url('/admin') }}" class="list-group-item list-group-item-action">Dashboard</a>
          <a href="{{ route('ads.index') }}" class="list-group-item list-group-item-action">Ads</a>
        </div>
      </div>
    </aside>

    <main class="col-md-10">
      @yield('content')
    </main>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>