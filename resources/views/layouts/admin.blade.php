<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - MyKos</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/ui.min.css') }}">
        <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f5f5f5;
            font-family: 'Poppins', sans-serif;
        }

        .layout-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            background-color: #f8f9fa;
            border-right: 1px solid #e9ecef;
            padding: 24px 16px;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            transition: width 0.3s ease;
            left: 0;
        }

        .sidebar.minimized {
            width: 80px;
            padding: 16px 8px;
        }

        .sidebar.minimized .sidebar-header {
            margin-bottom: 16px;
        }

        .sidebar.minimized .brand span {
            display: none;
        }

        .sidebar.minimized .nav-link span {
            display: none;
        }

        .sidebar.minimized .nav-link {
            padding: 12px 8px;
        }

        .sidebar.minimized .logout-btn span {
            display: none;
        }

        .sidebar.minimized .logout-btn {
            justify-content: center;
            padding: 12px 8px;
        }

        .sidebar-header {
            margin-bottom: 32px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .brand i {
            font-size: 28px;
            color: #4a6fa5;
        }

        .brand span {
            font-size: 18px;
            font-weight: 700;
            color: #1f1f1f;
        }

        .nav-menu {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 24px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 18px;
            color: #6c757d;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 15px;
            font-weight: 500;
            justify-content: flex-start;
            margin-bottom: 0;
        }

        .nav-link:hover {
            background-color: #e7f1f8;
            color: #4a6fa5;
        }

        .nav-link.active {
            background-color: #d1e3f0;
            color: #4a6fa5;
            font-weight: 600;
        }

        .nav-link i {
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        .nav-menu {
            display: flex;
            flex-direction: column;
            gap: 0;
            margin-bottom: 24px;
        }

        .sidebar-bottom {
            margin-top: auto;
            padding-top: 16px;
            border-top: 1px solid #e9ecef;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            background-color: #4a6fa5;
            color: white;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 500;
            width: 100%;
            justify-content: center;
        }

        .logout-btn:hover {
            background-color: #3a5a8f;
            color: white;
        }

        .logout-btn i {
            font-size: 18px;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            flex: 1;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
        }

        .main-content.minimized {
            margin-left: 80px;
        }

        /* Navbar */
        .topbar {
            background-color: white;
            padding: 16px 28px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
        }

        .topbar h5 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            color: #1f1f1f;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #6c757d;
        }

        .user-info i {
            font-size: 24px;
            color: #4a6fa5;
        }

        .toggle-sidebar-btn {
            background: none;
            border: none;
            font-size: 24px;
            color: #4a6fa5;
            cursor: pointer;
            padding: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .toggle-sidebar-btn:hover {
            color: #3a5a8f;
        }

        /* Content */
        .content {
            padding: 28px;
            flex: 1;
        }

        /* Scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }
    </style>
</head>

<body>
    <div class="layout-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="brand">
                     <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
                        <img src="{{ asset('img/logomykos.png') }}" alt="Logo" width="100" height="100" class="img-fluid">
                        
                    </a>
                </div>
            </div>

            <nav class="nav-menu">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.kos.applications') }}" class="nav-link {{ request()->is('admin/kos-applications') ? 'active' : '' }}">
                    <i class="bi bi-journal-text"></i> <span>Pengajuan Kos</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}">
                    <i class="bi bi-person-x"></i> <span>Kelola Pengguna</span>
                </a>
                <a href="{{ route('admin.revenue') }}" class="nav-link {{ request()->is('admin/revenue') ? 'active' : '' }}">
                    <i class="bi bi-cash-coin"></i> <span>Transaksi</span>
                </a>
                <a href="{{ route('admin.reports.finance') }}" class="nav-link {{ request()->is('admin/reports/finance*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text"></i> <span>Laporan</span>
                </a>
                <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->is('admin/settings*') ? 'active' : '' }}">
                    <i class="bi bi-gear"></i> <span>Pengaturan</span>
                </a>
                <a href="{{ route('admin.content.index') }}" class="nav-link {{ request()->is('admin/content*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text"></i> <span>Konten</span>
                </a>
                <a href="{{ route('admin.analytics.index') }}" class="nav-link {{ request()->is('admin/analytics*') ? 'active' : '' }}">
                    <i class="bi bi-graph-up"></i> <span>Analytics</span>
                </a>
            </nav>

            <div class="sidebar-bottom">
                <a href="{{ route('logout') }}" class="logout-btn"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            <div class="topbar">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <button class="toggle-sidebar-btn" id="toggleSidebarBtn">
                        <i class="bi bi-list"></i>
                    </button>
                    <h5 style="margin: 0;">Dashboard</h5>
                </div>
                <div class="user-info">
                    <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                </div>
            </div>

        <div class="content">
            @yield('content')
        </div>
    </div>
    </div>

    <!-- Bootstrap JS bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const toggleBtn = document.getElementById('toggleSidebarBtn');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('minimized');
            mainContent.classList.toggle('minimized');
            
            // Save state to localStorage
            const isMinimized = sidebar.classList.contains('minimized');
            localStorage.setItem('sidebarMinimized', isMinimized);
        });

        // Restore sidebar state on page load
        window.addEventListener('load', () => {
            const isMinimized = localStorage.getItem('sidebarMinimized') === 'true';
            if (isMinimized) {
                sidebar.classList.add('minimized');
                mainContent.classList.add('minimized');
            }
        });
    </script>
</body>
</html>
