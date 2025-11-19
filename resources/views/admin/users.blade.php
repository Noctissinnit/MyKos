@extends('layouts.admin')

@section('content')
<div class="col-md-10 mx-auto">
    <div class="card shadow">
        <div class="card-body">
            <h4 class="mb-4">Daftar Pengguna</h4>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->banned ? 'Banned' : 'Active' }}</td>
                        <td>
                            @if(auth()->id() === $user->id)
                                <span class="text-muted">-</span>
                            @else
                                @if(!$user->banned)
                                <form action="{{ route('admin.user.ban', $user->id) }}" method="POST" style="display:inline-block" class="confirm-action" data-confirm="Yakin ingin memban user ini?">
                                    @csrf
                                    <button class="btn btn-sm btn-danger">Ban</button>
                                </form>
                                @else
                                <form action="{{ route('admin.user.unban', $user->id) }}" method="POST" style="display:inline-block" class="confirm-action" data-confirm="Yakin ingin mengaktifkan kembali user ini?">
                                    @csrf
                                    <button class="btn btn-sm btn-success">Unban</button>
                                </form>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
        <script>
            // Attach confirmation to forms with class 'confirm-action'
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('form.confirm-action').forEach(function (form) {
                    form.addEventListener('submit', function (e) {
                        var msg = form.getAttribute('data-confirm') || 'Are you sure?';
                        if (! confirm(msg)) {
                            e.preventDefault();
                        }
                    });
                });
            });
        </script>
@endsection
