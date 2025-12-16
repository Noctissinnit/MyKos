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
    
    .table-container {
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
    
    .badge-kosong {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .badge-terisi {
        background-color: #fee2e2;
        color: #7f1d1d;
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
        box-shadow: 0 4px 12px rgba(74, 111, 165, 0.3);
    }
    
    .tenant-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    
    .tenant-info strong {
        color: #1f2937;
        font-weight: 600;
    }
    
    .tenant-info small {
        color: #6b7280;
        font-size: 12px;
    }
</style>

<div class="container" style="max-width: 1400px; padding: 24px 0;">
    <div class="page-header">
        <h2>Semua Kamar Saya</h2>
    </div>

    @if($kamars->isEmpty())
        <div class="empty-state">
            <i class="bi bi-door-closed"></i>
            <p>Belum ada kamar yang terdaftar</p>
        </div>
    @else
        <div class="table-container">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th>Kos</th>
                        <th>Nomor</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Penghuni</th>
                        <th style="width: 10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kamars as $i => $k)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td><strong>{{ $k->kos->nama ?? '-' }}</strong></td>
                            <td>{{ $k->nomor }}</td>
                            <td>{{ $k->nama_kamar ?? '-' }}</td>
                            <td>{{ ucfirst($k->kelas) }}</td>
                            <td><strong>Rp{{ number_format($k->harga,0,',','.') }}</strong></td>
                            <td>
                                @if($k->status == 'kosong')
                                    <span class="badge badge-kosong"><i class="bi bi-check-circle" style="display: inline;"></i> Kosong</span>
                                @else
                                    <span class="badge badge-terisi"><i class="bi bi-x-circle" style="display: inline;"></i> Terisi</span>
                                @endif
                            </td>
                            <td>
                                @if($k->penghuni)
                                    <div class="tenant-info">
                                        <strong>{{ $k->penghuni->name }}</strong>
                                        <small>
                                            {{ \Carbon\Carbon::parse($k->penghuni->tanggal_masuk)->format('d M Y') }} - {{ \Carbon\Carbon::parse($k->penghuni->tanggal_keluar)->format('d M Y') }}
                                        </small>
                                    </div>
                                @else
                                    <span style="color: #9ca3af;">-</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('pemilik.kamar.edit', [$k->kos_id, $k->id]) }}" class="btn-action">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
