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
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .card-body {
        padding: 32px;
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
    
    .form-check {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 24px;
    }
    
    .form-check-input {
        width: 16px;
        height: 16px;
        border: 1px solid #d1d5db;
        border-radius: 4px;
        background-color: white;
        cursor: pointer;
    }
    
    .form-check-input:checked {
        background-color: #4a6fa5;
        border-color: #4a6fa5;
    }
    
    .form-check-label {
        font-size: 14px;
        color: #374151;
        cursor: pointer;
        margin: 0;
    }
    
    .btn-primary-custom {
        background-color: #4a6fa5;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }
    
    .btn-primary-custom:hover {
        background-color: #3a5a8f;
        color: white;
        transform: translateY(-2px);
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
    
    .info-card {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
        border: 1px solid #93c5fd;
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
</style>

<div style="max-width: 1200px; margin: 0 auto; padding: 24px 0;">
    <div class="page-header">
        <h1><i class="bi bi-credit-card" style="margin-right: 12px;"></i>Bayar untuk Kamar {{ $penghuni->kamar->nomor ?? '' }}</h1>
    </div>

    {{-- Info Card --}}
    <div class="info-card">
        <h5><i class="bi bi-info-circle" style="margin-right: 8px;"></i>Informasi Pembayaran</h5>
        <p>Kamar: <strong>{{ $penghuni->kamar->nomor ?? '-' }}</strong> • Kos: <strong>{{ $penghuni->kamar->kos->nama ?? '-' }}</strong></p>
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
            <form action="{{ route('user.pembayarans.store') }}" method="POST">
                @csrf
                <input type="hidden" name="penghuni_id" value="{{ $penghuni->id }}">

                <div class="form-group">
                    <label class="form-label">Jumlah Pembayaran (Rp)</label>
                    <input type="number" name="jumlah" class="form-control" step="0.01" 
                           value="{{ old('jumlah') ?? $penghuni->kamar->harga ?? '' }}" 
                           placeholder="Masukkan jumlah pembayaran" required>
                    <small style="color: #6b7280; font-size: 12px; margin-top: 4px; display: block;">
                        Harga normal: Rp {{ number_format($penghuni->kamar->harga ?? 0, 0, ',', '.') }}/bulan
                    </small>
                </div>

                <div class="form-group">
                    <label class="form-label">Metode Pembayaran</label>
                    <select name="metode" class="form-control" required>
                        <option value="">Pilih metode pembayaran</option>
                        <option value="transfer" {{ old('metode') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                        <option value="cash" {{ old('metode') == 'cash' ? 'selected' : '' }}>Tunai</option>
                    </select>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="pay_now" id="pay_now" value="1" {{ old('pay_now') ? 'checked' : '' }}>
                    <label class="form-check-label" for="pay_now">
                        Bayar sekarang dan tandai sebagai lunas
                    </label>
                </div>

                <button type="submit" class="btn-primary-custom">
                    <i class="bi bi-check-circle"></i> Buat Pembayaran
                </button>
            </form>
        </div>
    </div>

    <div style="text-align: center; margin-top: 20px;">
        <a href="{{ route('user.pembayarans.index') }}" class="btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Riwayat Pembayaran
        </a>
    </div>

</div>

@endsection
