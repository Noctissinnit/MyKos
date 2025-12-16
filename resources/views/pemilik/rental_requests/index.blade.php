@extends('layouts.ownerkos')

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
    
    .page-header h2 {
        margin: 0;
        font-size: 28px;
        font-weight: 600;
        color: #1f2937;
    }
    
    .status-summary {
        display: flex;
        gap: 16px;
    }
    
    .status-badge {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .status-badge.pending {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .status-badge.approved {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .status-badge.rejected {
        background-color: #fee2e2;
        color: #7f1d1d;
    }
    
    .alert-success {
        background-color: #d1fae5;
        border: 1px solid #86efac;
        color: #065f46;
        padding: 14px 16px;
        border-radius: 8px;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .alert-success .btn-close {
        background: transparent;
        border: none;
        cursor: pointer;
        opacity: 0.6;
        transition: opacity 0.2s;
    }
    
    .alert-success .btn-close:hover {
        opacity: 1;
    }
    
    .empty-state {
        background: white;
        border-radius: 12px;
        padding: 48px 32px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }
    
    .empty-state i {
        font-size: 48px;
        color: #d1d5db;
        margin-bottom: 16px;
        display: block;
    }
    
    .empty-state p {
        color: #6b7280;
        margin-bottom: 0;
        font-size: 16px;
    }
    
    .tabs-container {
        margin-bottom: 24px;
    }
    
    .nav-tabs {
        border-bottom: 2px solid #e5e7eb;
        margin-bottom: 0;
    }
    
    .nav-tabs .nav-link {
        color: #6b7280;
        border: none;
        padding: 14px 18px;
        font-weight: 500;
        transition: all 0.2s;
        border-bottom: 3px solid transparent;
        margin-bottom: -2px;
    }
    
    .nav-tabs .nav-link:hover {
        color: #4a6fa5;
    }
    
    .nav-tabs .nav-link.active {
        color: #4a6fa5;
        background: transparent;
        border-bottom-color: #4a6fa5;
    }
    
    .tab-content {
        margin-top: 0;
    }
    
    .table-responsive {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }
    
    .table {
        margin-bottom: 0;
        font-size: 14px;
    }
    
    .table thead {
        background-color: #f3f4f6;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .table thead th {
        padding: 14px 16px;
        font-weight: 600;
        color: #374151;
        border: none;
    }
    
    .table tbody td {
        padding: 14px 16px;
        border-bottom: 1px solid #f3f4f6;
        color: #374151;
    }
    
    .table tbody tr:hover {
        background-color: #f9fafb;
    }
    
    .table tbody tr:last-child td {
        border-bottom: none;
    }
    
    .badge {
        padding: 6px 10px;
        font-weight: 500;
        font-size: 12px;
        border-radius: 6px;
    }
    
    .badge-pending {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .badge-approved {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .badge-rejected {
        background-color: #fee2e2;
        color: #7f1d1d;
    }
    
    .btn-detail {
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
    
    .btn-detail:hover {
        background-color: #3a5a8f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 111, 165, 0.3);
        color: white;
    }
    
    .rental-user-info {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    
    .rental-user-info strong {
        color: #1f2937;
        font-weight: 600;
    }
    
    .rental-user-info small {
        color: #9ca3af;
        font-size: 12px;
    }
</style>

<div class="container" style="max-width: 1400px; padding: 24px 0;">
    <div class="page-header">
        <h2>Permintaan Sewa</h2>
        <div class="status-summary">
            <div class="status-badge pending">
                <i class="bi bi-hourglass-split"></i>
                <span>{{ $requests->where('status', 'pending')->count() }} Pending</span>
            </div>
            <div class="status-badge approved">
                <i class="bi bi-check-circle"></i>
                <span>{{ $requests->where('status', 'approved')->count() }} Disetujui</span>
            </div>
            <div class="status-badge rejected">
                <i class="bi bi-x-circle"></i>
                <span>{{ $requests->where('status', 'rejected')->count() }} Ditolak</span>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <span><i class="bi bi-check-circle" style="display: inline; margin-right: 8px;"></i> {{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($requests->isEmpty())
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <p>Belum ada permintaan sewa</p>
        </div>
    @else
        <!-- Filter Tabs -->
        <div class="tabs-container">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#pending">
                        Pending <span class="badge badge-pending ms-2">{{ $requests->where('status', 'pending')->count() }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#approved">
                        Disetujui <span class="badge badge-approved ms-2">{{ $requests->where('status', 'approved')->count() }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#rejected">
                        Ditolak <span class="badge badge-rejected ms-2">{{ $requests->where('status', 'rejected')->count() }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#all">
                        Semua <span class="badge" style="background-color: #e5e7eb; color: #6b7280; ms-2">{{ $requests->count() }}</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- Pending Tab -->
            <div id="pending" class="tab-pane fade show active">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Pengguna</th>
                                <th>Kos</th>
                                <th>Tipe/Kamar</th>
                                <th>Periode</th>
                                <th>Tgl Ajuan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                       <tbody>
                            @forelse($requests->where('status', 'pending') as $r)
                            <tr>
                                <td>
                                    <div class="rental-user-info">
                                        <strong>{{ $r->user->name ?? '-' }}</strong>
                                        <small>{{ $r->user->email ?? '-' }}</small>
                                    </div>
                                </td>

                                <td>{{ $r->kos->nama ?? '-' }}</td>

                                <td>
                                    @if($r->kamar)
                                        Kamar {{ $r->kamar->nomor }}
                                    @elseif($r->roomType)
                                        {{ $r->roomType->nama }}
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    {{ $r->start_date->format('d M Y') }}<br>
                                    <small class="text-muted">s/d {{ $r->end_date->format('d M Y') }}</small>
                                </td>

                                <td>{{ $r->created_at->format('d M Y') }}</td>

                                <td><span class="badge badge-pending">Pending</span></td>

                                <td>
                                    <a href="{{ route('pemilik.rental_requests.show', $r) }}" class="btn-detail">
                                        <i class="bi bi-eye"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Tidak ada permintaan pending
                                </td>
                            </tr>
                            @endforelse
                            </tbody>

                    </table>
                </div>
            </div>

            <!-- Approved Tab -->
            <div id="approved" class="tab-pane fade">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Pengguna</th>
                                <th>Kos</th>
                                <th>Kamar</th>
                                <th>Periode</th>
                                <th>Tgl Disetujui</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                      <tbody>
                            @forelse($requests->where('status', 'approved') as $r)
                            <tr>
                                <td>
                                    <div class="rental-user-info">
                                        <strong>{{ $r->user->name ?? '-' }}</strong>
                                        <small>{{ $r->user->email ?? '-' }}</small>
                                    </div>
                                </td>

                                <td>{{ $r->kos->nama ?? '-' }}</td>

                                <td>{{ $r->kamar->nomor ?? '-' }}</td>

                                <td>
                                    {{ $r->start_date->format('d M Y') }}<br>
                                    <small class="text-muted">s/d {{ $r->end_date->format('d M Y') }}</small>
                                </td>

                                <td>{{ $r->updated_at->format('d M Y') }}</td>

                                <td><span class="badge badge-approved">Disetujui</span></td>

                                <td>
                                    <a href="{{ route('pemilik.rental_requests.show', $r) }}" class="btn-detail">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Tidak ada permintaan disetujui
                                </td>
                            </tr>
                            @endforelse
                            </tbody>

                    </table>
                </div>
            </div>

            <!-- Rejected Tab -->
            <div id="rejected" class="tab-pane fade">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Pengguna</th>
                                <th>Kos</th>
                                <th>Tipe</th>
                                <th>Periode</th>
                                <th>Tgl Ditolak</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                       <tbody>
                            @forelse($requests->where('status', 'rejected') as $r)
                            <tr>
                                <td>
                                    <div class="rental-user-info">
                                        <strong>{{ $r->user->name ?? '-' }}</strong>
                                        <small>{{ $r->user->email ?? '-' }}</small>
                                    </div>
                                </td>

                                <td>{{ $r->kos->nama ?? '-' }}</td>

                                <td>
                                    {{ $r->roomType->nama ?? ($r->kamar->nomor ?? '-') }}
                                </td>

                                <td>
                                    {{ $r->start_date->format('d M Y') }}<br>
                                    <small class="text-muted">s/d {{ $r->end_date->format('d M Y') }}</small>
                                </td>

                                <td>{{ $r->updated_at->format('d M Y') }}</td>

                                <td><span class="badge badge-rejected">Ditolak</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    Tidak ada permintaan ditolak
                                </td>
                            </tr>
                            @endforelse
                            </tbody>

                    </table>
                </div>
            </div>

            <!-- All Tab -->
            <div id="all" class="tab-pane fade">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Pengguna</th>
                                <th>Kos</th>
                                <th>Tipe</th>
                                <th>Periode</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                       <tbody>
                            @foreach($requests as $r)
                            <tr>
                                <td>
                                    <div class="rental-user-info">
                                        <strong>{{ $r->user->name ?? '-' }}</strong>
                                        <small>{{ $r->user->email ?? '-' }}</small>
                                    </div>
                                </td>

                                <td>{{ $r->kos->nama ?? '-' }}</td>

                                <td>
                                    {{ $r->kamar->nomor ?? $r->roomType->nama ?? '-' }}
                                </td>

                                <td>
                                    {{ $r->start_date->format('d M Y') }}<br>
                                    <small class="text-muted">s/d {{ $r->end_date->format('d M Y') }}</small>
                                </td>

                                <td>
                                    <span class="badge 
                                        {{ $r->status === 'pending' ? 'badge-pending' : ($r->status === 'approved' ? 'badge-approved' : 'badge-rejected') }}">
                                        {{ ucfirst($r->status) }}
                                    </span>
                                </td>

                                <td>
                                    <a href="{{ route('pemilik.rental_requests.show', $r) }}" class="btn-detail">
                                        <i class="bi bi-eye"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>

                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
