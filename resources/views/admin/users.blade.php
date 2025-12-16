@extends('layouts.admin')

@section('content')
<style>
    .page-header {
        margin-bottom: 32px;
        padding-bottom: 24px;
        border-bottom: 1px solid #e5e7eb;
    }

    .page-header h1 {
        margin: 0 0 8px 0;
        font-size: 28px;
        font-weight: 600;
        color: #1f2937;
    }

    .page-header p {
        margin: 0;
        color: #6b7280;
        font-size: 16px;
    }

    .users-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
    }

    .card-header-custom {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        padding: 24px;
        border-bottom: 1px solid #e5e7eb;
    }

    .card-header-custom h5 {
        margin: 0 0 16px 0;
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
    }

    .search-bar {
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
    }

    .search-input {
        flex: 1;
        min-width: 200px;
        padding: 10px 16px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.2s;
    }

    .search-input:focus {
        border-color: #4a6fa5;
        box-shadow: 0 0 0 3px rgba(74, 111, 165, 0.1);
        outline: none;
    }

    .filter-select {
        padding: 10px 16px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        background: white;
        cursor: pointer;
    }

    .filter-select:focus {
        border-color: #4a6fa5;
        outline: none;
    }

    .stats-bar {
        display: flex;
        gap: 24px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: #6b7280;
    }

    .stat-number {
        font-weight: 600;
        color: #4a6fa5;
    }

    .users-table {
        width: 100%;
        border-collapse: collapse;
    }

    .users-table th {
        background: #f8fafc;
        padding: 16px 20px;
        text-align: left;
        font-weight: 600;
        font-size: 14px;
        color: #374151;
        border-bottom: 1px solid #e5e7eb;
    }

    .users-table td {
        padding: 16px 20px;
        border-bottom: 1px solid #f3f4f6;
        font-size: 14px;
        color: #374151;
    }

    .users-table tr:hover {
        background: #f8fafc;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: linear-gradient(135deg, #4a6fa5, #3a5a8f);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 16px;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-details {
        flex: 1;
    }

    .user-name {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 2px;
    }

    .user-email {
        font-size: 12px;
        color: #6b7280;
    }

    .role-badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 500;
        text-transform: uppercase;
    }

    .role-admin { background: #fee2e2; color: #dc2626; }
    .role-pemilik { background: #dbeafe; color: #1d4ed8; }
    .role-user { background: #d1fae5; color: #065f46; }

    .status-badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 500;
    }

    .status-active { background: #d1fae5; color: #065f46; }
    .status-banned { background: #fee2e2; color: #dc2626; }

    .action-buttons {
        display: flex;
        gap: 6px;
    }

    .btn-ban {
        background-color: #ef4444;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .btn-ban:hover {
        background-color: #dc2626;
        transform: translateY(-1px);
    }

    .btn-unban {
        background-color: #10b981;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .btn-unban:hover {
        background-color: #059669;
        transform: translateY(-1px);
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
</style>

<div style="max-width: 1400px; margin: 0 auto; padding: 24px 0;">
    <div class="page-header">
        <h1><i class="bi bi-people" style="margin-right: 12px;"></i>Kelola Pengguna</h1>
        <p>Kelola semua pengguna sistem MyKos</p>
    </div>

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="alert-custom alert-success">
            <i class="bi bi-check-circle" style="margin-right: 8px;"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-custom alert-danger">
            <i class="bi bi-exclamation-triangle" style="margin-right: 8px;"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="users-card">
        <div class="card-header-custom">
            <h5><i class="bi bi-list" style="margin-right: 8px;"></i>Daftar Pengguna</h5>

            <div class="stats-bar">
                <div class="stat-item">
                    <i class="bi bi-people"></i>
                    <span>Total: <span class="stat-number">{{ $users->count() }}</span></span>
                </div>
                <div class="stat-item">
                    <i class="bi bi-person-check"></i>
                    <span>Aktif: <span class="stat-number">{{ $users->where('banned', false)->count() }}</span></span>
                </div>
                <div class="stat-item">
                    <i class="bi bi-person-x"></i>
                    <span>Banned: <span class="stat-number">{{ $users->where('banned', true)->count() }}</span></span>
                </div>
            </div>

            <div class="search-bar">
                <input type="text" class="search-input" placeholder="Cari nama atau email..." id="searchInput">
                <select class="filter-select" id="roleFilter">
                    <option value="">Semua Role</option>
                    <option value="admin">Admin</option>
                    <option value="pemilik">Pemilik Kos</option>
                    <option value="user">User</option>
                </select>
                <select class="filter-select" id="statusFilter">
                    <option value="">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="banned">Banned</option>
                </select>
            </div>
        </div>

        <table class="users-table">
            <thead>
                <tr>
                    <th>Pengguna</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                        <div class="user-info">
                            <div class="user-avatar">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="user-details">
                                <div class="user-name">{{ $user->name }}</div>
                                <div class="user-email">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="role-badge role-{{ $user->role }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>
                        <span class="status-badge status-{{ $user->banned ? 'banned' : 'active' }}">
                            {{ $user->banned ? 'Banned' : 'Aktif' }}
                        </span>
                    </td>
                    <td>{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        @if(auth()->id() === $user->id)
                            <span style="color: #6b7280; font-size: 12px;">-</span>
                        @else
                            @if(!$user->banned)
                            <form action="{{ route('admin.user.ban', $user->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn-ban" onclick="return confirm('Yakin ingin memban user ini?')">
                                    <i class="bi bi-x-circle"></i>
                                    Ban
                                </button>
                            </form>
                            @else
                            <form action="{{ route('admin.user.unban', $user->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn-unban" onclick="return confirm('Yakin ingin mengaktifkan user ini?')">
                                    <i class="bi bi-check-circle"></i>
                                    Unban
                                </button>
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

<script>
document.getElementById('searchInput').addEventListener('input', filterUsers);
document.getElementById('roleFilter').addEventListener('change', filterUsers);
document.getElementById('statusFilter').addEventListener('change', filterUsers);

function filterUsers() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const roleFilter = document.getElementById('roleFilter').value;
    const statusFilter = document.getElementById('statusFilter').value;
    const rows = document.querySelectorAll('.users-table tbody tr');

    rows.forEach(row => {
        const name = row.cells[0].textContent.toLowerCase();
        const email = row.cells[0].textContent.toLowerCase();
        const role = row.cells[1].textContent.toLowerCase().trim();
        const status = row.cells[2].textContent.toLowerCase().trim();

        const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
        const matchesRole = !roleFilter || role.includes(roleFilter);
        const matchesStatus = !statusFilter || status.includes(statusFilter);

        row.style.display = matchesSearch && matchesRole && matchesStatus ? '' : 'none';
    });
}
</script>

@endsection
