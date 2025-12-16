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
    
    .content-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 32px;
    }
    
    @media (max-width: 1024px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
    }
    
    .info-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }
    
    .info-card h3 {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #f3f4f6;
        align-items: flex-start;
    }
    
    .info-row:last-child {
        border-bottom: none;
    }
    
    .info-label {
        font-weight: 500;
        color: #6b7280;
        font-size: 14px;
    }
    
    .info-value {
        color: #1f2937;
        font-weight: 500;
        text-align: right;
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
    
    .button-group {
        display: flex;
        gap: 12px;
        margin-top: 20px;
    }
    
    .btn-approve {
        flex: 1;
        background-color: #10b981;
        color: white;
        border: none;
        padding: 12px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-approve:hover {
        background-color: #059669;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    
    .btn-reject {
        flex: 1;
        background-color: #ef4444;
        color: white;
        border: none;
        padding: 12px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-reject:hover {
        background-color: #dc2626;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }
    
    .payment-section {
        margin-top: 32px;
    }
    
    .payment-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 16px;
    }
    
    .payment-card h3 {
        font-size: 14px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 16px;
    }
    
    .payment-info {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-bottom: 16px;
    }
    
    .payment-item {
        display: flex;
        flex-direction: column;
    }
    
    .payment-label {
        font-size: 12px;
        color: #6b7280;
        font-weight: 500;
        margin-bottom: 4px;
    }
    
    .payment-value {
        color: #1f2937;
        font-weight: 600;
        font-size: 15px;
    }
    
    .payment-status {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        background-color: #f3f4f6;
        border-radius: 6px;
        width: fit-content;
        font-size: 13px;
        margin-bottom: 12px;
    }
    
    .payment-status.verified {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .payment-status.unverified {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .payment-proof {
        margin: 12px 0;
    }
    
    .payment-proof a {
        color: #4a6fa5;
        text-decoration: none;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }
    
    .payment-proof a:hover {
        color: #3a5a8f;
    }
    
    .btn-verify {
        background-color: #4a6fa5;
        color: white;
        border: none;
        padding: 8px 14px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-verify:hover {
        background-color: #3a5a8f;
        transform: translateY(-1px);
    }
    
    .empty-payment {
        background: white;
        border-radius: 12px;
        padding: 32px 24px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }
    
    .empty-payment i {
        font-size: 36px;
        color: #d1d5db;
        margin-bottom: 12px;
        display: block;
    }
    
    .empty-payment p {
        color: #6b7280;
        margin: 0;
    }
</style>

<div class="container" style="max-width: 1400px; padding: 24px 0;">
    <div class="page-header">
        <h2>Detail Permintaan Sewa</h2>
        <a href="{{ route('pemilik.rental_requests.index') }}" class="btn-back">
            <i class="bi bi-chevron-left"></i> Kembali
        </a>
    </div>

    <!-- Request Information -->
    <div class="content-grid">
        <!-- Pemohon Info -->
        <div class="info-card">
            <h3><i class="bi bi-person-circle" style="margin-right: 8px;"></i>Data Pemohon</h3>
            <div class="info-row">
                <span class="info-label">Nama</span>
                <span class="info-value">{{ $rentalRequest->user->name ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email</span>
                <span class="info-value">{{ $rentalRequest->user->email ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">No. Telepon</span>
                <span class="info-value">{{ $rentalRequest->user->phone ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tipe Kamar</span>
                <span class="info-value">{{ $rentalRequest->roomType->nama ?? '-' }}</span>
            </div>
        </div>

        <!-- Periode & Kos Info -->
        <div class="info-card">
            <h3><i class="bi bi-building" style="margin-right: 8px;"></i>Informasi Sewa</h3>
            <div class="info-row">
                <span class="info-label">Kos</span>
                <span class="info-value">{{ $rentalRequest->kos->nama ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Mulai</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($rentalRequest->start_date)->format('d M Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Berakhir</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($rentalRequest->end_date)->format('d M Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Durasi</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($rentalRequest->start_date)->diffInDays($rentalRequest->end_date) }} hari</span>
            </div>
        </div>
    </div>

    @if($rentalRequest->status === 'pending')
    <!-- Action Form -->
    <div class="form-card">
        <h3><i class="bi bi-check-square" style="margin-right: 8px;"></i>Setujui Permintaan</h3>
        <form action="{{ route('pemilik.rental_requests.approve', $rentalRequest) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="kamar_id">Pilih Kamar</label>
                <select id="kamar_id" name="kamar_id" class="form-control" required>
                    <option value="">-- Pilih Kamar --</option>
                    @foreach($availableKamars as $k)
                        <option value="{{ $k->id }}">{{ $k->nomor }} - {{ $k->nama_kamar ?? $k->kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div class="button-group">
                <button type="submit" class="btn-approve">
                    <i class="bi bi-check-lg"></i> Setujui & Tunjuk Kamar
                </button>
            </div>
        </form>
    </div>

    <div class="form-card">
        <h3><i class="bi bi-x-square" style="margin-right: 8px;"></i>Tolak Permintaan</h3>
        <form action="{{ route('pemilik.rental_requests.reject', $rentalRequest) }}" method="POST">
            @csrf
            <div class="button-group">
                <button type="submit" class="btn-reject">
                    <i class="bi bi-x-lg"></i> Tolak Permintaan
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- Payment Section -->
    <div class="payment-section">
        <h2 style="font-size: 18px; font-weight: 600; color: #1f2937; margin-bottom: 16px;">
            <i class="bi bi-receipt" style="margin-right: 8px;"></i>Bukti Pembayaran
        </h2>
        
        @if($rentalRequest->payments->isEmpty())
            <div class="empty-payment">
                <i class="bi bi-file-earmark-x"></i>
                <p>Belum ada bukti pembayaran diunggah oleh pengguna</p>
            </div>
        @else
            @foreach($rentalRequest->payments as $pay)
                <div class="payment-card">
                    <div class="payment-info">
                        <div class="payment-item">
                            <span class="payment-label">Jumlah</span>
                            <span class="payment-value">Rp{{ number_format($pay->jumlah, 0, ',', '.') }}</span>
                        </div>
                        <div class="payment-item">
                            <span class="payment-label">Metode Pembayaran</span>
                            <span class="payment-value">{{ ucfirst($pay->metode) }}</span>
                        </div>
                    </div>
                    
                    <div style="margin-bottom: 12px;">
                        @if($pay->verified)
                            <div class="payment-status verified">
                                <i class="bi bi-check-circle"></i> Terverifikasi
                            </div>
                        @else
                            <div class="payment-status unverified">
                                <i class="bi bi-hourglass-split"></i> Menunggu Verifikasi
                            </div>
                        @endif
                    </div>

                    @if($pay->bukti)
                        <div class="payment-proof">
                            <a href="{{ asset('storage/' . $pay->bukti) }}" target="_blank">
                                <i class="bi bi-download"></i> Lihat Bukti Pembayaran
                            </a>
                        </div>
                    @endif

                    @if(!$pay->verified)
                        <form action="{{ route('pemilik.pembayarans.verify', $pay) }}" method="POST" style="margin-top: 12px;">
                            @csrf
                            <button type="submit" class="btn-verify">
                                <i class="bi bi-check-lg"></i> Verifikasi Pembayaran
                            </button>
                        </form>
                    @endif
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
