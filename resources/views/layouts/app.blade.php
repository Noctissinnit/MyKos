<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Informasi Kos')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ui.min.css') }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
                <i class="bi bi-door-open icon"></i>
                <span class="fw-bold">Kos ku</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
               <ul class="navbar-nav me-auto">

    
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.kos.*') ? 'active' : '' }}" 
                    href="{{ route('user.kos.index') }}">
                        <i class="bi bi-search me-1"></i> Cari Kos
                    </a>
                </li>

              
                @auth
                    <li class="nav-item">
                        <a class="nav-link 
                        {{ request()->routeIs('user.dashboard') || request()->is('/') ? 'active' : '' }}" 
                        href="{{ url('/user/dashboard') }}">
                            <i class="bi bi-house-door me-1"></i> Beranda
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('user.rental_requests.*') ? 'active' : '' }}" 
                        href="{{ route('user.rental_requests.index') }}">
                            <i class="bi bi-card-list me-1"></i> Pesanan Saya
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('user.pembayarans.*') ? 'active' : '' }}" 
                        href="{{ route('user.pembayarans.index') }}">
                            <i class="bi bi-wallet2 me-1"></i> Pembayaran
                        </a>
                    </li>
                @endauth

            </ul>


                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item d-flex align-items-center me-2">
                            <span class="text-secondary small">
                                <i class="bi bi-person-circle me-1"></i> {{ auth()->user()->name }}
                            </span>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="btn btn-primary btn-sm ms-2"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        </li>
                    @else
                        <li class="nav-item me-2">
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-person-plus"></i> Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <main class="container container-content py-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer mt-4 py-3 text-center text-muted">
        <div class="container">
            © {{ date('Y') }} Sistem Informasi Kos — Kelompok 6
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
