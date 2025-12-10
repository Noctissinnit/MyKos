@extends('layouts.ownerkos')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Permintaan Sewa</h3>
        <div>
            <span class="badge bg-warning">{{ $requests->where('status', 'pending')->count() }} Pending</span>
            <span class="badge bg-success ms-2">{{ $requests->where('status', 'approved')->count() }} Approved</span>
            <span class="badge bg-danger ms-2">{{ $requests->where('status', 'rejected')->count() }} Rejected</span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($requests->isEmpty())
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> Belum ada permintaan sewa.
        </div>
    @else
        <!-- Filter Tabs -->
        <ul class="nav nav-tabs mb-4" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#pending">
                    Pending <span class="badge bg-warning ms-2">{{ $requests->where('status', 'pending')->count() }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#approved">
                    Approved <span class="badge bg-success ms-2">{{ $requests->where('status', 'approved')->count() }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#rejected">
                    Rejected <span class="badge bg-danger ms-2">{{ $requests->where('status', 'rejected')->count() }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#all">
                    Semua <span class="badge bg-secondary ms-2">{{ $requests->count() }}</span>
                </a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- Pending Tab -->
            <div id="pending" class="tab-pane fade show active">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Pengguna</th>
                                <th>Kos</th>
                                <th>Tipe/Kamar</th>
                                <th>Periode</th>
                                <th>Tgl Ajuan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests->where('status', 'pending') as $r)
                            <tr>
                                <td>
                                    <strong>{{ $r->user->name ?? '-' }}</strong><br>
                                    <small class="text-muted">{{ $r->user->email ?? '-' }}</small>
                                </td>
                                <td><strong>{{ $r->kos->nama ?? '-' }}</strong></td>
                                <td>
                                    @if($r->kamar)
                                        Kamar {{ $r->kamar->nomor }}
                                    @elseif($r->roomType)
                                        {{ $r->roomType->nama }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <small>
                                        {{ \Carbon\Carbon::parse($r->start_date)->format('d M Y') }} <br>
                                        s/d {{ \Carbon\Carbon::parse($r->end_date)->format('d M Y') }}
                                    </small>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $r->created_at->diffForHumans() }}
                                    </small>
                                </td>
                                <td>
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-hourglass-split"></i> Pending
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('pemilik.rental_requests.show', $r) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox"></i> Tidak ada permintaan pending
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Approved Tab -->
            <div id="approved" class="tab-pane fade">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Pengguna</th>
                                <th>Kos</th>
                                <th>Kamar</th>
                                <th>Periode</th>
                                <th>Tgl Disetujui</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests->where('status', 'approved') as $r)
                            <tr>
                                <td>
                                    <strong>{{ $r->user->name ?? '-' }}</strong><br>
                                    <small class="text-muted">{{ $r->user->email ?? '-' }}</small>
                                </td>
                                <td><strong>{{ $r->kos->nama ?? '-' }}</strong></td>
                                <td>
                                    @if($r->kamar)
                                        <span class="badge bg-light text-dark">Kamar {{ $r->kamar->nomor }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <small>
                                        {{ \Carbon\Carbon::parse($r->start_date)->format('d M Y') }} <br>
                                        s/d {{ \Carbon\Carbon::parse($r->end_date)->format('d M Y') }}
                                    </small>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $r->updated_at->format('d M Y') }}
                                    </small>
                                </td>
                                <td>
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> Disetujui
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('pemilik.rental_requests.show', $r) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox"></i> Tidak ada permintaan yang disetujui
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Rejected Tab -->
            <div id="rejected" class="tab-pane fade">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Pengguna</th>
                                <th>Kos</th>
                                <th>Tipe</th>
                                <th>Periode</th>
                                <th>Tgl Ditolak</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests->where('status', 'rejected') as $r)
                            <tr>
                                <td>
                                    <strong>{{ $r->user->name ?? '-' }}</strong><br>
                                    <small class="text-muted">{{ $r->user->email ?? '-' }}</small>
                                </td>
                                <td><strong>{{ $r->kos->nama ?? '-' }}</strong></td>
                                <td>
                                    @if($r->roomType)
                                        {{ $r->roomType->nama }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <small>
                                        {{ \Carbon\Carbon::parse($r->start_date)->format('d M Y') }} <br>
                                        s/d {{ \Carbon\Carbon::parse($r->end_date)->format('d M Y') }}
                                    </small>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $r->updated_at->format('d M Y') }}
                                    </small>
                                </td>
                                <td>
                                    <span class="badge bg-danger">
                                        <i class="bi bi-x-circle"></i> Ditolak
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox"></i> Tidak ada permintaan yang ditolak
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- All Tab -->
            <div id="all" class="tab-pane fade">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Pengguna</th>
                                <th>Kos</th>
                                <th>Tipe</th>
                                <th>Periode</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $r)
                            <tr>
                                <td>
                                    <strong>{{ $r->user->name ?? '-' }}</strong><br>
                                    <small class="text-muted">{{ $r->user->email ?? '-' }}</small>
                                </td>
                                <td><strong>{{ $r->kos->nama ?? '-' }}</strong></td>
                                <td>
                                    @if($r->kamar)
                                        Kamar {{ $r->kamar->nomor }}
                                    @elseif($r->roomType)
                                        {{ $r->roomType->nama }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <small>
                                        {{ \Carbon\Carbon::parse($r->start_date)->format('d M Y') }} <br>
                                        s/d {{ \Carbon\Carbon::parse($r->end_date)->format('d M Y') }}
                                    </small>
                                </td>
                                <td>
                                    @if($r->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($r->status === 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('pemilik.rental_requests.show', $r) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
