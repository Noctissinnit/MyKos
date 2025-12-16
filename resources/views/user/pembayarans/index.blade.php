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
    
    .badge-success {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .badge-warning {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .badge-danger {
        background-color: #fee2e2;
        color: #dc2626;
    }
    
    .btn-secondary {
        background-color: #6b7280;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .btn-secondary:hover {
        background-color: #4b5563;
        color: white;
        transform: translateY(-2px);
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #9ca3af;
    }
    
    .empty-state i {
        font-size: 64px;
        margin-bottom: 16px;
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
    
    .alert-info {
        background-color: #dbeafe;
        color: #1e40af;
    }
</style>

<div style="max-width: 1200px; margin: 0 auto; padding: 24px 0;">
    <div class="page-header">
        <h1><i class="bi bi-receipt" style="margin-right: 12px;"></i>Riwayat Pembayaran</h1>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle" style="margin-right: 8px;"></i>{{ session('success') }}
        </div>
    @endif

    {{-- Bila kosong --}}
    @if($payments->isEmpty())
        <div class="empty-state">
            <i class="bi bi-receipt"></i>
            <div style="font-size: 18px; font-weight: 500; margin-bottom: 8px;">Belum ada pembayaran</div>
            <div>Riwayat pembayaran Anda akan muncul di sini</div>
        </div>
    @else
        {{-- Table Container --}}
        <div class="card-section">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kamar</th>
                            <th>Jumlah</th>
                            <th>Metode</th>
                            <th>Tanggal Bayar</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $i => $p)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <div style="display: flex; flex-direction: column; gap: 2px;">
                                        <strong>Kamar {{ $p->penghuni->kamar->nomor ?? '-' }}</strong>
                                        <small style="color: #9ca3af;">{{ $p->penghuni->kamar->kos->nama ?? '-' }}</small>
                                    </div>
                                </td>
                                <td><strong>Rp {{ number_format($p->jumlah, 0, ',', '.') }}</strong></td>
                                <td>{{ ucfirst($p->metode) }}</td>
                                <td>{{ \Carbon\Carbon::parse($p->tanggal_bayar)->format('d M Y') }}</td>
                                <td>
                                    @php
                                        $status = strtolower($p->status);
                                    @endphp
                                    @if($status === 'success')
                                        <span class="badge badge-success">
                                            <i class="bi bi-check-circle"></i> Sukses
                                        </span>
                                    @elseif($status === 'pending')
                                        <span class="badge badge-warning">
                                            <i class="bi bi-hourglass-split"></i> Pending
                                        </span>
                                    @else
                                        <span class="badge badge-danger">
                                            <i class="bi bi-x-circle"></i> Gagal
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <a href="{{ route('user.dashboard') }}" class="btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>

</div>

@endsection
