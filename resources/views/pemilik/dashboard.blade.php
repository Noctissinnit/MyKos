@extends('layouts.ownerkos')

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

    .stat-icon.rooms { background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white; }
    .stat-icon.occupied { background: linear-gradient(135deg, #10b981, #059669); color: white; }
    .stat-icon.empty { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }
    .stat-icon.tenants { background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; }

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

    .revenue-highlight {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 32px;
        box-shadow: 0 4px 16px rgba(16, 185, 129, 0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .revenue-content {
        flex: 1;
    }

    .revenue-label {
        font-size: 14px;
        opacity: 0.9;
        margin-bottom: 4px;
    }

    .revenue-value {
        font-size: 36px;
        font-weight: 700;
        margin: 0;
    }

    .revenue-period {
        font-size: 12px;
        opacity: 0.8;
        margin-top: 4px;
    }

    .pending-alert {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 32px;
        box-shadow: 0 4px 16px rgba(245, 158, 11, 0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .pending-content {
        flex: 1;
    }

    .pending-label {
        font-size: 14px;
        opacity: 0.9;
        margin-bottom: 4px;
    }

    .pending-value {
        font-size: 36px;
        font-weight: 700;
        margin: 0;
    }

    .pending-desc {
        font-size: 12px;
        opacity: 0.8;
        margin-top: 4px;
    }

    .pending-action {
        flex-shrink: 0;
    }

    .btn-primary-custom {
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 12px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-primary-custom:hover {
        background-color: rgba(255, 255, 255, 0.3);
        transform: translateY(-1px);
    }
</style>

<div style="max-width: 1400px; margin: 0 auto; padding: 24px 0;">
    {{-- Welcome Section --}}
    <div class="welcome-section">
        <h1 class="welcome-title">
            <i class="bi bi-speedometer2" style="margin-right: 12px;"></i>
            Selamat Datang, {{ auth()->user()->name }}
        </h1>
        <p class="welcome-subtitle">Kelola kos dan pantau performa bisnis Anda dengan mudah</p>

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

    {{-- Revenue & Pending Requests Highlights --}}
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 32px;">
        <div class="revenue-highlight">
            <div class="revenue-content">
                <div class="revenue-label">
                    <i class="bi bi-cash-coin" style="margin-right: 6px;"></i>
                    Pendapatan Bulan Ini
                </div>
                <div class="revenue-value">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</div>
                <div class="revenue-period">{{ now()->format('F Y') }}</div>
            </div>
        </div>

        @if($totalPendingRequests > 0)
        <div class="pending-alert">
            <div class="pending-content">
                <div class="pending-label">
                    <i class="bi bi-hourglass-split" style="margin-right: 6px;"></i>
                    Permintaan Sewa Pending
                </div>
                <div class="pending-value">{{ $totalPendingRequests }}</div>
                <div class="pending-desc">Menunggu persetujuan Anda</div>
            </div>
            <div class="pending-action">
                <a href="{{ route('pemilik.rental_requests.index') }}" class="btn-primary-custom">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
        @endif
    </div>

    {{-- Statistics Cards --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon rooms">
                    <i class="bi bi-door-closed"></i>
                </div>
            </div>
            <div class="stat-value">{{ $totalKamar }}</div>
            <div class="stat-label">Total Kamar</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon occupied">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
            <div class="stat-value">{{ $kamarTerisi }}</div>
            <div class="stat-label">Kamar Terisi</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon empty">
                    <i class="bi bi-exclamation-circle"></i>
                </div>
            </div>
            <div class="stat-value">{{ $kamarKosong }}</div>
            <div class="stat-label">Kamar Kosong</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon tenants">
                    <i class="bi bi-people"></i>
                </div>
            </div>
            <div class="stat-value">{{ $penghuniAktif }}</div>
            <div class="stat-label">Penghuni Aktif</div>
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
            <a href="{{ route('pemilik.kos.index') }}" class="action-btn">
                <div class="action-icon">
                    <i class="bi bi-building"></i>
                </div>
                <div>
                    <div style="font-weight: 600;">Kelola Kos</div>
                    <div style="font-size: 12px; color: #6b7280;">Tambah dan edit kos</div>
                </div>
            </a>

            <a href="{{ route('pemilik.kamar.index', $kosList->first()?->id ?? '') }}" class="action-btn">
                <div class="action-icon">
                    <i class="bi bi-door-closed"></i>
                </div>
                <div>
                    <div style="font-weight: 600;">Kelola Kamar</div>
                    <div style="font-size: 12px; color: #6b7280;">Atur kamar dan fasilitas</div>
                </div>
            </a>

            <a href="{{ route('pemilik.rental_requests.index') }}" class="action-btn">
                <div class="action-icon">
                    <i class="bi bi-clipboard-check"></i>
                </div>
                <div>
                    <div style="font-weight: 600;">Permintaan Sewa</div>
                    <div style="font-size: 12px; color: #6b7280;">Approve/reject requests</div>
                </div>
            </a>

            <a href="{{ route('pemilik.reports.finance') }}" class="action-btn">
                <div class="action-icon">
                    <i class="bi bi-graph-up"></i>
                </div>
                <div>
                    <div style="font-weight: 600;">Laporan Keuangan</div>
                    <div style="font-size: 12px; color: #6b7280;">Monitor pendapatan</div>
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

        @if(isset($recentPayments) && $recentPayments->count() > 0)
            @foreach($recentPayments->take(5) as $payment)
                <div class="activity-item">
                    <div class="activity-icon success">
                        <i class="bi bi-cash"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">
                            Pembayaran dari {{ $payment->penghuni?->user?->name ?? 'Unknown' }}
                            - Rp {{ number_format($payment->jumlah, 0, ',', '.') }}
                        </div>
                        <div class="activity-time">{{ \Carbon\Carbon::parse($payment->tanggal_bayar)->format('d M Y H:i') }}</div>
                    </div>
                </div>
            @endforeach
        @else
            <div style="text-align: center; padding: 40px 20px; color: #6b7280;">
                <i class="bi bi-info-circle" style="font-size: 48px; margin-bottom: 16px; display: block;"></i>
                <div>Belum ada aktivitas pembayaran</div>
            </div>
        @endif
    </div>
</div>

@endsection
