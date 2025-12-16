@extends('layouts.admin')

@section('content')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }

    .stat-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .stat-icon.users { background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white; }
    .stat-icon.kos { background: linear-gradient(135deg, #10b981, #059669); color: white; }
    .stat-icon.payments { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }
    .stat-icon.revenue { background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; }

    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 14px;
        color: #6b7280;
        font-weight: 500;
    }

    .quick-actions {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 24px;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-top: 20px;
    }

    .action-btn {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        text-decoration: none;
        color: #374151;
        transition: all 0.2s;
        font-weight: 500;
    }

    .action-btn:hover {
        background: #4a6fa5;
        color: white;
        border-color: #4a6fa5;
        transform: translateY(-2px);
    }

    .action-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        color: #4a6fa5;
    }

    .action-btn:hover .action-icon {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .recent-activity {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .activity-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }

    .activity-icon.success { background: #d1fae5; color: #065f46; }
    .activity-icon.warning { background: #fef3c7; color: #92400e; }
    .activity-icon.info { background: #dbeafe; color: #1d4ed8; }

    .activity-content {
        flex: 1;
    }

    .activity-title {
        font-size: 14px;
        font-weight: 500;
        color: #1f2937;
        margin-bottom: 2px;
    }

    .activity-time {
        font-size: 12px;
        color: #6b7280;
    }

    .welcome-section {
        background: linear-gradient(135deg, #4a6fa5 0%, #3a5a8f 100%);
        color: white;
        border-radius: 12px;
        padding: 32px;
        margin-bottom: 32px;
        box-shadow: 0 4px 16px rgba(74, 111, 165, 0.2);
    }

    .welcome-title {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .welcome-subtitle {
        font-size: 16px;
        opacity: 0.9;
        margin-bottom: 20px;
    }

    .system-status {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .status-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #10b981;
    }
</style>

<div style="max-width: 1400px; margin: 0 auto; padding: 24px 0;">
    {{-- Welcome Section --}}
    <div class="welcome-section">
        <h1 class="welcome-title">
            <i class="bi bi-speedometer2" style="margin-right: 12px;"></i>
            Selamat Datang, {{ auth()->user()->name }}
        </h1>
        <p class="welcome-subtitle">Pantau dan kelola sistem MyKos dengan mudah</p>

        <div class="system-status">
            <div class="status-item">
                <div class="status-dot"></div>
                <span>Sistem Online</span>
            </div>
            <div class="status-item">
                <i class="bi bi-clock"></i>
                <span>{{ now()->format('l, d F Y H:i') }}</span>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon users">
                    <i class="bi bi-people"></i>
                </div>
            </div>
            <div class="stat-value">{{ $stats['total_users'] ?? 0 }}</div>
            <div class="stat-label">Total Pengguna</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon kos">
                    <i class="bi bi-building"></i>
                </div>
            </div>
            <div class="stat-value">{{ $stats['total_kos'] ?? 0 }}</div>
            <div class="stat-label">Total Kos</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon payments">
                    <i class="bi bi-credit-card"></i>
                </div>
            </div>
            <div class="stat-value">{{ $stats['total_payments'] ?? 0 }}</div>
            <div class="stat-label">Total Pembayaran</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon revenue">
                    <i class="bi bi-cash-stack"></i>
                </div>
            </div>
            <div class="stat-value">Rp {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}</div>
            <div class="stat-label">Total Revenue</div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="quick-actions">
        <h5 style="margin: 0 0 4px 0; color: #1f2937;">
            <i class="bi bi-lightning" style="margin-right: 8px;"></i>
            Quick Actions
        </h5>
        <p style="margin: 0 0 20px 0; color: #6b7280; font-size: 14px;">Akses cepat ke fitur utama</p>

        <div class="actions-grid">
            <a href="{{ route('admin.kos.applications') }}" class="action-btn">
                <div class="action-icon">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div>
                    <div style="font-weight: 600;">Pengajuan Kos</div>
                    <div style="font-size: 12px; color: #6b7280;">Approve/Reject aplikasi</div>
                </div>
            </a>

            <a href="{{ route('admin.users.index') }}" class="action-btn">
                <div class="action-icon">
                    <i class="bi bi-people"></i>
                </div>
                <div>
                    <div style="font-weight: 600;">Kelola Pengguna</div>
                    <div style="font-size: 12px; color: #6b7280;">Ban/Unban users</div>
                </div>
            </a>

            <a href="{{ route('admin.reports.finance') }}" class="action-btn">
                <div class="action-icon">
                    <i class="bi bi-graph-up"></i>
                </div>
                <div>
                    <div style="font-weight: 600;">Laporan Keuangan</div>
                    <div style="font-size: 12px; color: #6b7280;">Monitor pembayaran</div>
                </div>
            </a>

            <a href="{{ route('admin.revenue') }}" class="action-btn">
                <div class="action-icon">
                    <i class="bi bi-cash"></i>
                </div>
                <div>
                    <div style="font-weight: 600;">Revenue Report</div>
                    <div style="font-size: 12px; color: #6b7280;">Pendapatan pemilik</div>
                </div>
            </a>
        </div>
    </div>

    {{-- Recent Activity --}}
    <div class="recent-activity">
        <h5 style="margin: 0 0 20px 0; color: #1f2937;">
            <i class="bi bi-activity" style="margin-right: 8px;"></i>
            Aktivitas Terbaru
        </h5>

        @if(isset($recentActivities) && $recentActivities->count() > 0)
            @foreach($recentActivities as $activity)
                <div class="activity-item">
                    <div class="activity-icon {{ $activity['type'] }}">
                        <i class="bi {{ $activity['icon'] }}"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">{{ $activity['title'] }}</div>
                        <div class="activity-time">{{ $activity['time'] }}</div>
                    </div>
                </div>
            @endforeach
        @else
            <div style="text-align: center; padding: 40px 20px; color: #6b7280;">
                <i class="bi bi-info-circle" style="font-size: 48px; margin-bottom: 16px; display: block;"></i>
                <div>Belum ada aktivitas terbaru</div>
            </div>
        @endif
    </div>
</div>

@endsection
