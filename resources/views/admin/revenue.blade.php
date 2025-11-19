@extends('layouts.admin')

@section('content')
<div class="col-md-10 mx-auto">
    <div class="card shadow">
        <div class="card-body">
            <h4 class="mb-4">Laporan Revenue Pemilik Kos</h4>
            <form method="GET" class="row g-2 mb-3">
                <div class="col-auto">
                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $start ?? '') }}" placeholder="Mulai">
                </div>
                <div class="col-auto">
                    <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $end ?? '') }}" placeholder="Sampai">
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary">Filter</button>
                    <a href="{{ route('admin.revenue') }}" class="btn btn-outline-secondary ms-1">Reset</a>
                </div>
            </form>

            @if($rows->isEmpty())
                <p>Tidak ada pembayaran lunas untuk dilaporkan.</p>
            @else
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Pemilik</th>
                            <th>Email</th>
                            <th>Total Payments</th>
                            <th>Total Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rows as $i => $r)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $r->pemilik_name }}</td>
                            <td>{{ $r->pemilik_email }}</td>
                            <td>{{ $r->total_payments }}</td>
                            <td>Rp {{ number_format($r->total_revenue, 2, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
