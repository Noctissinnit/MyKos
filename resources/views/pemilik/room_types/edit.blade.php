@extends('layouts.ownerkos')

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

    .form-card {
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
        margin: 0 0 16px 0;
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
    }

    .form-content {
        padding: 24px;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-group label {
        display: block;
        font-weight: 500;
        color: #374151;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-control-custom {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        font-family: inherit;
        transition: all 0.2s;
        background: white;
    }

    .form-control-custom:focus {
        border-color: #4a6fa5;
        box-shadow: 0 0 0 3px rgba(74, 111, 165, 0.1);
        outline: none;
    }

    .form-textarea {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        font-family: inherit;
        min-height: 100px;
        resize: vertical;
        transition: all 0.2s;
        background: white;
    }

    .form-textarea:focus {
        border-color: #4a6fa5;
        box-shadow: 0 0 0 3px rgba(74, 111, 165, 0.1);
        outline: none;
    }

    .button-group {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid #e5e7eb;
    }

    .btn-primary-custom {
        background-color: #4a6fa5;
        color: white;
        border: none;
        padding: 12px 24px;
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
        background-color: #3a5a8f;
        transform: translateY(-1px);
    }

    .btn-secondary-custom {
        background-color: #6b7280;
        color: white;
        border: none;
        padding: 12px 24px;
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

    .btn-secondary-custom:hover {
        background-color: #4b5563;
        transform: translateY(-1px);
    }

    .alert-custom {
        padding: 16px 20px;
        border-radius: 8px;
        border: none;
        margin-bottom: 24px;
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

<div style="max-width: 800px; margin: 0 auto; padding: 24px 0;">
    <div class="page-header">
        <div>
            <h1><i class="bi bi-pencil-square" style="margin-right: 12px;"></i>Edit Tipe Kamar</h1>
            <p>Kos: <strong>{{ $kos->nama }}</strong> | Tipe: <strong>{{ $roomType->nama }}</strong></p>
        </div>
    </div>

    {{-- Error Messages --}}
    @if($errors->any())
        <div class="alert-custom alert-danger">
            <i class="bi bi-exclamation-triangle" style="margin-right: 8px;"></i>
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">
        <div class="card-header-custom">
            <h5><i class="bi bi-info-circle" style="margin-right: 8px;"></i>Informasi Tipe Kamar</h5>
        </div>

        <form action="{{ route('pemilik.room_types.update', $roomType) }}" method="POST" class="form-content">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nama">Nama Tipe Kamar</label>
                <input type="text" name="nama" id="nama" class="form-control-custom"
                       value="{{ old('nama', $roomType->nama) }}" placeholder="Contoh: Standard, Deluxe, Premium" required>
            </div>

            <div class="form-group">
                <label for="kapasitas">Kapasitas (orang)</label>
                <input type="number" name="kapasitas" id="kapasitas" class="form-control-custom"
                       value="{{ old('kapasitas', $roomType->kapasitas) }}" min="1" placeholder="Jumlah orang per kamar" required>
            </div>

            <div class="form-group">
                <label for="harga">Harga per Bulan (Rp)</label>
                <input type="number" name="harga" id="harga" class="form-control-custom"
                       value="{{ old('harga', $roomType->harga) }}" min="0" placeholder="0" required>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-textarea"
                          placeholder="Deskripsikan fasilitas dan keunggulan tipe kamar ini...">{{ old('deskripsi', $roomType->deskripsi) }}</textarea>
            </div>

            <div class="button-group">
                <a href="{{ route('pemilik.room_types.index', $kos->id) }}" class="btn-secondary-custom">
                    <i class="bi bi-x-circle"></i>
                    Batal
                </a>
                <button type="submit" class="btn-primary-custom">
                    <i class="bi bi-check-circle"></i>
                    Perbarui Tipe Kamar
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
