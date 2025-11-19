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

    <style>
        * {
            font-family: "Poppins", sans-serif;
            box-sizing: border-box;
        }

        body {
            background-color: #f4f6f9;
            margin: 0;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            background: #ffffff;
            border-right: 1px solid #e5e7eb;
            transition: width 0.3s ease;
            box-shadow: 2px 0 6px rgba(0,0,0,0.03);
            padding: 1.5rem 1rem;
            position: fixed;
            height: 100vh;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }

        .sidebar.collapsed {
            width: 78px;
        }

        .sidebar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .sidebar-header .brand {
            font-weight: 600;
            color: #0d6efd;
            font-size: 1.1rem;
        }

        .toggle-btn {
            border: none;
            background: none;
            font-size: 1.3rem;
            color: #0d6efd;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .toggle-btn:hover {
            transform: scale(1.1);
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 10px 12px;
            color: #555;
            font-weight: 500;
            text-decoration: none;
            border-radius: 10px;
            transition: background 0.2s, color 0.2s;
            margin-bottom: 6px;
        }

        .nav-link i {
            font-size: 1.1rem;
            margin-right: 10px;
        }

        .nav-link:hover,
        .nav-link.active {
            background: #e9f2ff;
            color: #0d6efd;
        }

        .sidebar.collapsed .nav-link span {
            display: none;
        }

        .sidebar.collapsed .nav-link i {
            margin: 0 auto;
        }

        /* Logout */
        .logout-btn {
            margin-top: auto;
            border: 1px solid #dc3545;
            color: #dc3545;
            border-radius: 10px;
            font-weight: 500;
            padding: 10px;
            text-align: center;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .logout-btn:hover {
            background: #dc3545;
            color: #fff;
        }

        /* Main */
        .main-content {
            flex: 1;
            margin-left: 240px;
            transition: margin-left 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .sidebar.collapsed ~ .main-content {
            margin-left: 78px;
        }

        /* Topbar */
        .topbar {
            background: #fff;
            padding: 0.8rem 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 99;
        }

        .topbar h5 {
            margin: 0;
            font-weight: 600;
            color: #333;
        }

        .user-info {
            font-weight: 500;
            color: #333;
        }

        /* Konten */
        .content {
            flex: 1;
            padding: 30px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                position: fixed;
                z-index: 1050;
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar.collapsed ~ .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="brand d-flex align-items-center gap-2">
                <i class="bi bi-door-open icon""></i>
                <span>Sistem Kos</span>
            </div>
            <button class="toggle-btn" id="toggleSidebar">
                <i class="bi bi-chevron-double-left"></i>
            </button>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
        </a>
        {{-- <a href="{{ route('pemilik.kos.index') }}" class="nav-link"><i class="bi bi-building"></i> <span>Data Kos</span></a> --}}
        <a href="{{ route('admin.kos.applications') }}" class="nav-link {{ request()->is('admin/kos-applications') ? 'active' : '' }}"><i class="bi bi-journal-text"></i> <span>Pengajuan Kos</span></a>
        {{-- <a href="#" class="nav-link"><i class="bi bi-people"></i> <span>Penghuni</span></a> --}}
        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}"><i class="bi bi-person-x"></i> <span>Kelola Pengguna</span></a>
        <a href="#" class="nav-link"><i class="bi bi-person-badge"></i> <span>Pemilik Kos</span></a>
        <a href="{{ route('admin.revenue') }}" class="nav-link {{ request()->is('admin/revenue') ? 'active' : '' }}"><i class="bi bi-cash-coin"></i> <span>Transaksi</span></a>
        <a href="{{ route('admin.reports.finance') }}" class="nav-link {{ request()->is('admin/reports/finance*') ? 'active' : '' }}"><i class="bi bi-file-earmark-text"></i> <span>Laporan</span></a>
        <a href="{{ route('admin.revenue') }}" class="nav-link d-none"><i class="bi bi-bar-chart-line"></i> <span>Revenue</span></a>

        <a href="{{ route('logout') }}" class="logout-btn mt-4"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <div class="topbar">
            <h5>Dashboard Admin</h5>
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
</body>
</html>
