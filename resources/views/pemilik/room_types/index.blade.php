@extends('layouts.ownerkos')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
    }

    .page-header h2 {
        font-size: 24px;
        font-weight: 700;
        color: #1f1f1f;
        margin: 0;
    }

    .header-actions {
        display: flex;
        gap: 12px;
    }

    .btn-tambah {
        background-color: #4a6fa5;
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-tambah:hover {
        background-color: #3a5a8f;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 111, 165, 0.3);
    }

    .btn-secondary {
        background-color: #6b7280;
    }

    .btn-secondary:hover {
        background-color: #4b5563;
    }

    .btn-back {
        background-color: white;
        color: #6c757d;
        border: 1px solid #e5e7eb;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-back:hover {
        background-color: #f9fafb;
        border-color: #d1d5db;
        color: #1f1f1f;
    }

    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .alert-success {
        background-color: #dcfce7;
        color: #166534;
        border: 1px solid #86efac;
    }

    .kos-selector {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .kos-selector label {
        font-weight: 600;
        color: #1f1f1f;
        margin-bottom: 12px;
        display: block;
    }

    .kos-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .kos-btn {
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        border: 2px solid #e5e7eb;
        background-color: white;
        color: #6c757d;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .kos-btn:hover {
        border-color: #4a6fa5;
        color: #4a6fa5;
    }

    .kos-btn.active {
        background-color: #4a6fa5;
        border-color: #4a6fa5;
        color: white;
    }

    .table-container {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .table {
        margin: 0;
        font-size: 14px;
    }

    .table thead {
        background-color: #f3f4f6;
        border-bottom: 2px solid #e5e7eb;
    }

    .table thead th {
        padding: 16px;
        font-weight: 600;
        color: #374151;
        text-align: left;
    }

    .table tbody tr {
        border-bottom: 1px solid #e5e7eb;
        transition: background-color 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: #f9fafb;
    }

    .table tbody td {
        padding: 14px 16px;
        color: #6c757d;
    }

    .btn-action {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        margin-right: 6px;
    }

    .btn-action-secondary {
        background-color: white;
        color: #4a6fa5;
        border: 1px solid #e5e7eb;
    }

    .btn-action-secondary:hover {
        background-color: #f9fafb;
        border-color: #4a6fa5;
    }

    .btn-action-danger {
        background-color: #fee2e2;
        color: #dc2626;
    }

    .btn-action-danger:hover {
        background-color: #fecaca;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state i {
        font-size: 64px;
        color: #d1d5db;
        margin-bottom: 16px;
    }

    .empty-state p {
        color: #6c757d;
        font-size: 16px;
        margin-bottom: 24px;
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
</style>

<div class="page-header">
    <h2>Tipe Kamar - {{ $kos->nama }}</h2>
    <div class="header-actions">
        <a href="{{ route('pemilik.kos.index') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> Kembali ke Kos
        </a>
        <a href="{{ route('pemilik.room_types.create', $kos->id) }}" class="btn-tambah">
            <i class="bi bi-plus-lg"></i> Tambah Tipe Kamar
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert-custom alert-success">
        <i class="bi bi-check-circle" style="margin-right: 8px;"></i>
        {{ session('success') }}
    </div>
@endif

@if(count($kosList) > 1)
<div class="kos-selector">
    <label>Pilih Kos Lain:</label>
    <div class="kos-buttons">
        @foreach($kosList as $k)
            <a href="{{ route('pemilik.room_types.index', $k->id) }}" 
               class="kos-btn @if($k->id === $kos->id) active @endif">
                {{ $k->nama }}
            </a>
        @endforeach
    </div>
</div>
@endif

@if($roomTypes->isEmpty())
    <div class="empty-state">
        <i class="bi bi-list"></i>
        <p>Belum ada tipe kamar untuk kos ini.</p>
        <a href="{{ route('pemilik.room_types.create', $kos->id) }}" class="btn-tambah">
            <i class="bi bi-plus-lg"></i> Tambah Tipe Kamar
        </a>
    </div>
@else
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Tipe</th>
                    <th>Kapasitas</th>
                    <th>Harga (per bulan)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roomTypes as $index => $type)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $type->nama }}</strong></td>
                        <td>{{ $type->kapasitas }} orang</td>
                        <td>Rp {{ number_format($type->harga, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('pemilik.room_types.edit', $type) }}" class="btn-action btn-action-secondary">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('pemilik.room_types.destroy', $type) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus tipe kamar ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-action-danger">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

@endsection
