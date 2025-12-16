@extends('layouts.app')

@section('content')
<style>
    .page-header {
        margin-bottom: 32px;
        padding-bottom: 24px;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .page-header h1 {
        margin: 0;
        font-size: 28px;
        font-weight: 600;
        color: #1f2937;
    }
    
    .card-section {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 24px;
    }
    
    .card-body {
        padding: 24px;
    }
    
    .table {
        margin-bottom: 0;
        font-size: 14px;
    }
    
    .table thead {
        background-color: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .table thead th {
        padding: 12px 16px;
        font-weight: 600;
        color: #374151;
        border: none;
    }
    
    .table tbody td {
        padding: 12px 16px;
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
    
    .proof-link {
        color: #4a6fa5;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    
    .proof-link:hover {
        color: #3a5a8f;
        text-decoration: underline;
    }
    
    .proof-info {
        font-size: 13px;
        margin-bottom: 4px;
        padding: 4px 8px;
        background-color: #f9fafb;
        border-radius: 4px;
    }
    
    .empty-message {
        text-align: center;
        color: #9ca3af;
        padding: 40px 20px;
    }
    
    .empty-message i {
        font-size: 48px;
        margin-bottom: 12px;
        display: block;
    }
    
    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        border: none;
    }
    
    .alert-success {
        background-color: #d1fae5;
        color: #065f46;
    }
</style>

<div style="max-width: 1200px; margin: 0 auto; padding: 24px 0;">
    <div class="page-header">
        <h1><i class="bi bi-clipboard-check" style="margin-right: 12px;"></i>Permintaan Sewa Saya</h1>
    </div>

    {{-- Flash success --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle" style="margin-right: 8px;"></i>{{ session('success') }}
        </div>
    @endif

    <div class="card-section">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Kos</th>
                        <th>Tipe Kamar</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th>Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $r)
                        <tr>
                            <td>
                                <div style="display: flex; flex-direction: column; gap: 2px;">
                                    <strong>{{ $r->kos->nama ?? '-' }}</strong>
                                    <small style="color: #9ca3af;">{{ $r->kos->alamat ?? '-' }}</small>
                                </div>
                            </td>
                            <td>{{ $r->roomType->nama ?? '-' }}</td>
                            <td style="font-size: 12px; color: #6b7280;">
                                {{ \Carbon\Carbon::parse($r->start_date)->format('d M Y') }}<br>
                                s/d {{ \Carbon\Carbon::parse($r->end_date)->format('d M Y') }}
                            </td>
                            <td>
                                @php $status = strtolower($r->status); @endphp
                                @if($status === 'pending')
                                    <span class="badge badge-warning">
                                        <i class="bi bi-hourglass-split"></i> Pending
                                    </span>
                                @elseif($status === 'approved')
                                    <span class="badge badge-success">
                                        <i class="bi bi-check-circle"></i> Disetujui
                                    </span>
                                @else
                                    <span class="badge badge-danger">
                                        <i class="bi bi-x-circle"></i> Ditolak
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($r->payments->isEmpty())
                                    {{-- Belum ada pembayaran --}}
                                    <a href="{{ route('user.rental_requests.upload_proof', $r) }}" class="btn-action">
                                        <i class="bi bi-upload"></i> Unggah Bukti
                                    </a>
                                @else
                                    {{-- Menampilkan semua pembayaran --}}
                                    <div style="display: flex; flex-direction: column; gap: 6px;">
                                        @foreach($r->payments as $p)
                                            <div class="proof-info">
                                                <strong>{{ ucfirst($p->status) }}</strong>
                                                @if($p->verified)
                                                    <span style="color: #10b981;">(Terverifikasi)</span>
                                                @endif
                                                — Rp {{ number_format($p->jumlah, 0, ',', '.') }}
                                            </div>
                                            @if($p->bukti)
                                                <a href="{{ asset('storage/' . $p->bukti) }}" target="_blank" class="proof-link">
                                                    <i class="bi bi-eye"></i> Lihat Bukti
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-message">
                                <i class="bi bi-inbox"></i>
                                <div style="font-size: 16px; font-weight: 500; margin-bottom: 4px;">Belum ada permintaan sewa</div>
                                <div>Permintaan sewa Anda akan muncul di sini</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
