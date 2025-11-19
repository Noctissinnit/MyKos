@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pesan {{ $roomType->nama }} di {{ $kos->nama }}</h1>

    <form action="{{ route('user.rental_requests.store') }}" method="POST">
        @csrf
        <input type="hidden" name="kos_id" value="{{ $kos->id }}">
        <input type="hidden" name="room_type_id" value="{{ $roomType->id }}">

        <div class="mb-3">
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggal Selesai</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Catatan / Pesan</label>
            <textarea name="message" class="form-control"></textarea>
        </div>

        <button class="btn btn-primary">Kirim Permintaan</button>
    </form>
</div>
@endsection
