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
    
    .btn-back {
        background-color: #e5e7eb;
        color: #374151;
        border: none;
        padding: 10px 18px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-back:hover {
        background-color: #d1d5db;
        color: #1f2937;
    }
    
    .alert {
        padding: 14px 16px;
        border-radius: 8px;
        margin-bottom: 24px;
        border: 1px solid;
    }
    
    .alert-success {
        background-color: #d1fae5;
        color: #065f46;
        border-color: #86efac;
    }
    
    .alert-danger {
        background-color: #fee2e2;
        color: #7f1d1d;
        border-color: #fecaca;
    }
    
    .form-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 24px;
    }
    
    .form-card h3 {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 16px;
    }
    
    .form-group {
        margin-bottom: 16px;
    }
    
    .form-group label {
        display: block;
        font-weight: 500;
        color: #374151;
        margin-bottom: 8px;
        font-size: 14px;
    }
    
    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-family: inherit;
        font-size: 14px;
        transition: all 0.2s;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #4a6fa5;
        box-shadow: inset 0 0 0 3px rgba(74, 111, 165, 0.1);
    }
    
    .form-help {
        font-size: 12px;
        color: #6b7280;
        margin-top: 6px;
        display: block;
    }
    
    .btn-submit {
        width: 100%;
        background-color: #4a6fa5;
        color: white;
        border: none;
        padding: 12px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-submit:hover {
        background-color: #3a5a8f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 111, 165, 0.3);
    }
    
    .photo-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
    }
    
    .photo-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.2s;
        position: relative;
    }
    
    .photo-card:hover {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
    }
    
    .photo-image {
        width: 100%;
        height: 180px;
        object-fit: cover;
        display: block;
    }
    
    .photo-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        background-color: #fbbf24;
        color: #92400e;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
    }
    
    .photo-actions {
        padding: 12px;
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    
    .btn-action {
        flex: 1;
        min-width: 90px;
        padding: 8px 12px;
        border: none;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
    }
    
    .btn-action-primary {
        background-color: #10b981;
        color: white;
    }
    
    .btn-action-primary:hover {
        background-color: #059669;
        transform: translateY(-1px);
    }
    
    .btn-action-danger {
        background-color: #ef4444;
        color: white;
    }
    
    .btn-action-danger:hover {
        background-color: #dc2626;
        transform: translateY(-1px);
    }
    
    .empty-photos {
        background: white;
        border-radius: 12px;
        padding: 48px 32px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }
    
    .empty-photos i {
        font-size: 48px;
        color: #d1d5db;
        margin-bottom: 16px;
        display: block;
    }
    
    .empty-photos p {
        color: #6b7280;
        margin-bottom: 0;
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

<div class="container" style="max-width: 1200px; padding: 24px 0;">
    <div class="page-header">
        <h2>Kelola Foto Kamar {{ $kamar->nomor }} - {{ $kos->nama }}</h2>
        <a href="{{ route('pemilik.kamar.index', $kos->id) }}" class="btn-back">
            <i class="bi bi-chevron-left"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert-custom alert-success">
            <i class="bi bi-check-circle" style="margin-right: 8px;"></i> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
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

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px; margin-bottom: 24px;">
        <!-- Upload Form -->
        <div class="form-card">
            <h3><i class="bi bi-cloud-upload" style="margin-right: 8px;"></i>Tambah Foto</h3>
            <form action="{{ route('pemilik.kamar.upload.photo', [$kos->id, $kamar->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="photo">Pilih Foto</label>
                    <input type="file" id="photo" name="photo" class="form-control" accept="image/*" required>
                    <span class="form-help">Format: JPEG, PNG, JPG, GIF • Max 5MB</span>
                </div>
                <button type="submit" class="btn-submit">
                    <i class="bi bi-upload" style="margin-right: 6px;"></i> Upload Foto
                </button>
            </form>
        </div>

        <!-- Photos Gallery -->
        <div class="form-card">
            <h3><i class="bi bi-image" style="margin-right: 8px;"></i>Daftar Foto ({{ count($photos) }})</h3>
            
            @if($photos->isEmpty())
                <div class="empty-photos">
                    <i class="bi bi-image"></i>
                    <p>Belum ada foto untuk kamar ini</p>
                </div>
            @else
                <div class="photo-grid">
                    @foreach($photos as $photo)
                    <div class="photo-card">
                        <img src="{{ asset('storage/' . $photo->photo_path) }}" class="photo-image" alt="Kamar">
                        
                        @if($photo->is_primary)
                            <div class="photo-badge">UTAMA</div>
                        @endif

                        <div class="photo-actions">
                            @if(!$photo->is_primary)
                                <form action="{{ route('pemilik.kamar.set.primary.photo', [$kos->id, $kamar->id, $photo->id]) }}" method="POST" style="flex: 1;">
                                    @csrf
                                    <button type="submit" class="btn-action btn-action-primary" style="width: 100%;">
                                        <i class="bi bi-star"></i> Utama
                                    </button>
                                </form>
                            @endif
                            
                            <form action="{{ route('pemilik.kamar.delete.photo', [$kos->id, $kamar->id, $photo->id]) }}" method="POST" style="flex: 1;" onsubmit="return confirm('Hapus foto ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-action-danger" style="width: 100%;">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
