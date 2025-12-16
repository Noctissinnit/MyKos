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
    
    .page-header p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }
    
    .info-card {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
        border: 1px solid #93c5fd;
    }
    
    .info-card h5 {
        margin: 0 0 16px 0;
        color: #1e40af;
        font-size: 16px;
        font-weight: 600;
    }
    
    .info-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    
    .info-item p {
        margin: 0 0 8px 0;
        color: #1e40af;
        font-size: 14px;
    }
    
    .money-box {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-radius: 12px;
        padding: 20px;
        color: white;
        text-align: center;
    }
    
    .money-box .label {
        font-size: 12px;
        opacity: 0.9;
        margin-bottom: 4px;
    }
    
    .money-box .amount {
        font-size: 24px;
        font-weight: 700;
        margin: 0;
    }
    
    .card-section {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 24px;
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
    
    .file-input-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
    }
    
    .file-input {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    
    .file-input-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        background-color: #f9fafb;
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
    }
    
    .file-input-label:hover {
        border-color: #4a6fa5;
        background-color: #f3f4f6;
    }
    
    .file-input-label i {
        font-size: 32px;
        color: #6b7280;
        margin-bottom: 8px;
    }
    
    .file-input-label span {
        font-size: 14px;
        color: #6b7280;
    }
    
    .file-info {
        font-size: 12px;
        color: #6b7280;
        margin-top: 8px;
    }
    
    .note-box {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 24px;
        border: 1px solid #f59e0b;
    }
    
    .note-box i {
        color: #92400e;
        margin-right: 8px;
    }
    
    .note-box strong {
        color: #92400e;
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
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-right: 12px;
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
        padding: 12px 24px;
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
</style>

<div style="max-width: 1000px; margin: 0 auto; padding: 24px 0;">
    <div class="page-header">
        <div>
            <h1><i class="bi bi-upload" style="margin-right: 12px;"></i>Unggah Bukti Pembayaran</h1>
            <p>Lengkapi pembayaran untuk melanjutkan proses sewa kamar</p>
        </div>
    </div>

    {{-- Info Card --}}
    <div class="info-card">
        <h5><i class="bi bi-info-circle" style="margin-right: 8px;"></i>Detail Permintaan Sewa</h5>
        <div class="info-row">
            <div class="info-item">
                <p><strong>Kos:</strong> {{ $rentalRequest->kos->nama ?? '-' }}</p>
                <p><strong>Periode:</strong> {{ \Carbon\Carbon::parse($rentalRequest->start_date)->format('d M Y') }} → {{ \Carbon\Carbon::parse($rentalRequest->end_date)->format('d M Y') }}</p>
            </div>
            <div class="money-box">
                <div class="label">Jumlah Pembayaran</div>
                <div class="amount">Rp {{ number_format($jumlah, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    {{-- Error Messages --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle" style="margin-right: 8px;"></i>
            <strong>Mohon perbaiki kesalahan berikut:</strong>
            <ul>
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Card --}}
    <div class="card-section">
        <div class="card-body">
            <form action="{{ route('user.pembayarans.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="rental_request_id" value="{{ $rentalRequest->id }}">
                <input type="hidden" name="jumlah" value="{{ $jumlah }}">

                <div class="form-group">
                    <label class="form-label">Metode Pembayaran</label>
                    <select name="metode" class="form-control" required>
                        <option value="">Pilih metode pembayaran</option>
                        <option value="transfer" {{ old('metode') === 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                        <option value="cash" {{ old('metode') === 'cash' ? 'selected' : '' }}>Tunai</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Bukti Pembayaran <span style="color: #ef4444;">*</span></label>
                    <div class="file-input-wrapper">
                        <input type="file" name="bukti" class="file-input" accept="image/*,application/pdf" required id="bukti-input">
                        <label for="bukti-input" class="file-input-label">
                            <i class="bi bi-cloud-upload"></i>
                            <span>Klik untuk memilih file bukti pembayaran</span>
                        </label>
                    </div>
                    <div class="file-info">
                        Format yang didukung: JPG, PNG, atau PDF • Ukuran maksimal: 2MB
                    </div>
                </div>

                <div class="note-box">
                    <i class="bi bi-info-circle"></i>
                    <strong>Catatan:</strong> Pemilik kos akan memverifikasi pembayaran dalam 1-2 hari kerja setelah Anda mengunggah bukti.
                </div>

                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <button type="submit" class="btn-primary-custom">
                        <i class="bi bi-upload"></i> Unggah Bukti Pembayaran
                    </button>

                    <a href="{{ route('user.rental_requests.index') }}" class="btn-secondary">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
document.getElementById('bukti-input').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const label = document.querySelector('.file-input-label');
        label.innerHTML = `
            <i class="bi bi-file-earmark-check"></i>
            <span>${file.name}</span>
        `;
        label.style.borderColor = '#10b981';
        label.style.backgroundColor = '#f0fdf4';
    }
});
</script>

@endsection
    