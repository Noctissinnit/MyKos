@extends('layouts.ownerkos')

@section('content')
<div class="container py-3">
    <h4 class="mb-4">Riwayat Pembayaran Penghuni</h4>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Penghuni</th>
                <th>Kamar</th>
                <th>Tanggal Bayar</th>
                <th>Jumlah</th>
                <th>Metode</th>
                <th>Status</th>
                <th>Bukti</th>
            </tr>
        </thead>

        <tbody>
            @forelse($pembayarans as $bayar)
                <tr>
                    <td>{{ $bayar->penghuni->user->name }}</td>
                    <td>{{ $bayar->penghuni->kamar->nomor }}</td>
                    <td>{{ $bayar->tanggal_bayar }}</td>
                    <td>Rp{{ number_format($bayar->jumlah, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($bayar->metode) }}</td>

                    <td>
                        @if($bayar->verified)
                            <span class="badge bg-success">Terverifikasi</span>
                        @else
                            <span class="badge bg-warning">Menunggu</span>
                        @endif
                    </td>

                    <td>
                        @if($bayar->bukti)
                            <a href="{{ asset('storage/' . $bayar->bukti) }}" target="_blank">
                                Lihat Bukti
                            </a>
                        @else
                            <span class="text-muted">Tidak ada</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">
                        Belum ada pembayaran.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
