@extends('layouts.ownerkos')

@section('content')
<div class="container">
    <h1>Permintaan dari {{ $rentalRequest->user->name ?? 'Pengguna' }}</h1>

    <p><strong>Tipe:</strong> {{ $rentalRequest->roomType->nama ?? '-' }}</p>
    <p><strong>Periode:</strong> {{ $rentalRequest->start_date }} - {{ $rentalRequest->end_date }}</p>
    <p><strong>Pesan:</strong> {{ $rentalRequest->message }}</p>

    <h4>Pilih Kamar untuk disetujui</h4>
    <form action="{{ route('pemilik.rental_requests.approve', $rentalRequest) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Kamar</label>
            <select name="kamar_id" class="form-control" required>
                @foreach($availableKamars as $k)
                    <option value="{{ $k->id }}">{{ $k->nomor }} - {{ $k->nama_kamar ?? $k->kelas }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-success">Setuju dan Tunjuk Kamar</button>
    </form>

    <form action="{{ route('pemilik.rental_requests.reject', $rentalRequest) }}" method="POST" style="margin-top:10px;">
        @csrf
        <button class="btn btn-danger">Tolak Permintaan</button>
    </form>

    <hr>
    <h4>Bukti Pembayaran</h4>
    @if($rentalRequest->payments->isEmpty())
        <div class="alert alert-info">Belum ada bukti pembayaran diunggah oleh user.</div>
    @else
        @foreach($rentalRequest->payments as $pay)
            <div class="card mb-2">
                <div class="card-body">
                    <p><strong>Jumlah:</strong> Rp{{ number_format($pay->jumlah,0,',','.') }}</p>
                    <p><strong>Metode:</strong> {{ ucfirst($pay->metode) }}</p>
                    <p><strong>Status:</strong> {{ $pay->verified ? 'Terverifikasi' : ucfirst($pay->status) }}</p>
                    @if($pay->bukti)
                        <p>
                            <a href="{{ asset('storage/' . $pay->bukti) }}" target="_blank">Lihat Bukti</a>
                        </p>
                    @endif

                    @if(!$pay->verified)
                        <form action="{{ route('pemilik.pembayarans.verify', $pay) }}" method="POST">
                            @csrf
                            <button class="btn btn-sm btn-success">Verifikasi Pembayaran</button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    @endif

</div>
@endsection
