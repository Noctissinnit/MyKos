@extends('layouts.ownerkos')

@section('content')
<div class="col-md-6 mx-auto">
    <div class="card shadow">
        <div class="card-body">
            <h4 class="mb-4">Tambah Kamar untuk {{ $kos->nama }}</h4>

            <form action="{{ route('pemilik.kamar.store', $kos->id) }}" method="POST">
                @csrf

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <input type="hidden" id="kelas" name="kelas">


                        <div class="mb-3">
                            <label>Nomor Kamar</label>
                            <input type="text" name="nomor" class="form-control" value="{{ old('nomor') }}" required>
                        </div>

                <div class="mb-3">
                    <label>Tipe Kamar</label>
                    <select name="room_type_id" id="room_type_id" class="form-select" required>
                        <option value="">-- Pilih Tipe Kamar --</option>
                        @foreach($roomTypes as $type)
                            <option value="{{ $type->id }}" data-harga="{{ $type->harga }}">
                                {{ $type->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Harga (per bulan)</label>
                    <input type="number" id="harga" name="harga" class="form-control" readonly>
                </div>


                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('pemilik.kamar.index', $kos->id) }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script>
document.getElementById('room_type_id').addEventListener('change', function() {
    let selected = this.options[this.selectedIndex];
    let harga = selected.getAttribute('data-harga');
    let nama = selected.text; // kelas = nama type

    document.getElementById('harga').value = harga ?? '';
    document.getElementById('kelas').value = nama ?? '';
});
</script>

@endsection 