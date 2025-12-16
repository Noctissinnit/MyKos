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
    <style>
        .btn-logout {
            background-color: #4a6fa5;
            color: white;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            background-color: #3a5a8f;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(74, 111, 165, 0.3);
        }

        .btn-login {
            background-color: white;
            color: #4a6fa5;
            border: 2px solid #4a6fa5;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background-color: #4a6fa5;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(74, 111, 165, 0.3);
        }

        .btn-register {
            background-color: #4a6fa5;
            color: white;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-register:hover {
            background-color: #3a5a8f;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(74, 111, 165, 0.3);
        }

        .footer {
        background: #ffffff;
        border-top: 1px solid #E5E5E5;
        padding: 24px 0;
        margin-top: 40px;
    }

    .footer-title {
        font-weight: 600;
        color: #222;
        margin-bottom: 8px;
    }

    .footer-text {
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 6px;
    }

    .footer-link {
        color: #4a6fa5;
        text-decoration: none;
        font-size: 14px;
    }

    .footer-link:hover {
        text-decoration: underline;
    }

    .footer-bottom {
        border-top: 1px dashed #E5E5E5;
        margin-top: 20px;
        padding-top: 14px;
        font-size: 13px;
        color: #9aa0a6;
    }

    .footer-icon {
        font-size: 18px;
        color: #4a6fa5;
        margin-right: 10px;
        transition: .2s;
    }

    .footer-icon:hover {
        color: #3a5a8f;
        transform: translateY(-2px);
    }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
                <img src="{{ asset('img/logomykos.png') }}" alt="Logo" width="100" height="100" class="img-fluid">
                
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
                            <i class="bi bi-house-door me-1"></i> Dashboard
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
                            <a href="{{ route('logout') }}" class="btn btn-sm ms-2 btn-logout"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        </li>
                    @else
                        <li class="nav-item me-2">
                            <a href="{{ route('login') }}" class="btn btn-sm btn-login">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="btn btn-sm btn-register">
                                <i class="bi bi-person-plus"></i> Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <main class="px-3 py-4 w-100">
        @yield('content')
    </main>


    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row text-start">

                {{-- Brand --}}
                <div class="col-md-4 mb-3">
                    <h5 class="footer-title">MyKos</h5>
                    <p class="footer-text">
                        Platform pencarian dan pengelolaan kos yang mudah, aman, dan terpercaya.
                    </p>
                </div>

                {{-- Menu --}}
                <div class="col-md-4 mb-3">
                    <h6 class="footer-title">Menu</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('user.kos.index') }}" class="footer-link">Cari Kos</a></li>
                        @auth
                            <li><a href="{{ route('user.dashboard') }}" class="footer-link">Dashboard</a></li>
                            <li><a href="{{ route('user.rental_requests.index') }}" class="footer-link">Pesanan Saya</a></li>
                            <li><a href="{{ route('user.pembayarans.index') }}" class="footer-link">Pembayaran</a></li>
                        @endauth
                    </ul>
                </div>

                {{-- Kontak --}}
                <div class="col-md-4 mb-3">
                    <h6 class="footer-title">Kontak</h6>
                    <p class="footer-text mb-1">
                        <i class="bi bi-envelope me-1"></i> support@mykos.id
                    </p>
                    <p class="footer-text mb-2">
                        <i class="bi bi-geo-alt me-1"></i> Indonesia
                    </p>

                    <div>
                        <a href="#" class="footer-icon"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="footer-icon"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="footer-icon"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>

            </div>

            {{-- Bottom --}}
            <div class="text-center footer-bottom">
                {{ \Illuminate\Support\Facades\Cache::get(
                    'footer_text',
                    '© ' . date('Y') . ' MyKos — Sistem Informasi Kos | Kelompok 4'
                ) }}
            </div>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
