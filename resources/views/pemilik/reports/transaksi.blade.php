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
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin-bottom: 32px;
    }
    
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }
    
    .stat-label {
        font-size: 13px;
        color: #6b7280;
        font-weight: 500;
        margin-bottom: 8px;
    }
    
    .stat-value {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
    }
    
    .stat-value.success {
        color: #10b981;
    }
    
    .stat-value.warning {
        color: #f59e0b;
    }
    
    .table-container {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 24px;
    }
    
    .table-header {
        padding: 16px;
        background-color: #f3f4f6;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .table-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
    }
    
    .table {
        margin-bottom: 0;
        font-size: 14px;
    }
    
    .table thead {
        background-color: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .table thead th {
        padding: 12px 16px;
        font-weight: 600;
        color: #374151;
        border: none;
    }
    
    .table tbody td {
        padding: 12px 16px;
        border-bottom: 1px solid #f3f4f6;
        color: #374151;
    }
    
    .table tbody tr:hover {
        background-color: #f9fafb;
    }
    
    .table tbody tr:last-child td {
        border-bottom: none;
    }
    
    .badge {
        padding: 6px 10px;
        font-weight: 500;
        font-size: 12px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    
    .badge-verified {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .badge-pending {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .btn-proof {
        background-color: #4a6fa5;
        color: white;
        border: none;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    
    .btn-proof:hover {
        background-color: #3a5a8f;
        color: white;
    }
    
    .empty-state {
        text-align: center;
        padding: 48px 32px;
    }
    
    .empty-state i {
        font-size: 48px;
        color: #d1d5db;
        display: block;
        margin-bottom: 16px;
    }
    
    .empty-state p {
        color: #6b7280;
    }
    
    .filter-form {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: flex-end;
    }
    
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    
    .form-group label {
        font-weight: 500;
        color: #374151;
        font-size: 14px;
    }
    
    .form-control {
        padding: 10px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-family: inherit;
        font-size: 14px;
        background: white;
        min-width: 200px;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #4a6fa5;
        box-shadow: 0 0 0 3px rgba(74, 111, 165, 0.1);
    }
</style>

<div class="container" style="max-width: 1400px; padding: 24px 0;">
    <div class="page-header">
        <h2><i class="bi bi-credit-card" style="margin-right: 12px;"></i>Laporan Transaksi Pembayaran</h2>
        <a href="{{ route('pemilik.dashboard') }}" class="btn-back">
            <i class="bi bi-chevron-left"></i> Kembali
        </a>
    </div>

    <!-- Filter Form -->
    <div class="filter-form">
        <div class="form-group">
            <label for="kos_id"><i class="bi bi-building"></i> Filter berdasarkan Kos:</label>
            <select name="kos_id" id="kos_id" onchange="this.form.submit()" class="form-control">
                <option value="">Semua Kos</option>
                @foreach($kosList as $kos)
                    <option value="{{ $kos->id }}" {{ $selectedKosId == $kos->id ? 'selected' : '' }}>
                        {{ $kos->nama }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <form method="GET" action="{{ route('pemilik.reports.transactions') }}" style="display: none;">
        <input type="hidden" name="kos_id" id="hidden_kos_id">
    </form>

    <!-- Summary Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label"><i class="bi bi-list-check" style="color: #4a6fa5;"></i>Total Transaksi</div>
            <div class="stat-value">{{ $totalTransaksi }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label"><i class="bi bi-currency-exchange" style="color: #10b981;"></i>Total Terkumpul</div>
            <div class="stat-value success">Rp {{ number_format($totalTerkumpul, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label"><i class="bi bi-check-circle" style="color: #10b981;"></i>Terverifikasi</div>
            <div class="stat-value success">{{ $totalTerverifikasi }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label"><i class="bi bi-hourglass-split" style="color: #f59e0b;"></i>Menunggu Verifikasi</div>
            <div class="stat-value warning">{{ $totalMenunggu }}</div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="table-container">
        <div class="table-header">
            <h3><i class="bi bi-list-ul" style="margin-right: 8px;"></i>Daftar Semua Transaksi</h3>
        </div>
        <div style="padding: 16px;">
            @if($pembayarans->isEmpty())
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <p>Belum ada transaksi pembayaran</p>
                </div>
            @else
            <table class="table">
                <thead>
                            <tr>
                                <th>Tanggal Bayar</th>
                                <th>Penghuni</th>
                                <th>Kos</th>
                                <th>Kamar</th>
                                <th>Jumlah</th>
                                <th>Metode</th>
                                <th>Status</th>
                                <th>Bukti</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pembayarans as $bayar)
                            <tr>
                                @php
                                    $user = $bayar->penghuni->user ?? $bayar->rentalRequest->user ?? null;
                                    $kosName = $bayar->penghuni->kamar->kos->nama ?? $bayar->rentalRequest->kos->nama ?? '-';
                                    $kamarNomor = $bayar->penghuni->kamar->nomor ?? ($bayar->rentalRequest->kamar->nomor ?? null);
                                @endphp

                                <td>
                                    @if($bayar->tanggal_bayar)
                                        <small>{{ \Carbon\Carbon::parse($bayar->tanggal_bayar)->format('d M Y') }}</small>
                                    @else
                                        <small class="text-muted">-</small>
                                    @endif
                                </td>
                                <td>
                                    @if($user)
                                        <strong>{{ $user->name }}</strong><br>
                                        <small class="text-muted">{{ $user->email }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $kosName }}</strong>
                                </td>
                                <td>
                                    @if($kamarNomor)
                                        <span class="badge bg-light text-dark">Kamar {{ $kamarNomor }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>Rp{{ number_format($bayar->jumlah, 0, ',', '.') }}</strong>
                                </td>
                                <td>
                                    @if($bayar->metode === 'transfer')
                                        <i class="bi bi-bank"></i> Transfer
                                    @elseif($bayar->metode === 'cash')
                                        <i class="bi bi-cash-coin"></i> Cash
                                    @else
                                        {{ ucfirst($bayar->metode) }}
                                    @endif
                                </td>
                                <td>
                                    @if($bayar->verified)
                                        <span class="badge badge-verified">
                                            <i class="bi bi-check-circle"></i> Terverifikasi
                                        </span>
                                    @else
                                        <span class="badge badge-pending">
                                            <i class="bi bi-hourglass-split"></i> Menunggu
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($bayar->bukti)
                                        <a href="{{ asset('storage/' . $bayar->bukti) }}" target="_blank" class="btn-proof">
                                            <i class="bi bi-download"></i> Lihat
                                        </a>
                                    @else
                                        <span style="color: #9ca3af; font-size: 12px;">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

    <div class="info-box">
        <i class="bi bi-info-circle" style="flex-shrink: 0; margin-top: 2px;"></i>
        <span>Anda dapat export data transaksi dari menu Laporan untuk lebih detail</span>
    </div>
</div>

<script>
document.getElementById('kos_id').addEventListener('change', function() {
    document.getElementById('hidden_kos_id').value = this.value;
    this.form.submit();
});
</script>
@endsection
