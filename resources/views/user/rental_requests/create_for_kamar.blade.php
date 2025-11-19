@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pesan Kamar {{ $kamar->nomor }} di {{ $kos->nama }}</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.rental_requests.store') }}" method="POST">
        @csrf
        <input type="hidden" name="kos_id" value="{{ $kos->id }}">
        <input type="hidden" name="kamar_id" value="{{ $kamar->id }}">

        <div class="mb-3">
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggal Selesai</label>
            <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Catatan</label>
            <textarea name="message" class="form-control">{{ old('message') }}</textarea>
        </div>

        <button class="btn btn-primary">Kirim Permintaan</button>
    </form>
</div>
@endsection
