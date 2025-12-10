@extends('layouts.ownerkos')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Kelola Fasilitas Kamar {{ $kamar->nomor }} - {{ $kos->nama }}</h3>
        <a href="{{ route('pemilik.kamar.index', $kos->id) }}" class="btn btn-secondary">← Kembali</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <!-- Add Form -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Tambah Fasilitas</h5>
                    <form action="{{ route('pemilik.kamar.add.facility', [$kos->id, $kamar->id]) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Fasilitas</label>
                            <input type="text" name="nama_fasilitas" class="form-control" placeholder="Contoh: AC, WiFi, Lemari" required>
                            <small class="text-muted d-block mt-2">Masukkan nama fasilitas kamar</small>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Tambah Fasilitas</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Facilities List -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Daftar Fasilitas ({{ count($facilities) }})</h5>
                    
                    @if($facilities->isEmpty())
                        <p class="text-muted">Belum ada fasilitas untuk kamar ini.</p>
                    @else
                        <div class="list-group">
                            @foreach($facilities as $facility)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                        {{ $facility->nama_fasilitas }}
                                    </h6>
                                    <small class="text-muted">Ditambahkan: {{ $facility->created_at->format('d M Y H:i') }}</small>
                                </div>
                                <form action="{{ route('pemilik.kamar.delete.facility', [$kos->id, $kamar->id, $facility->id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus fasilitas?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Suggested Facilities -->
    <div class="mt-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Fasilitas Umum yang Biasa Digunakan</h5>
                <div class="row g-2">
                    @php
                        $suggestedFacilities = [
                            'AC', 'WiFi', 'Tempat Tidur', 'Lemari', 'Meja Belajar', 'Kursi',
                            'Lemari Es (Kulkas)', 'Kamar Mandi Pribadi', 'Shower', 'Toilet',
                            'Tempat Jemuran', 'Ventilasi Baik', 'Pencahayaan Terang', 'Pintu Kunci'
                        ];
                    @endphp
                    @foreach($suggestedFacilities as $suggestion)
                        <div class="col-auto">
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addQuickFacility('{{ $suggestion }}')">
                                + {{ $suggestion }}
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function addQuickFacility(name) {
    // Buat form dan submit
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("pemilik.kamar.add.facility", [$kos->id, $kamar->id]) }}';
    
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = '{{ csrf_token() }}';
    
    const facilityInput = document.createElement('input');
    facilityInput.type = 'hidden';
    facilityInput.name = 'nama_fasilitas';
    facilityInput.value = name;
    
    form.appendChild(csrfInput);
    form.appendChild(facilityInput);
    document.body.appendChild(form);
    form.submit();
}
</script>
@endsection
