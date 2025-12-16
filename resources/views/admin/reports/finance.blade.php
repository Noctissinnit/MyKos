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

    .finance-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
        margin-bottom: 24px;
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

    .btn-export {
        background-color: #10b981;
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

    .btn-export:hover {
        background-color: #059669;
        transform: translateY(-1px);
    }

    .total-amount {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        margin-bottom: 16px;
    }

    .total-amount .label {
        font-size: 14px;
        opacity: 0.9;
        margin-bottom: 4px;
    }

    .total-amount .amount {
        font-size: 32px;
        font-weight: 700;
        margin: 0;
    }

    .finance-table {
        width: 100%;
        border-collapse: collapse;
    }

    .finance-table th {
        background: #f8fafc;
        padding: 16px 20px;
        text-align: left;
        font-weight: 600;
        font-size: 14px;
        color: #374151;
        border-bottom: 1px solid #e5e7eb;
    }

    .finance-table td {
        padding: 16px 20px;
        border-bottom: 1px solid #f3f4f6;
        font-size: 14px;
        color: #374151;
    }

    .finance-table tr:hover {
        background: #f8fafc;
    }

    .amount-cell {
        font-weight: 600;
        color: #10b981;
    }

    .method-badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 500;
        text-transform: uppercase;
    }

    .method-cash { background: #dbeafe; color: #1d4ed8; }
    .method-transfer { background: #d1fae5; color: #065f46; }

    .status-badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 500;
    }

    .status-lunas { background: #d1fae5; color: #065f46; }
    .status-pending { background: #fef3c7; color: #d97706; }
    .status-gagal { background: #fee2e2; color: #dc2626; }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
        margin: 24px 0 16px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
</style>

<div style="max-width: 1400px; margin: 0 auto; padding: 24px 0;">
    <div class="page-header">
        <h1><i class="bi bi-cash-stack" style="margin-right: 12px;"></i>Laporan Keuangan</h1>
        <p>Ringkasan lengkap pembayaran dan pendapatan sistem MyKos</p>
    </div>

    <div class="finance-card">
        <div class="card-header-custom">
            <h5><i class="bi bi-funnel" style="margin-right: 8px;"></i>Filter Laporan</h5>
            <form method="GET" class="filter-form">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 500; color: #6b7280; margin-bottom: 4px;">Tanggal Mulai</label>
                    <input type="date" name="start_date" value="{{ $start }}" class="date-input">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 500; color: #6b7280; margin-bottom: 4px;">Tanggal Akhir</label>
                    <input type="date" name="end_date" value="{{ $end }}" class="date-input">
                </div>
                <div style="display: flex; gap: 8px; align-items: end;">
                    <button class="btn-primary-custom">
                        <i class="bi bi-search"></i>
                        Filter
                    </button>
                    <a href="{{ route('admin.reports.finance.export', ['start_date' => $start, 'end_date' => $end]) }}" class="btn-export">
                        <i class="bi bi-download"></i>
                        Export CSV
                    </a>
                </div>
            </form>
        </div>

        <div style="padding: 24px;">
            <div class="total-amount">
                <div class="label">Total Terkumpul</div>
                <div class="amount">Rp{{ number_format($total, 0, ',', '.') }}</div>
            </div>

            <div class="section-title">
                <i class="bi bi-building"></i>
                Ringkasan per Kos
            </div>
            <table class="finance-table">
                <thead>
                    <tr>
                        <th>Nama Kos</th>
                        <th>Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($byKos as $k)
                    <tr>
                        <td>
                            <div style="font-weight: 600; color: #1f2937;">{{ $k['nama'] }}</div>
                        </td>
                        <td>
                            <span class="amount-cell">Rp{{ number_format($k['total'], 0, ',', '.') }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="section-title">
                <i class="bi bi-receipt"></i>
                Daftar Pembayaran
            </div>
            <table class="finance-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kos</th>
                        <th>Kamar</th>
                        <th>Jumlah</th>
                        <th>Metode</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $p)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_bayar)->format('d M Y') }}</td>
                        <td>{{ $p->kos_name }}</td>
                        <td>{{ $p->kamar_nomor }}</td>
                        <td>
                            <span class="amount-cell">Rp{{ number_format($p->jumlah, 0, ',', '.') }}</span>
                        </td>
                        <td>
                            <span class="method-badge method-{{ strtolower($p->metode) }}">
                                {{ ucfirst($p->metode) }}
                            </span>
                        </td>
                        <td>
                            <span class="status-badge status-{{ strtolower($p->status) }}">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
