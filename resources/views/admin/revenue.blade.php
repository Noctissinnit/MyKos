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

    .revenue-card {
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

    .filter-form {
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
    }

    .date-input {
        padding: 10px 16px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        background: white;
    }

    .date-input:focus {
        border-color: #4a6fa5;
        box-shadow: 0 0 0 3px rgba(74, 111, 165, 0.1);
        outline: none;
    }

    .btn-primary-custom {
        background-color: #4a6fa5;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-primary-custom:hover {
        background-color: #3a5a8f;
        transform: translateY(-1px);
    }

    .btn-secondary-custom {
        background-color: white;
        color: #6b7280;
        border: 1px solid #d1d5db;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-secondary-custom:hover {
        background-color: #f9fafb;
        border-color: #9ca3af;
    }

    .revenue-table {
        width: 100%;
        border-collapse: collapse;
    }

    .revenue-table th {
        background: #f8fafc;
        padding: 16px 20px;
        text-align: left;
        font-weight: 600;
        font-size: 14px;
        color: #374151;
        border-bottom: 1px solid #e5e7eb;
    }

    .revenue-table td {
        padding: 16px 20px;
        border-bottom: 1px solid #f3f4f6;
        font-size: 14px;
        color: #374151;
    }

    .revenue-table tr:hover {
        background: #f8fafc;
    }

    .revenue-amount {
        font-weight: 600;
        color: #10b981;
        font-size: 16px;
    }

    .empty-state {
        text-align: center;
        padding: 48px 24px;
        color: #6b7280;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 16px;
        display: block;
        color: #d1d5db;
    }

    .empty-state h6 {
        margin: 0 0 8px 0;
        font-size: 18px;
        font-weight: 600;
        color: #374151;
    }

    .empty-state p {
        margin: 0;
        font-size: 14px;
    }
</style>

<div style="max-width: 1400px; margin: 0 auto; padding: 24px 0;">
    <div class="page-header">
        <h1><i class="bi bi-graph-up" style="margin-right: 12px;"></i>Laporan Revenue</h1>
        <p>Laporan pendapatan pemilik kos berdasarkan pembayaran yang telah lunas</p>
    </div>

    <div class="revenue-card">
        <div class="card-header-custom">
            <h5><i class="bi bi-funnel" style="margin-right: 8px;"></i>Filter Laporan</h5>
            <form method="GET" class="filter-form">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 500; color: #6b7280; margin-bottom: 4px;">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="date-input" value="{{ old('start_date', $start ?? '') }}">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 500; color: #6b7280; margin-bottom: 4px;">Tanggal Akhir</label>
                    <input type="date" name="end_date" class="date-input" value="{{ old('end_date', $end ?? '') }}">
                </div>
                <div style="display: flex; gap: 8px; align-items: end;">
                    <button class="btn-primary-custom">
                        <i class="bi bi-search"></i>
                        Filter
                    </button>
                    <a href="{{ route('admin.revenue') }}" class="btn-secondary-custom">
                        <i class="bi bi-arrow-clockwise"></i>
                        Reset
                    </a>
                </div>
            </form>
        </div>

        @if($rows->isEmpty())
            <div class="empty-state">
                <i class="bi bi-graph-up"></i>
                <h6>Tidak Ada Data</h6>
                <p>Tidak ada pembayaran lunas untuk dilaporkan dalam periode ini.</p>
            </div>
        @else
            <table class="revenue-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Pemilik Kos</th>
                        <th>Email</th>
                        <th>Total Pembayaran</th>
                        <th>Total Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rows as $i => $r)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <div style="font-weight: 600; color: #1f2937;">{{ $r->pemilik_name }}</div>
                        </td>
                        <td>{{ $r->pemilik_email }}</td>
                        <td>
                            <span style="background: #dbeafe; color: #1d4ed8; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;">
                                {{ $r->total_payments }} pembayaran
                            </span>
                        </td>
                        <td>
                            <span class="revenue-amount">Rp {{ number_format($r->total_revenue, 0, ',', '.') }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

@endsection
