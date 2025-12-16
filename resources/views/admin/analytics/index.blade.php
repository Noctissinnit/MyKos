@extends('layouts.admin')

@section('content')
<style>
    .analytics-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 24px;
    }

    .analytics-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
        padding-bottom: 24px;
        border-bottom: 1px solid #e5e7eb;
    }

    .analytics-header h2 {
        margin: 0;
        font-size: 28px;
        font-weight: 600;
        color: #1f2937;
    }

    .period-selector {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .period-selector label {
        font-weight: 500;
        color: #374151;
    }

    .period-selector select {
        padding: 8px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        background: white;
        font-size: 14px;
    }

    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }

    .metric-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border-left: 4px solid #4a6fa5;
    }

    .metric-card.success {
        border-left-color: #10b981;
    }

    .metric-card.warning {
        border-left-color: #f59e0b;
    }

    .metric-card.danger {
        border-left-color: #ef4444;
    }

    .metric-title {
        font-size: 14px;
        color: #6b7280;
        font-weight: 500;
        margin-bottom: 8px;
    }

    .metric-value {
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .metric-change {
        font-size: 12px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .metric-change.positive {
        color: #10b981;
    }

    .metric-change.negative {
        color: #ef4444;
    }

    .charts-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .chart-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .chart-card h3 {
        margin: 0 0 20px 0;
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .chart-container {
        position: relative;
        height: 300px;
    }

    .top-data-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .top-data-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .top-data-card h3 {
        margin: 0 0 20px 0;
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .top-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .top-item:last-child {
        border-bottom: none;
    }

    .top-item-name {
        font-weight: 500;
        color: #1f2937;
    }

    .top-item-value {
        font-weight: 600;
        color: #4a6fa5;
    }

    .activities-section {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .activities-section h3 {
        margin: 0 0 20px 0;
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        padding: 16px 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .activity-icon.success {
        background-color: #f0fdf4;
        color: #10b981;
    }

    .activity-icon.primary {
        background-color: #eff6ff;
        color: #4a6fa5;
    }

    .activity-icon.warning {
        background-color: #fffbeb;
        color: #f59e0b;
    }

    .activity-content {
        flex: 1;
    }

    .activity-title {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .activity-description {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 4px;
    }

    .activity-time {
        font-size: 12px;
        color: #9ca3af;
    }
</style>

<div class="analytics-container">
    <div class="analytics-header">
        <h2><i class="bi bi-graph-up" style="margin-right: 12px;"></i>Analytics Dashboard</h2>
        <div class="period-selector">
            <label for="period">Periode:</label>
            <select id="period" onchange="changePeriod(this.value)">
                <option value="7" {{ $period == 7 ? 'selected' : '' }}>7 Hari</option>
                <option value="30" {{ $period == 30 ? 'selected' : '' }}>30 Hari</option>
                <option value="90" {{ $period == 90 ? 'selected' : '' }}>90 Hari</option>
                <option value="365" {{ $period == 365 ? 'selected' : '' }}>1 Tahun</option>
            </select>
        </div>
    </div>

    <!-- Key Metrics -->
    <div class="metrics-grid">
        <div class="metric-card">
            <div class="metric-title">Total Pengguna</div>
            <div class="metric-value">{{ number_format($metrics['total_users']) }}</div>
            <div class="metric-change positive">
                <i class="bi bi-arrow-up"></i>
                +{{ number_format($metrics['new_users_period']) }} bulan ini
            </div>
        </div>

        <div class="metric-card success">
            <div class="metric-title">Total Kos</div>
            <div class="metric-value">{{ number_format($metrics['total_kos']) }}</div>
            <div class="metric-change positive">
                <i class="bi bi-arrow-up"></i>
                +{{ number_format($metrics['new_kos_period']) }} bulan ini
            </div>
        </div>

        <div class="metric-card warning">
            <div class="metric-title">Total Pendapatan</div>
            <div class="metric-value">Rp {{ number_format($metrics['total_revenue'], 0, ',', '.') }}</div>
            <div class="metric-change positive">
                <i class="bi bi-arrow-up"></i>
                Rp {{ number_format($metrics['revenue_period'], 0, ',', '.') }} bulan ini
            </div>
        </div>

        <div class="metric-card danger">
            <div class="metric-title">Tingkat Konversi</div>
            <div class="metric-value">{{ $metrics['conversion_rate'] }}%</div>
            <div class="metric-change">
                <i class="bi bi-dash"></i>
                Permintaan → Approval
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="charts-section">
        <div class="chart-card">
            <h3><i class="bi bi-person-plus"></i>Registrasi Pengguna</h3>
            <div class="chart-container">
                <canvas id="userChart"></canvas>
            </div>
        </div>

        <div class="chart-card">
            <h3><i class="bi bi-cash"></i>Tren Pendapatan</h3>
            <div class="chart-container">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Performing Data -->
    <div class="top-data-section">
        <div class="top-data-card">
            <h3><i class="bi bi-trophy"></i>Top 5 Kos Terlaris</h3>
            @forelse($topData['top_kos'] as $kos)
                <div class="top-item">
                    <div class="top-item-name">{{ $kos->nama }}</div>
                    <div class="top-item-value">Rp {{ number_format($kos->total_revenue, 0, ',', '.') }}</div>
                </div>
            @empty
                <p style="color: #6b7280; text-align: center; padding: 20px;">Belum ada data kos</p>
            @endforelse
        </div>

        <div class="top-data-card">
            <h3><i class="bi bi-star"></i>Top 5 Pemilik Terbaik</h3>
            @forelse($topData['top_pemilik'] as $pemilik)
                <div class="top-item">
                    <div class="top-item-name">{{ $pemilik->name }}</div>
                    <div class="top-item-value">Rp {{ number_format($pemilik->total_revenue, 0, ',', '.') }}</div>
                </div>
            @empty
                <p style="color: #6b7280; text-align: center; padding: 20px;">Belum ada data pemilik</p>
            @endforelse
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="activities-section">
        <h3><i class="bi bi-activity"></i>Aktivitas Terbaru</h3>
        @forelse($activities as $activity)
            <div class="activity-item">
                <div class="activity-icon {{ $activity['color'] }}">
                    <i class="bi {{ $activity['icon'] }}"></i>
                </div>
                <div class="activity-content">
                    <div class="activity-title">{{ $activity['title'] }}</div>
                    <div class="activity-description">{{ $activity['description'] }}</div>
                    <div class="activity-time">{{ $activity['time'] }}</div>
                </div>
            </div>
        @empty
            <p style="color: #6b7280; text-align: center; padding: 20px;">Belum ada aktivitas</p>
        @endforelse
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// User Registration Chart
const userCtx = document.getElementById('userChart').getContext('2d');
new Chart(userCtx, {
    type: 'line',
    data: {
        labels: @json($charts['date_labels']),
        datasets: [{
            label: 'Registrasi Pengguna',
            data: @json(array_values($charts['user_registrations'])),
            borderColor: '#4a6fa5',
            backgroundColor: 'rgba(74, 111, 165, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

// Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
new Chart(revenueCtx, {
    type: 'bar',
    data: {
        labels: @json($charts['date_labels']),
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: @json(array_values($charts['payment_trend'])),
            backgroundColor: '#10b981',
            borderColor: '#059669',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

function changePeriod(period) {
    window.location.href = '{{ route("admin.analytics.index") }}?period=' + period;
}
</script>
@endsection