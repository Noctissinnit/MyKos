@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Bayar untuk Kamar {{ $penghuni->kamar->nomor ?? '' }}</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.pembayarans.store') }}" method="POST">
        @csrf
        <input type="hidden" name="penghuni_id" value="{{ $penghuni->id }}">

        <div class="mb-3">
            <label class="form-label">Jumlah (Rp)</label>
            <input type="number" name="jumlah" class="form-control" step="0.01" value="{{ old('jumlah') ?? $penghuni->kamar->harga ?? '' }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Metode</label>
            <select name="metode" class="form-control" required>
                <option value="transfer">Transfer</option>
                <option value="cash">Cash</option>
            </select>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="pay_now" id="pay_now" value="1">
            <label class="form-check-label" for="pay_now">Bayar sekarang dan tandai lunas</label>
        </div>

        <button class="btn btn-primary">Buat Pembayaran</button>
    </form>

    <a href="{{ route('user.pembayarans.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
