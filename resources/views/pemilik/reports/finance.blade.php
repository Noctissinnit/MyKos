@extends('layouts.ownerkos')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
        padding-bottom: 24px;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .page-header h2 {
        margin: 0;
        font-size: 28px;
        font-weight: 600;
        color: #1f2937;
    }
    
    .filter-form {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: flex-end;
    }
    
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    
    .form-group label {
        font-weight: 500;
        color: #374151;
        font-size: 14px;
    }
    
    .form-group input,
    .form-group select {
        padding: 10px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-family: inherit;
        font-size: 14px;
        transition: all 0.2s;
    }
    
    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #4a6fa5;
        box-shadow: inset 0 0 0 3px rgba(74, 111, 165, 0.1);
    }
    
    .btn-filter {
        background-color: #4a6fa5;
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-filter:hover {
        background-color: #3a5a8f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 111, 165, 0.3);
    }
    
    .btn-export {
        background-color: white;
        color: #4a6fa5;
        border: 2px solid #4a6fa5;
        padding: 8px 18px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .btn-export:hover {
        background-color: #4a6fa5;
        color: white;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }
    
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }
    
    .stat-label {
        font-size: 13px;
        color: #6b7280;
        font-weight: 500;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
    }
    
    .table-container {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }
    
    .table {
        margin-bottom: 0;
        font-size: 14px;
    }
    
    .table thead {
        background-color: #f3f4f6;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .table thead th {
        padding: 14px 16px;
        font-weight: 600;
        color: #374151;
        border: none;
    }
    
    .table tbody td {
        padding: 14px 16px;
        border-bottom: 1px solid #f3f4f6;
        color: #374151;
    }
    
    .table tbody tr:hover {
        background-color: #f9fafb;
    }
    
    .table tbody tr:last-child td {
        border-bottom: none;
    }
</style>

<div class="container" style="max-width: 1400px; padding: 24px 0;">
    <div class="page-header">
        <h2><i class="bi bi-bar-chart" style="margin-right: 12px;"></i>Laporan Keuangan</h2>
    </div>

    <div class="filter-form">
        <form style="display: flex; gap: 12px; flex-wrap: wrap; align-items: flex-end; flex: 1;">
            <div class="form-group" style="width: auto;">
                <label for="start_date">Tanggal Mulai</label>
                <input type="date" id="start_date" name="start_date" value="{{ $start }}" style="width: 160px;">
            </div>
            <div class="form-group" style="width: auto;">
                <label for="end_date">Tanggal Akhir</label>
                <input type="date" id="end_date" name="end_date" value="{{ $end }}" style="width: 160px;">
            </div>
            <button type="submit" class="btn-filter">
                <i class="bi bi-funnel" style="margin-right: 6px;"></i> Filter
            </button>
        </form>
        <a href="{{ route('pemilik.reports.finance.export', ['start_date' => $start, 'end_date' => $end]) }}" class="btn-export">
            <i class="bi bi-download"></i> Export CSV
        </a>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label"><i class="bi bi-currency-exchange" style="color: #4a6fa5;"></i>Total Terkumpul</div>
            <div class="stat-value" style="color: #10b981;">Rp{{ number_format($total,0,',','.') }}</div>
        </div>
    </div>

    <h3 style="font-size: 18px; font-weight: 600; color: #1f2937; margin-bottom: 16px;">
        <i class="bi bi-building" style="margin-right: 8px;"></i>Ringkasan per Kos
    </h3>
    
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Kos</th>
                    <th style="text-align: right; width: 200px;">Total Terkumpul</th>
                </tr>
            </thead>
            <tbody>
                @foreach($byKos as $k)
                    <tr>
                        <td><strong>{{ $k['nama'] }}</strong></td>
                        <td style="text-align: right;"><strong style="color: #10b981;">Rp{{ number_format($k['total'],0,',','.') }}</strong></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
