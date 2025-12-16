@extends('layouts.app')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
        padding-bottom: 24px;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .page-header .left {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    
    .page-header h2 {
        margin: 0;
        font-size: 28px;
        font-weight: 600;
        color: #1f2937;
    }
    
    .page-header p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }
    
    .btn-header {
        background-color: #4a6fa5;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-header:hover {
        background-color: #3a5a8f;
        color: white;
        transform: translateY(-2px);
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 16px;
        margin-bottom: 32px;
    }
    
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }
    
    .stat-label {
        font-size: 13px;
        color: #6b7280;
        font-weight: 500;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: #1f2937;
    }
    
    .stat-icon {
        font-size: 24px;
    }
    
    .stat-icon.warning { color: #f59e0b; }
    .stat-icon.success { color: #10b981; }
    .stat-icon.danger { color: #ef4444; }
    
    .card-section {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 24px;
    }
    
    .card-header {
        background-color: #f3f4f6;
        border-bottom: 1px solid #e5e7eb;
        padding: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .card-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
    }
    
    .card-body {
        padding: 16px;
    }
    
    .list-group-item {
        border: none;
        border-bottom: 1px solid #f3f4f6;
        padding: 12px 0;
    }
    
    .list-group-item:last-child {
        border-bottom: none;
    }
    
    .badge {
        padding: 6px 10px;
        font-weight: 500;
        font-size: 12px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    
    .badge-warning {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .badge-success {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .badge-danger {
        background-color: #fee2e2;
        color: #dc2626;
    }
    
    .btn-action {
        background-color: #4a6fa5;
        color: white;
        border: none;
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .btn-action:hover {
        background-color: #3a5a8f;
        color: white;
        transform: translateY(-2px);
    }
    
    .empty-message {
        text-align: center;
        color: #9ca3af;
        padding: 20px;
    }
</style>

<div style="max-width: 1400px; margin: 0 auto; padding: 24px 0;">
    <div class="page-header">
        <div class="left">
            <h2><i class="bi bi-house-door" style="margin-right: 12px;"></i>Selamat datang, {{ auth()->user()->name }}</h2>
            <p>Dashboard pengguna — kelola permintaan sewa dan pembayaran Anda.</p>
        </div>
        <a href="{{ route('user.kos.index') }}" class="btn-header">
            <i class="bi bi-search"></i> Jelajahi Kos
        </a>
    </div>

    {{-- STAT CARDS --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">
                <i class="bi bi-hourglass-split stat-icon warning"></i>
                Permintaan Sewa Pending
            </div>
            <div class="stat-value" style="color: #f59e0b;">
                @php
                    $pendingCount = \App\Models\RentalRequest::where('user_id', auth()->id())->where('status', 'pending')->count();
                @endphp
                {{ $pendingCount }}
            </div>
            @if($pendingCount > 0)
                <a href="{{ route('user.rental_requests.index') }}" class="btn-action" style="margin-top: 12px; font-size: 12px; padding: 6px 12px;">
                    Lihat Permintaan
                </a>
            @endif
        </div>

        <div class="stat-card">
            <div class="stat-label">
                <i class="bi bi-check-circle stat-icon success"></i>
                Sewa Aktif
            </div>
            <div class="stat-value" style="color: #10b981;">
                @php
                    $activeCount = \App\Models\Penghuni::where('user_id', auth()->id())->where('status', 'aktif')->count();
                @endphp
                {{ $activeCount }}
            </div>
            @if($activeCount > 0)
                <a href="{{ route('user.pembayarans.index') }}" class="btn-action" style="margin-top: 12px; font-size: 12px; padding: 6px 12px;">
                    Lihat Pembayaran
                </a>
            @endif
        </div>

        <div class="stat-card">
            <div class="stat-label">
                <i class="bi bi-exclamation-triangle stat-icon danger"></i>
                Tagihan Menunggu
            </div>
            <div class="stat-value" style="color: #ef4444;">
                @php
                    $penghuniIds = \App\Models\Penghuni::where('user_id', auth()->id())->pluck('id');
                    $duePayments = \App\Models\Pembayaran::whereIn('penghuni_id', $penghuniIds)->where('verified', false)->count();
                @endphp
                {{ $duePayments }}
            </div>
            @if($duePayments > 0)
                <a href="{{ route('user.pembayarans.index') }}" class="btn-action" style="margin-top: 12px; font-size: 12px; padding: 6px 12px;">
                    Bayar Sekarang
                </a>
            @endif
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
        {{-- RECENT REQUESTS --}}
        <div class="card-section">
            <div class="card-header">
                <h3><i class="bi bi-clock-history" style="margin-right: 8px;"></i>Permintaan Sewa Terbaru</h3>
            </div>
            <div class="card-body">
                @if($recentRequests->isEmpty())
                    <div class="empty-message">
                        <i class="bi bi-inbox" style="font-size: 24px; margin-bottom: 8px;"></i><br>
                        Belum ada permintaan sewa.
                    </div>
                @else
                    <div style="display: flex; flex-direction: column; gap: 0;">
                        @foreach($recentRequests as $r)
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #f3f4f6;">
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; color: #1f2937; margin-bottom: 4px;">{{ $r->kos->nama ?? '-' }}</div>
                                    <div style="font-size: 12px; color: #6b7280;">
                                        @if($r->kamar) 
                                            Kamar {{ $r->kamar->nomor }} 
                                        @elseif($r->roomType) 
                                            {{ $r->roomType->nama }} 
                                        @endif
                                        • {{ $r->start_date->format('d M Y') }} - {{ $r->end_date->format('d M Y') }}
                                    </div>
                                </div>
                                <div>
                                    <span class="badge badge-{{ $r->status == 'pending' ? 'warning' : ($r->status == 'approved' ? 'success' : 'danger') }}">
                                        {{ ucfirst($r->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- RECENT PAYMENTS --}}
        <div class="card-section">
            <div class="card-header">
                <h3><i class="bi bi-credit-card" style="margin-right: 8px;"></i>Transaksi Terakhir</h3>
            </div>
            <div class="card-body">
                @if($recentPayments->isEmpty())
                    <div class="empty-message">
                        <i class="bi bi-receipt" style="font-size: 24px; margin-bottom: 8px;"></i><br>
                        Belum ada transaksi.
                    </div>
                @else
                    <div style="display: flex; flex-direction: column; gap: 0;">
                        @foreach($recentPayments as $p)
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #f3f4f6;">
                                <div style="flex: 1;">
                                    <div style="font-weight: 700; color: #1f2937; margin-bottom: 4px;">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</div>
                                    <div style="font-size: 12px; color: #6b7280;">{{ $p->tanggal_bayar->format('d M Y') }}</div>
                                </div>
                                <div>
                                    <span class="badge badge-{{ $p->verified ? 'success' : 'warning' }}">
                                        {{ $p->verified ? 'Terverifikasi' : 'Menunggu' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>

@endsection
