@extends('layouts.admin')

@section('content')
<style>
    .settings-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 24px;
    }

    .settings-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
        padding-bottom: 24px;
        border-bottom: 1px solid #e5e7eb;
    }

    .settings-header h2 {
        margin: 0;
        font-size: 28px;
        font-weight: 600;
        color: #1f2937;
    }

    .settings-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .settings-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .settings-card h3 {
        margin: 0 0 20px 0;
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: 500;
        color: #374151;
        margin-bottom: 6px;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-family: inherit;
        font-size: 14px;
        background: white;
        resize: vertical;
    }

    .form-control:focus {
        outline: none;
        border-color: #4a6fa5;
        box-shadow: 0 0 0 3px rgba(74, 111, 165, 0.1);
    }

    .checkbox-group {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 8px;
    }

    .checkbox-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .checkbox-item input[type="checkbox"] {
        margin: 0;
    }

    .btn {
        padding: 10px 18px;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background-color: #4a6fa5;
        color: white;
    }

    .btn-primary:hover {
        background-color: #3a5a8f;
    }

    .btn-secondary {
        background-color: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #4b5563;
    }

    .btn-success {
        background-color: #10b981;
        color: white;
    }

    .btn-success:hover {
        background-color: #059669;
    }

    .btn-warning {
        background-color: #f59e0b;
        color: white;
    }

    .btn-warning:hover {
        background-color: #d97706;
    }

    .actions-section {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 24px;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 16px;
    }

    .action-card {
        padding: 20px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        text-align: center;
        transition: all 0.2s;
    }

    .action-card:hover {
        border-color: #4a6fa5;
        background-color: #f8fafc;
    }

    .action-card i {
        font-size: 24px;
        color: #4a6fa5;
        margin-bottom: 8px;
    }

    .action-card h4 {
        margin: 0 0 8px 0;
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
    }

    .action-card p {
        margin: 0;
        font-size: 14px;
        color: #6b7280;
    }

    .maintenance-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
    }

    .maintenance-active {
        background-color: #fef2f2;
        color: #dc2626;
    }

    .maintenance-inactive {
        background-color: #f0fdf4;
        color: #16a34a;
    }
</style>

