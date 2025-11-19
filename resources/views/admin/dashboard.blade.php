@extends('layouts.admin')

@section('content')

    <div class="col-md-8 mx-auto">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow">
            <div class="card-body">
                <h4>Selamat Datang, {{ auth()->user()->name }}</h4>
                <p>Ini halaman dashboard untuk admin.</p>

                <a href="{{ route('admin.kos.applications') }}" class="btn btn-primary me-2">Lihat Pengajuan Kos</a>

                <form method="POST" action="{{ route('logout') }}" style="display:inline-block">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary">Logout</button>
                </form>
            </div>
        </div>
    </div>

@endsection
