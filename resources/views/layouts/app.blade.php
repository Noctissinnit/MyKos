<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Informasi Kos')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        * {
            font-family: "Poppins", sans-serif;
            box-sizing: border-box;
        }

        body {
            background-color: #f5f7fa;
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar */
        .navbar {
            background-color: #ffffff !important;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }

        .navbar-brand {
            font-weight: 600;
            color: #0d6efd !important;
        }

        .nav-link {
            color: #555 !important;
            transition: color 0.3s, transform 0.2s;
        }

        .nav-link:hover {
            color: #0d6efd !important;
            transform: translateY(-1px);
        }

        .nav-link.active {
            color: #0d6efd !important;
            font-weight: 500;
        }

        /* Container Content */
        .container-content {
            background: #ffffff;
            border-radius: 14px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            margin-top: 50px;
            flex-grow: 1;
        }

        /* Buttons */
        .btn-primary {
            background-color: #0d6efd;
            border: none;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
        }

        footer {
            text-align: center;
            color: #666;
            font-size: 0.9rem;
            padding: 20px 0;
            margin-top: 40px;
            border-top: 1px solid #e5e7eb;
        }

        @media (max-width: 768px) {
            .container-content {
                padding: 25px;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/user/dashboard') }}">
                <i class="bi bi-door-open icon""></i> Kos ku
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('user.dashboard') || request()->is('/') ? 'active' : '' }}" href="{{ url('/user/dashboard') }}">
                            <i class="bi bi-house-door me-1"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('user.kos.*') ? 'active' : '' }}" href="{{ route('user.kos.index') }}">
                            <i class="bi bi-search me-1"></i> Cari Kos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('user.rental_requests.*') ? 'active' : '' }}" href="{{ route('user.rental_requests.index') }}">
                            <i class="bi bi-card-list me-1"></i> Pesanan Saya
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('user.pembayarans.*') ? 'active' : '' }}" href="{{ route('user.pembayarans.index') }}">
                            <i class="bi bi-wallet2 me-1"></i> Pembayaran
                        </a>
                    </li>
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
    <div class="container container-content">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer>
        © {{ date('Y') }} Sistem Informasi Kos — Semua Hak Dilindungi
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
