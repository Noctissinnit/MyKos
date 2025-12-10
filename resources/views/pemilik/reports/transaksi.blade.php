@extends('layouts.ownerkos')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Laporan Transaksi Pembayaran</h3>
        <a href="{{ route('pemilik.dashboard') }}" class="btn btn-outline-secondary">← Kembali</a>
    </div>

    <!-- Summary Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Total Transaksi</h6>
                    <h3 class="text-primary">{{ $pembayarans->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Total Terkumpul</h6>
                    <h3 class="text-success">Rp {{ number_format($pembayarans->sum('jumlah'), 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Terverifikasi</h6>
                    <h3 class="text-info">{{ $pembayarans->where('verified', true)->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Menunggu Verifikasi</h6>
                    <h3 class="text-warning">{{ $pembayarans->where('verified', false)->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">
                <i class="bi bi-credit-card"></i> Daftar Semua Transaksi
            </h5>
        </div>
        <div class="card-body">
            @if($pembayarans->isEmpty())
                <div class="alert alert-info text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                    <p class="mt-3">Belum ada transaksi pembayaran.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
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
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle"></i> Terverifikasi
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-hourglass-split"></i> Menunggu
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($bayar->bukti)
                                        <a href="{{ asset('storage/' . $bayar->bukti) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-file-earmark-pdf"></i> Lihat
                                        </a>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Export Section -->
    <div class="mt-4">
        <p class="text-muted">
            <i class="bi bi-info-circle"></i>
            Anda dapat export data transaksi dari menu Finance Report untuk analisis lebih detail.
        </p>
    </div>
</div>
@endsection
