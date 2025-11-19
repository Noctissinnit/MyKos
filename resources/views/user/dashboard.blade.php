@extends('layouts.app')

@section('content')

    <h1>Selamat Datang, User</h1>
    <p>Ini halaman dashboard untuk pemilik kos.</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>

@endsection
