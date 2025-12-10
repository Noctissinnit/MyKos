@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Unggah Bukti Pembayaran untuk Ajuan Sewa</h1>

    <div class="row mb-4">
        <div class="col-md-6">
            <p><strong>Kos:</strong> {{ $rentalRequest->kos->nama ?? '-' }}</p>
            <p><strong>Periode:</strong> {{ $rentalRequest->start_date }} - {{ $rentalRequest->end_date }}</p>
        </div>
        <div class="col-md-6">
            <div class="alert alert-info">
                <strong>Jumlah Pembayaran:</strong>
                <h4 class="text-primary">Rp {{ number_format($jumlah, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>

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
        <input type="hidden" name="jumlah" value="{{ $jumlah }}">

        <div class="mb-3">
            <label class="form-label">Metode Pembayaran</label>
            <select name="metode" class="form-control" required>
                <option value="">-- Pilih Metode --</option>
                <option value="transfer" @if(old('metode') === 'transfer') selected @endif>Transfer Bank</option>
                <option value="cash" @if(old('metode') === 'cash') selected @endif>Cash</option>
            </select>
            @error('metode')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Bukti Pembayaran <span class="text-danger">*</span></label>
            <input type="file" name="bukti" class="form-control" accept="image/*,application/pdf" required>
            <small class="text-muted d-block mt-2">Format: JPG, PNG, atau PDF (Max 2MB)</small>
            @error('bukti')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="alert alert-warning">
            <i class="bi bi-info-circle"></i>
            <strong>Catatan:</strong> Setelah unggah bukti, pemilik akan memverifikasi pembayaran Anda dalam waktu 1-2 hari kerja.
        </div>

        <button class="btn btn-primary btn-lg">
            <i class="bi bi-upload"></i> Unggah Bukti Pembayaran
        </button>
        <a href="{{ route('user.rental_requests.index') }}" class="btn btn-secondary btn-lg">Batal</a>
    </form>
</div>
@endsection
