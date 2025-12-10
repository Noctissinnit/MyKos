@extends('layouts.ownerkos')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Kelola Foto Kamar {{ $kamar->nomor }} - {{ $kos->nama }}</h3>
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
        <!-- Upload Form -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Tambah Foto</h5>
                    <form action="{{ route('pemilik.kamar.upload.photo', [$kos->id, $kamar->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Pilih Foto (Max 5MB)</label>
                            <input type="file" name="photo" class="form-control" accept="image/*" required>
                            <small class="text-muted d-block mt-2">Format: JPEG, PNG, JPG, GIF</small>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Upload</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Photos Gallery -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Daftar Foto ({{ count($photos) }})</h5>
                    
                    @if($photos->isEmpty())
                        <p class="text-muted">Belum ada foto untuk kamar ini.</p>
                    @else
                        <div class="row g-3">
                            @foreach($photos as $photo)
                            <div class="col-md-6">
                                <div class="card position-relative">
                                    <img src="{{ asset('storage/' . $photo->photo_path) }}" class="card-img-top" alt="Kamar" style="height: 200px; object-fit: cover;">
                                    
                                    @if($photo->is_primary)
                                        <span class="badge bg-warning position-absolute top-0 end-0 m-2">UTAMA</span>
                                    @endif

                                    <div class="card-body p-2">
                                        <div class="btn-group btn-group-sm w-100" role="group">
                                            @if(!$photo->is_primary)
                                                <form action="{{ route('pemilik.kamar.set.primary.photo', [$kos->id, $kamar->id, $photo->id]) }}" method="POST" class="d-inline w-100">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success w-100">Jadikan Utama</button>
                                                </form>
                                            @endif
                                            
                                            <form action="{{ route('pemilik.kamar.delete.photo', [$kos->id, $kamar->id, $photo->id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus foto?')">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
