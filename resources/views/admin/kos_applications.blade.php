@extends('layouts.admin')

@section('content')
<style>
    .page-header {
        margin-bottom: 32px;
        padding-bottom: 24px;
        border-bottom: 1px solid #e5e7eb;
    }

    .page-header h1 {
        margin: 0 0 8px 0;
        font-size: 28px;
        font-weight: 600;
        color: #1f2937;
    }

    .page-header p {
        margin: 0;
        color: #6b7280;
        font-size: 16px;
    }

    .applications-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
    }

    .card-header-custom {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        padding: 24px;
        border-bottom: 1px solid #e5e7eb;
    }

    .card-header-custom h5 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
    }

    .stats-bar {
        display: flex;
        gap: 24px;
        margin-top: 16px;
        flex-wrap: wrap;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: #6b7280;
    }

    .stat-number {
        font-weight: 600;
        color: #4a6fa5;
    }

    .application-item {
        padding: 24px;
        border-bottom: 1px solid #f3f4f6;
        transition: all 0.2s;
    }

    .application-item:hover {
        background-color: #f8fafc;
    }

    .application-item:last-child {
        border-bottom: none;
    }

    .application-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 16px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .kos-info {
        flex: 1;
        min-width: 200px;
    }

    .kos-name {
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .kos-owner {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 8px;
    }

    .kos-address {
        font-size: 14px;
        color: #374151;
        margin-bottom: 8px;
    }

    .kos-description {
        font-size: 14px;
        color: #6b7280;
        line-height: 1.5;
        margin-bottom: 16px;
    }

    .application-meta {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
        font-size: 12px;
        color: #6b7280;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn-approve {
        background-color: #10b981;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-approve:hover {
        background-color: #059669;
        transform: translateY(-1px);
    }

    .btn-reject {
        background-color: #ef4444;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-reject:hover {
        background-color: #dc2626;
        transform: translateY(-1px);
    }

    .empty-state {
        text-align: center;
        padding: 80px 40px;
        color: #6b7280;
    }

    .empty-state i {
        font-size: 64px;
        margin-bottom: 16px;
        display: block;
        color: #d1d5db;
    }

    .empty-state h4 {
        font-size: 20px;
        font-weight: 500;
        margin-bottom: 8px;
        color: #374151;
    }

    .alert-custom {
        padding: 16px 20px;
        border-radius: 8px;
        border: none;
        margin-bottom: 24px;
    }

    .alert-success {
        background-color: #d1fae5;
        color: #065f46;
    }

    .alert-danger {
        background-color: #fee2e2;
        color: #dc2626;
    }
</style>

<div style="max-width: 1200px; margin: 0 auto; padding: 24px 0;">
    <div class="page-header">
        <h1><i class="bi bi-check-circle" style="margin-right: 12px;"></i>Pengajuan Kos</h1>
        <p>Kelola aplikasi kos yang menunggu persetujuan</p>
    </div>

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="alert-custom alert-success">
            <i class="bi bi-check-circle" style="margin-right: 8px;"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="applications-card">
        <div class="card-header-custom">
            <h5><i class="bi bi-list-check" style="margin-right: 8px;"></i>Daftar Pengajuan Pending</h5>
            <div class="stats-bar">
                <div class="stat-item">
                    <i class="bi bi-building"></i>
                    <span>Total Pengajuan: <span class="stat-number">{{ $kosList->count() }}</span></span>
                </div>
                <div class="stat-item">
                    <i class="bi bi-clock"></i>
                    <span>Menunggu Review</span>
                </div>
            </div>
        </div>

        <div style="padding: 0;">
            @if($kosList->isEmpty())
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <h4>Tidak ada pengajuan kos</h4>
                    <p>Semua aplikasi kos telah diproses atau belum ada pengajuan baru.</p>
                </div>
            @else
                @foreach($kosList as $kos)
                    <div class="application-item">
                        <div class="application-header">
                            <div class="kos-info">
                                <div class="kos-name">{{ $kos->nama }}</div>
                                <div class="kos-owner">
                                    <i class="bi bi-person" style="margin-right: 4px;"></i>
                                    Pemilik: {{ $kos->pemilik->name ?? 'N/A' }}
                                </div>
                                <div class="kos-address">
                                    <i class="bi bi-geo-alt" style="margin-right: 4px;"></i>
                                    {{ $kos->alamat }}
                                </div>
                                @if($kos->deskripsi)
                                    <div class="kos-description">
                                        {{ Str::limit($kos->deskripsi, 150) }}
                                    </div>
                                @endif
                            </div>

                            <div class="action-buttons">
                                <form action="{{ route('admin.kos.approve', $kos->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn-approve" onclick="return confirm('Apakah Anda yakin ingin menyetujui pengajuan kos ini?')">
                                        <i class="bi bi-check"></i>
                                        Setujui
                                    </button>
                                </form>

                                <form action="{{ route('admin.kos.reject', $kos->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn-reject" onclick="return confirm('Apakah Anda yakin ingin menolak pengajuan kos ini?')">
                                        <i class="bi bi-x"></i>
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="application-meta">
                            <div class="meta-item">
                                <i class="bi bi-calendar"></i>
                                <span>Diajukan: {{ $kos->created_at->format('d M Y H:i') }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="bi bi-tag"></i>
                                <span>Status: <span style="color: #f59e0b; font-weight: 500;">Pending</span></span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

@endsection
