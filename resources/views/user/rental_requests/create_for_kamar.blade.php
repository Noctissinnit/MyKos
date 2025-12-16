@extends('layouts.app')

@section('content')
<style>
    .page-header {
        text-align: center;
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
    
    .card-section {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 24px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .card-body {
        padding: 32px;
    }
    
    .info-card {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
        border: 1px solid #93c5fd;
        text-align: center;
    }
    
    .info-card h5 {
        margin: 0 0 8px 0;
        color: #1e40af;
        font-size: 16px;
        font-weight: 600;
    }
    
    .info-card p {
        margin: 0;
        color: #1e40af;
        font-size: 14px;
    }
    
    .form-group {
        margin-bottom: 24px;
    }
    
    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }
    
    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.2s;
        background-color: white;
    }
    
    .form-control:focus {
        border-color: #4a6fa5;
        box-shadow: 0 0 0 3px rgba(74, 111, 165, 0.1);
        outline: none;
    }
    
    .form-control:invalid {
        border-color: #ef4444;
    }
    
    .form-control[type="date"] {
        cursor: pointer;
    }
    
    .textarea-wrapper {
        position: relative;
    }
    
    .textarea-wrapper textarea {
        resize: vertical;
        min-height: 80px;
    }
    
    .btn-container {
        display: flex;
        gap: 12px;
        justify-content: space-between;
        margin-top: 32px;
    }
    
    .btn-secondary-custom {
        background-color: white;
        color: #6b7280;
        border: 1px solid #d1d5db;
        padding: 14px 24px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        flex: 1;
    }
    
    .btn-secondary-custom:hover {
        background-color: #f9fafb;
        color: #374151;
        border-color: #9ca3af;
    }
    
    .btn-primary-custom {
        background-color: #4a6fa5;
        color: white;
        border: none;
        padding: 14px 24px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.2s;
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    .btn-primary-custom:hover {
        background-color: #3a5a8f;
        color: white;
        transform: translateY(-2px);
    }
    
    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        border: none;
    }
    
    .alert-danger {
        background-color: #fef2f2;
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

<div style="max-width: 1200px; margin: 0 auto; padding: 24px 0;">
    <div class="page-header">
        <h1><i class="bi bi-house-door" style="margin-right: 12px;"></i>Pesan Kamar {{ $kamar->nomor }}</h1>
        <p>Kos: <strong>{{ $kos->nama }}</strong> • Lengkapi permintaan sewa kamar</p>
    </div>

    {{-- Info Card --}}
    <div class="info-card">
        <h5><i class="bi bi-info-circle" style="margin-right: 8px;"></i>Informasi Kamar</h5>
        <p>Kamar: <strong>{{ $kamar->nomor }}</strong> • Kos: <strong>{{ $kos->nama }}</strong> • Tipe: <strong>{{ $kamar->roomType->nama }}</strong></p>
    </div>

    {{-- Error Messages --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle" style="margin-right: 8px;"></i>
            <strong>Mohon perbaiki kesalahan berikut:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card-section">
        <div class="card-body">
            <form action="{{ route('user.rental_requests.store') }}" method="POST">
                @csrf
                <input type="hidden" name="kos_id" value="{{ $kos->id }}">
                <input type="hidden" name="kamar_id" value="{{ $kamar->id }}">

                <div class="form-group">
                    <label class="form-label">Tanggal Mulai Sewa</label>
                    <input type="date" name="start_date" class="form-control" 
                           value="{{ old('start_date') }}" 
                           min="{{ now()->format('Y-m-d') }}" required>
                    <small style="color: #6b7280; font-size: 12px; margin-top: 4px; display: block;">
                        Pilih tanggal mulai sewa kamar
                    </small>
                </div>

                <div class="form-group">
                    <label class="form-label">Tanggal Selesai Sewa</label>
                    <input type="date" name="end_date" class="form-control" 
                           value="{{ old('end_date') }}" 
                           min="{{ now()->addDay()->format('Y-m-d') }}" required>
                    <small style="color: #6b7280; font-size: 12px; margin-top: 4px; display: block;">
                        Pilih tanggal selesai sewa kamar
                    </small>
                </div>

                <div class="form-group">
                    <label class="form-label">Catatan Tambahan (Opsional)</label>
                    <div class="textarea-wrapper">
                        <textarea name="message" class="form-control" rows="4" 
                                  placeholder="Tulis pesan atau catatan khusus untuk pemilik kos...">{{ old('message') }}</textarea>
                    </div>
                    <small style="color: #6b7280; font-size: 12px; margin-top: 4px; display: block;">
                        Berikan informasi tambahan yang mungkin diperlukan pemilik kos
                    </small>
                </div>

                <div class="btn-container">
                    <a href="{{ url()->previous() }}" class="btn-secondary-custom">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn-primary-custom">
                        <i class="bi bi-send"></i> Kirim Permintaan Sewa
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection
