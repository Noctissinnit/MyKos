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
        font-size: 28px;
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

    .kos-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 24px;
        margin-top: 24px;
    }

    .kos-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .kos-card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
        transform: translateY(-4px);
    }

    .kos-image {
        width: 100%;
        height: 180px;
        background: linear-gradient(135deg, #e0e7ff 0%, #f3f4f6 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9ca3af;
    }

    .kos-image i {
        font-size: 48px;
    }

    .kos-content {
        padding: 16px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .kos-title {
        font-size: 16px;
        font-weight: 700;
        color: #1f1f1f;
        margin-bottom: 4px;
    }

    .kos-address {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 12px;
    }

    .kos-info {
        font-size: 12px;
        color: #9ca3af;
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid #e5e7eb;
    }

    .kos-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn-action {
        flex: 1;
        min-width: 70px;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
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

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }

        .kos-container {
            grid-template-columns: 1fr;
        }
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
    <h2>Daftar Kos Anda</h2>
    <a href="{{ route('pemilik.kos.create') }}" class="btn-tambah">
        <i class="bi bi-plus-lg"></i> Tambah Kos
    </a>
</div>

@if (session('success'))
    <div class="alert-custom alert-success">
        <i class="bi bi-check-circle" style="margin-right: 8px;"></i>
        {{ session('success') }}
    </div>
@endif

@if($kosList->isEmpty())
    <div class="empty-state">
        <i class="bi bi-building"></i>
        <p>Belum ada data kos yang ditambahkan.</p>
        <a href="{{ route('pemilik.kos.create') }}" class="btn-tambah">
            <i class="bi bi-plus-lg"></i> Tambah Kos Pertama
        </a>
    </div>
@else
    <div class="kos-container">
        @foreach($kosList as $kos)
        <div class="kos-card">
            <div class="kos-image">
                <i class="bi bi-building"></i>
            </div>
            <div class="kos-content">
                <h3 class="kos-title">{{ $kos->nama }}</h3>
                <p class="kos-address">
                    <i class="bi bi-geo-alt"></i> {{ $kos->alamat }}
                </p>
                <div class="kos-info">
                    <i class="bi bi-door-closed"></i> {{ $kos->kamars->count() }} Kamar
                </div>
                <div class="kos-actions">
                    <a href="{{ route('pemilik.kamar.index', $kos->id) }}" class="btn-action btn-action-primary">
                        <i class="bi bi-door-closed"></i> Kamar
                    </a>
                    <a href="{{ route('pemilik.kos.edit', $kos->id) }}" class="btn-action btn-action-secondary">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <form action="{{ route('pemilik.kos.destroy', $kos->id) }}" method="POST" class="flex-grow-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin hapus kos ini?')" class="btn-action btn-action-danger w-100">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

@endsection
