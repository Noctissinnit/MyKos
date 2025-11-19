@extends('layouts.admin')

@section('content')
<div class="col-md-10 mx-auto">
    <div class="card shadow">
        <div class="card-body">
            <h4 class="mb-4">Pengajuan Kos (Pending)</h4>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($kosList->isEmpty())
                <p>Tidak ada pengajuan kos saat ini.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Pemilik</th>
                            <th>Alamat</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kosList as $kos)
                        <tr>
                            <td>{{ $kos->nama }}</td>
                            <td>{{ $kos->pemilik->name ?? '-' }}</td>
                            <td>{{ $kos->alamat }}</td>
                            <td>{{ Str::limit($kos->deskripsi, 80) }}</td>
                            <td>
                                <form action="{{ route('admin.kos.approve', $kos->id) }}" method="POST" style="display:inline-block">
                                    @csrf
                                    <button class="btn btn-sm btn-success">Setujui</button>
                                </form>

                                <form action="{{ route('admin.kos.reject', $kos->id) }}" method="POST" style="display:inline-block">
                                    @csrf
                                    <button class="btn btn-sm btn-danger">Tolak</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
