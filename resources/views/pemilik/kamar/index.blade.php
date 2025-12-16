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

    .alert-danger {
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .alert-info {
        background-color: #dbeafe;
        color: #1e40af;
        border: 1px solid #93c5fd;
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

    .badge {
        padding: 4px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-success {
        background-color: #dcfce7;
        color: #166534;
    }

    .badge-danger {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .btn-group-actions {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
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
    }

    .btn-action-primary {
        background-color: #4a6fa5;
        color: white;
    }

    .btn-action-primary:hover {
        background-color: #3a5a8f;
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

    .penghuni-info {
        font-size: 13px;
    }

    .penghuni-info .name {
        font-weight: 600;
        color: #1f1f1f;
    }

    .penghuni-info .period {
        color: #6c757d;
        font-size: 12px;
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

    .alert-danger ul {
        margin: 0;
        padding-left: 20px;
    }

    .alert-danger li {
        margin-bottom: 4px;
    }
</style>

<div class="page-header">
    <h2>Daftar Kamar - {{ $kos->nama }}</h2>
    <div style="display: flex; gap: 12px;">
        <a href="{{ route('pemilik.kamar.create', $kos->id) }}" class="btn-tambah">
            <i class="bi bi-plus-lg"></i> Tambah Kamar
        </a>
        <a href="{{ route('pemilik.room_types.index', $kos->id) }}" class="btn-tambah" style="background-color: #6b7280;">
            <i class="bi bi-list"></i> Tipe Kamar
        </a>
    </div>
</div>

@if (session('success'))
    <div class="alert-custom alert-success">
        <i class="bi bi-check-circle" style="margin-right: 8px;"></i>
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert-custom alert-danger">
        <i class="bi bi-exclamation-triangle" style="margin-right: 8px;"></i>
        <strong>Terjadi kesalahan:</strong>
        <ul style="margin: 8px 0 0 0; padding-left: 20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if($kamars->isEmpty())
    <div class="empty-state">
        <i class="bi bi-door-closed"></i>
        <p>Belum ada kamar yang ditambahkan untuk kos ini.</p>
        <a href="{{ route('pemilik.kamar.create', $kos->id) }}" class="btn-tambah">
            <i class="bi bi-plus-lg"></i> Tambah Kamar Pertama
        </a>
    </div>
@else
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nomor Kamar</th>
                    <th>Kelas</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Penghuni</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kamars as $index => $kamar)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $kamar->nomor }}</strong></td>
                    <td>{{ ucfirst($kamar->kelas) }}</td>
                    <td>Rp{{ number_format($kamar->harga, 0, ',', '.') }}</td>
                    <td>
                        @if($kamar->status == 'kosong')
                            <span class="badge badge-success">Kosong</span>
                        @else
                            <span class="badge badge-danger">Terisi</span>
                        @endif
                    </td>
                    <td>
                        @if($kamar->penghuni)
                            <div class="penghuni-info">
                                <div class="name">{{ $kamar->penghuni->name }}</div>
                                <div class="period">
                                    {{ \Carbon\Carbon::parse($kamar->penghuni->tanggal_masuk)->format('d M Y') }} - {{ \Carbon\Carbon::parse($kamar->penghuni->tanggal_keluar)->format('d M Y') }}
                                </div>
                            </div>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group-actions">
                            <a href="{{ route('pemilik.kamar.edit', [$kos->id, $kamar->id]) }}" class="btn-action btn-action-secondary">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <a href="{{ route('pemilik.kamar.edit.photos', [$kos->id, $kamar->id]) }}" class="btn-action btn-action-primary">
                                <i class="bi bi-image"></i> Foto
                            </a>
                            <a href="{{ route('pemilik.kamar.edit.facilities', [$kos->id, $kamar->id]) }}" class="btn-action btn-action-secondary">
                                <i class="bi bi-tools"></i> Fasilitas
                            </a>
                            <form action="{{ route('pemilik.kamar.destroy', [$kos->id, $kamar->id]) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Hapus kamar ini?')" class="btn-action btn-action-danger">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
