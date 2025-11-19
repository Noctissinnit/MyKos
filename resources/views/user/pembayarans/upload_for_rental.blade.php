@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Unggah Bukti Pembayaran untuk Ajuan Sewa</h1>

    <p><strong>Kos:</strong> {{ $rentalRequest->kos->nama ?? '-' }}</p>
    <p><strong>Periode:</strong> {{ $rentalRequest->start_date }} - {{ $rentalRequest->end_date }}</p>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.pembayarans.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="rental_request_id" value="{{ $rentalRequest->id }}">

        <div class="mb-3">
            <label class="form-label">Jumlah (Rp)</label>
            <input type="number" name="jumlah" class="form-control" step="0.01" value="{{ old('jumlah') ?? 0 }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Metode</label>
            <select name="metode" class="form-control" required>
                <option value="transfer">Transfer</option>
                <option value="cash">Cash</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Bukti (jpg/png/pdf)</label>
            <input type="file" name="bukti" class="form-control" accept="image/*,application/pdf" required>
        </div>

        <button class="btn btn-primary">Unggah Bukti</button>
    </form>

    <a href="{{ route('user.rental_requests.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
