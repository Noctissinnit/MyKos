@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Laporan Keuangan (Admin)</h1>

    <form class="row g-2 mb-3">
        <div class="col-auto">
            <input type="date" name="start_date" value="{{ $start }}" class="form-control">
        </div>
        <div class="col-auto">
            <input type="date" name="end_date" value="{{ $end }}" class="form-control">
        </div>
        <div class="col-auto">
            <button class="btn btn-primary">Filter</button>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.reports.finance.export', ['start_date' => $start, 'end_date' => $end]) }}" class="btn btn-outline-secondary">Export CSV</a>
        </div>
    </form>

    <h4>Total Terkumpul: Rp{{ number_format($total,0,',','.') }}</h4>

    <h5 class="mt-3">Ringkasan per Kos</h5>
    <table class="table table-sm">
        <thead><tr><th>Kos</th><th>Total (Rp)</th></tr></thead>
        <tbody>
            @foreach($byKos as $k)
                <tr>
                    <td>{{ $k['nama'] }}</td>
                    <td>Rp{{ number_format($k['total'],0,',','.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h5 class="mt-4">Daftar Pembayaran</h5>
    <table class="table">
        <thead><tr><th>Tanggal</th><th>Kos</th><th>Kamar</th><th>Jumlah</th><th>Metode</th><th>Status</th></tr></thead>
        <tbody>
            @foreach($payments as $p)
                <tr>
                    <td>{{ $p->tanggal_bayar }}</td>
                    <td>{{ $p->kos_name }}</td>
                    <td>{{ $p->kamar_nomor }}</td>



                    <td>Rp{{ number_format($p->jumlah,0,',','.') }}</td>
                    <td>{{ ucfirst($p->metode) }}</td>
                    <td>{{ ucfirst($p->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
