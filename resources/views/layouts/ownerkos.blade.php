<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Sistem Kos</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/ui.min.css') }}">
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
                <div class="brand d-flex align-items-center gap-2">
                <i class="bi bi-door-open icon"></i>
                <span>Sistem Kos</span>
            </div>
            <button class="toggle-btn" id="toggleSidebar">
                <i class="bi bi-chevron-double-left"></i>
            </button>
        </div>

        <a href="{{ route('pemilik.dashboard') }}" class="nav-link {{ request()->is('pemilik/dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
        </a>
        <a href="{{ route('pemilik.kos.index') }}" class="nav-link {{ request()->is('kos*') ? 'active' : '' }}"><i class="bi bi-building"></i> <span>Data Kos</span></a>
        <a href="{{ route('pemilik.kos.create') }}" class="nav-link {{ request()->is('kos/create') ? 'active' : '' }}"><i class="bi bi-plus-square"></i> <span>Tambah Kos</span></a>
        <a href="{{ route('pemilik.rental_requests.index') }}" class="nav-link {{ request()->is('pemilik/rental-requests*') ? 'active' : '' }}"><i class="bi bi-person-badge"></i> <span>Permintaan Sewa</span></a>
        <a href="{{ route('pemilik.kamars.index') }}" class="nav-link {{ request()->is('pemilik/kamars*') ? 'active' : '' }}"><i class="bi bi-people"></i> <span>Daftar Kamar</span></a>
       <a href="{{ route('pemilik.reports.transactions') }}" class="nav-link {{ request()->is('pemilik.reports.transactions*') ? 'active' : '' }}">             <i class="bi bi-cash-coin"></i> <span>Transaksi</span>
                    </a>
       
        <a href="{{ route('pemilik.reports.finance') }}" class="nav-link {{ request()->is('pemilik/reports/finance*') ? 'active' : '' }}"><i class="bi bi-file-earmark-text"></i> <span>Laporan</span></a>

        <a href="{{ route('logout') }}" class="logout-btn mt-4"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <div class="topbar">
            <h5>Dashboard Owner</h5>
            <div class="user-info">
                <i class="bi bi-person-circle text-primary me-2"></i> {{ auth()->user()->name }}
            </div>
        </div>

        <div class="content">
            @yield('content')
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebar');
        const icon = toggleBtn.querySelector('i');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            if (sidebar.classList.contains('collapsed')) {
                icon.classList.replace('bi-chevron-double-left', 'bi-chevron-double-right');
            } else {
                icon.classList.replace('bi-chevron-double-right', 'bi-chevron-double-left');
            }
        });
    </script>

    <!-- Bootstrap JS (Bundle includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* small layout tweaks for owner layout using ui.min.css variables */
        .sidebar{background:var(--card);border-right:1px solid rgba(2,6,23,0.04)}
        .sidebar .brand{font-weight:700;color:var(--accent)}
        .logout-btn{border-radius:8px;padding:8px}
        .content{padding:28px}
    </style>


    @yield('scripts')
</body>
</html>
