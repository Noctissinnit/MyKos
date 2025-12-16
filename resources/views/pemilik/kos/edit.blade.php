@extends('layouts.ownerkos')

@section('content')
<style>
    .form-container {
        max-width: 600px;
        margin: 0 auto;
    }

    .form-card {
        background: white;
        border-radius: 12px;
        padding: 32px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .form-title {
        font-size: 24px;
        font-weight: 700;
        color: #1f1f1f;
        margin-bottom: 24px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #1f1f1f;
        margin-bottom: 8px;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        font-family: 'Poppins', sans-serif;
        transition: all 0.3s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #4a6fa5;
        box-shadow: 0 0 0 3px rgba(74, 111, 165, 0.1);
    }

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 28px;
    }

    .btn-submit {
        flex: 1;
        padding: 12px 24px;
        background-color: #4a6fa5;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        background-color: #3a5a8f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 111, 165, 0.3);
    }

    .btn-cancel {
        flex: 1;
        padding: 12px 24px;
        background-color: white;
        color: #6c757d;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        background-color: #f9fafb;
        border-color: #d1d5db;
        color: #1f1f1f;
    }

    .alert {
        margin-bottom: 20px;
        padding: 12px 16px;
        border-radius: 8px;
    }

    .alert-danger {
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .error-text {
        font-size: 12px;
        color: #dc2626;
        margin-top: 4px;
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

<div class="form-container">
    <div class="form-card">
        <h2 class="form-title">Edit Kos</h2>

        @if ($errors->any())
            <div class="alert-custom alert-danger">
                <i class="bi bi-exclamation-triangle" style="margin-right: 8px;"></i>
                <strong>Terjadi kesalahan:</strong>
                <ul style="margin: 8px 0 0 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pemilik.kos.update', $kos->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nama">Nama Kos</label>
                <input 
                    type="text" 
                    id="nama" 
                    name="nama" 
                    class="@error('nama') is-invalid @enderror" 
                    value="{{ old('nama', $kos->nama) }}" 
                    required>
                @error('nama')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea 
                    id="alamat" 
                    name="alamat" 
                    class="@error('alamat') is-invalid @enderror" 
                    rows="3" 
                    required>{{ old('alamat', $kos->alamat) }}</textarea>
                @error('alamat')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea 
                    id="deskripsi" 
                    name="deskripsi" 
                    class="@error('deskripsi') is-invalid @enderror" 
                    rows="4">{{ old('deskripsi', $kos->deskripsi) }}</textarea>
                @error('deskripsi')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <i class="bi bi-check-lg me-2"></i> Simpan Perubahan
                </button>
                <a href="{{ route('pemilik.kos.index') }}" class="btn-cancel">
                    <i class="bi bi-x-lg me-2"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
