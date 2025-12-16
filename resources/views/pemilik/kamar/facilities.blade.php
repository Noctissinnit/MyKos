@extends('layouts.ownerkos')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
    }

    .page-header h2 {
        font-size: 24px;
        font-weight: 700;
        color: #1f1f1f;
        margin: 0;
    }

    .btn-back {
        background-color: white;
        color: #6c757d;
        border: 1px solid #e5e7eb;
        padding: 10px 24px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background-color: #f9fafb;
        border-color: #d1d5db;
        color: #1f1f1f;
    }

    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .alert-success {
        background-color: #dcfce7;
        color: #166534;
        border: 1px solid #86efac;
    }

    .alert-danger {
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .facilities-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .card-title {
        font-size: 18px;
        font-weight: 700;
        color: #1f1f1f;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #1f1f1f;
        margin-bottom: 8px;
    }

    .form-group input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        font-family: 'Poppins', sans-serif;
        transition: all 0.3s ease;
    }

    .form-group input:focus {
        outline: none;
        border-color: #4a6fa5;
        box-shadow: 0 0 0 3px rgba(74, 111, 165, 0.1);
    }

    .form-help {
        font-size: 12px;
        color: #6c757d;
        margin-top: 6px;
    }

    .btn-submit {
        width: 100%;
        padding: 12px 24px;
        background-color: #4a6fa5;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        background-color: #3a5a8f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 111, 165, 0.3);
    }

    .facilities-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .facility-item {
        background: white;
        padding: 14px;
        border-radius: 8px;
        margin-bottom: 10px;
        border: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.2s ease;
    }

    .facility-item:hover {
        border-color: #4a6fa5;
        box-shadow: 0 2px 8px rgba(74, 111, 165, 0.1);
    }

    .facility-info h6 {
        margin: 0;
        color: #1f1f1f;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .facility-info small {
        color: #6c757d;
        font-size: 12px;
        margin-top: 4px;
        display: block;
    }

    .facility-info i {
        color: #10b981;
    }

    .btn-delete {
        background-color: #fee2e2;
        color: #dc2626;
        padding: 6px 12px;
        border-radius: 6px;
        border: none;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-delete:hover {
        background-color: #fecaca;
    }

    .suggested-section {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .suggested-title {
        font-size: 18px;
        font-weight: 700;
        color: #1f1f1f;
        margin-bottom: 16px;
    }

    .suggested-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .btn-suggestion {
        padding: 8px 14px;
        border-radius: 6px;
        border: 2px solid #e5e7eb;
        background-color: white;
        color: #4a6fa5;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-suggestion:hover {
        border-color: #4a6fa5;
        background-color: #f0f4f8;
    }

    .empty-message {
        text-align: center;
        color: #6c757d;
        padding: 20px;
    }

    .alert-custom {
        padding: 16px 20px;
        border-radius: 8px;
        border: none;
        margin-bottom: 24px;
    }

    .alert-success {
        background-color: #d1fae5;
        color: #065f46;
    }

    .alert-danger {
        background-color: #fee2e2;
        color: #dc2626;
    }

    .alert-danger ul {
        margin: 0;
        padding-left: 20px;
    }

    .alert-danger li {
        margin-bottom: 4px;
    }
</style>

<div class="page-header">
    <h2>Kelola Fasilitas Kamar {{ $kamar->nomor }} - {{ $kos->nama }}</h2>
    <a href="{{ route('pemilik.kamar.index', $kos->id) }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

@if(session('success'))
    <div class="alert-custom alert-success">
        <i class="bi bi-check-circle" style="margin-right: 8px;"></i>
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert-custom alert-danger">
        <i class="bi bi-exclamation-triangle" style="margin-right: 8px;"></i>
        <strong>Terjadi kesalahan:</strong>
        <ul style="margin: 8px 0 0 0; padding-left: 20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="facilities-grid">
    <!-- Add Form -->
    <div class="card">
        <h3 class="card-title">Tambah Fasilitas</h3>
        <form action="{{ route('pemilik.kamar.add.facility', [$kos->id, $kamar->id]) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama_fasilitas">Nama Fasilitas</label>
                <input 
                    type="text" 
                    id="nama_fasilitas" 
                    name="nama_fasilitas" 
                    placeholder="Contoh: AC, WiFi, Lemari" 
                    required>
                <div class="form-help">Masukkan nama fasilitas kamar</div>
            </div>
            <button type="submit" class="btn-submit">
                <i class="bi bi-plus-lg me-2"></i> Tambah Fasilitas
            </button>
        </form>
    </div>

    <!-- Facilities List -->
    <div class="card">
        <h3 class="card-title">Daftar Fasilitas ({{ count($facilities) }})</h3>
        
        @if($facilities->isEmpty())
            <div class="empty-message">
                <i class="bi bi-inbox" style="font-size: 32px; color: #d1d5db; display: block; margin-bottom: 8px;"></i>
                <p>Belum ada fasilitas untuk kamar ini.</p>
            </div>
        @else
            <ul class="facilities-list">
                @foreach($facilities as $facility)
                <li class="facility-item">
                    <div class="facility-info">
                        <h6>
                            <i class="bi bi-check-circle-fill"></i>
                            {{ $facility->nama_fasilitas }}
                        </h6>
                        <small>Ditambahkan: {{ $facility->created_at->format('d M Y H:i') }}</small>
                    </div>
                    <form action="{{ route('pemilik.kamar.delete.facility', [$kos->id, $kamar->id, $facility->id]) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete" onclick="return confirm('Hapus fasilitas ini?')">
                            <i class="bi bi-trash me-1"></i> Hapus
                        </button>
                    </form>
                </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

<!-- Suggested Facilities -->
<div class="suggested-section">
    <h3 class="suggested-title">Fasilitas Umum yang Biasa Digunakan</h3>
    <div class="suggested-buttons">
        @php
            $suggestedFacilities = [
                'AC', 'WiFi', 'Tempat Tidur', 'Lemari', 'Meja Belajar', 'Kursi',
                'Lemari Es (Kulkas)', 'Kamar Mandi Pribadi', 'Shower', 'Toilet',
                'Tempat Jemuran', 'Ventilasi Baik', 'Pencahayaan Terang', 'Pintu Kunci'
            ];
        @endphp
        @foreach($suggestedFacilities as $suggestion)
            <button type="button" class="btn-suggestion" onclick="addQuickFacility('{{ $suggestion }}')">
                <i class="bi bi-plus"></i> {{ $suggestion }}
            </button>
        @endforeach
    </div>
</div>

<script>
function addQuickFacility(name) {
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