<div class="settings-container">
    <div class="settings-header">
        <h2><i class="bi bi-gear" style="margin-right: 12px;"></i>Pengaturan Sistem</h2>
        <div class="maintenance-status {{ $settings['maintenance_mode'] ? 'maintenance-active' : 'maintenance-inactive' }}">
            <i class="bi bi-{{ $settings['maintenance_mode'] ? 'exclamation-triangle' : 'check-circle' }}"></i>
            {{ $settings['maintenance_mode'] ? 'Maintenance Mode' : 'System Normal' }}
        </div>
    </div>

    @if(session('success'))
        <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px;">
            <i class="bi bi-check-circle" style="margin-right: 8px;"></i>{{ session('success') }}
        </div>
    @endif

    @if(session('info'))
        <div style="background-color: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px;">
            <i class="bi bi-info-circle" style="margin-right: 8px;"></i>{{ session('info') }}
        </div>
    @endif

    <!-- General Settings -->
    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf
        <div class="settings-grid">
            <div class="settings-card">
                <h3><i class="bi bi-app"></i>Pengaturan Umum</h3>

                <div class="form-group">
                    <label for="app_name">Nama Aplikasi</label>
                    <input type="text" id="app_name" name="app_name" class="form-control"
                           value="{{ old('app_name', $settings['app_name']) }}" required>
                </div>

                <div class="form-group">
                    <label for="app_description">Deskripsi Aplikasi</label>
                    <textarea id="app_description" name="app_description" class="form-control" rows="3" required>{{ old('app_description', $settings['app_description']) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="app_email">Email Sistem</label>
                    <input type="email" id="app_email" name="app_email" class="form-control"
                           value="{{ old('app_email', $settings['app_email']) }}" required>
                </div>
            </div>

            <div class="settings-card">
                <h3><i class="bi bi-globe"></i>Pengaturan Regional</h3>

                <div class="form-group">
                    <label for="timezone">Timezone</label>
                    <select id="timezone" name="timezone" class="form-control" required>
                        <option value="Asia/Jakarta" {{ $settings['timezone'] == 'Asia/Jakarta' ? 'selected' : '' }}>Asia/Jakarta (WIB)</option>
                        <option value="Asia/Makassar" {{ $settings['timezone'] == 'Asia/Makassar' ? 'selected' : '' }}>Asia/Makassar (WITA)</option>
                        <option value="Asia/Jayapura" {{ $settings['timezone'] == 'Asia/Jayapura' ? 'selected' : '' }}>Asia/Jayapura (WIT)</option>
                        <option value="UTC" {{ $settings['timezone'] == 'UTC' ? 'selected' : '' }}>UTC</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="locale">Bahasa</label>
                    <select id="locale" name="locale" class="form-control" required>
                        <option value="id" {{ $settings['locale'] == 'id' ? 'selected' : '' }}>Bahasa Indonesia</option>
                        <option value="en" {{ $settings['locale'] == 'en' ? 'selected' : '' }}>English</option>
                    </select>
                </div>
            </div>

            <div class="settings-card">
                <h3><i class="bi bi-cash"></i>Pengaturan Pembayaran</h3>

                <div class="form-group">
                    <label for="commission_rate">Komisi Platform (%)</label>
                    <input type="number" id="commission_rate" name="commission_rate" class="form-control"
                           value="{{ old('commission_rate', $settings['commission_rate']) }}" min="0" max="100" step="0.1" required>
                    <small style="color: #6b7280; font-size: 12px;">Persentase komisi yang diambil dari setiap transaksi</small>
                </div>

                <div class="form-group">
                    <label>Metode Pembayaran</label>
                    <div class="checkbox-group">
                        <label class="checkbox-item">
                            <input type="checkbox" name="payment_methods[]" value="transfer"
                                   {{ in_array('transfer', old('payment_methods', $settings['payment_methods'])) ? 'checked' : '' }}>
                            Transfer Bank
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="payment_methods[]" value="cash"
                                   {{ in_array('cash', old('payment_methods', $settings['payment_methods'])) ? 'checked' : '' }}>
                            Tunai
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="payment_methods[]" value="ewallet"
                                   {{ in_array('ewallet', old('payment_methods', $settings['payment_methods'])) ? 'checked' : '' }}>
                            E-Wallet
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div style="text-align: center; margin-bottom: 32px;">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i>Simpan Pengaturan
            </button>
        </div>
    </form>

    <!-- System Actions -->
    <div class="actions-section">
        <h3 style="margin-bottom: 20px;"><i class="bi bi-tools"></i>Aksi Sistem</h3>

        <div class="actions-grid">
            <div class="action-card">
                <i class="bi bi-arrow-clockwise"></i>
                <h4>Bersihkan Cache</h4>
                <p>Hapus cache konfigurasi, route, dan view untuk memperbarui perubahan</p>
                <form method="POST" action="{{ route('admin.settings.clear-cache') }}" style="margin-top: 12px;">
                    @csrf
                    <button type="submit" class="btn btn-secondary" style="width: 100%;">
                        <i class="bi bi-arrow-clockwise"></i>Bersihkan Cache
                    </button>
                </form>
            </div>

            <div class="action-card">
                <i class="bi bi-{{ $settings['maintenance_mode'] ? 'play-circle' : 'pause-circle' }}"></i>
                <h4>{{ $settings['maintenance_mode'] ? 'Nonaktifkan' : 'Aktifkan' }} Maintenance</h4>
                <p>{{ $settings['maintenance_mode'] ? 'Kembalikan sistem ke mode normal' : 'Masukkan sistem ke mode maintenance' }}</p>
                <form method="POST" action="{{ route('admin.settings.maintenance') }}" style="margin-top: 12px;">
                    @csrf
                    <input type="hidden" name="secret" value="maintenance-secret">
                    <input type="hidden" name="message" value="Sistem sedang dalam perbaikan. Silakan coba lagi nanti.">
                    <button type="submit" class="btn {{ $settings['maintenance_mode'] ? 'btn-success' : 'btn-warning' }}" style="width: 100%;">
                        <i class="bi bi-{{ $settings['maintenance_mode'] ? 'play' : 'pause' }}"></i>
                        {{ $settings['maintenance_mode'] ? 'Nonaktifkan' : 'Aktifkan' }} Maintenance
                    </button>
                </form>
            </div>

            <div class="action-card">
                <i class="bi bi-download"></i>
                <h4>Backup Database</h4>
                <p>Buat cadangan database untuk keamanan data</p>
                <form method="POST" action="{{ route('admin.settings.backup') }}" style="margin-top: 12px;">
                    @csrf
                    <button type="submit" class="btn btn-secondary" style="width: 100%;">
                        <i class="bi bi-download"></i>Backup Database
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection