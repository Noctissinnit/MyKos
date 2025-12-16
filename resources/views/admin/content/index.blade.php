@extends('layouts.admin')

@section('content')
<style>
    .content-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 24px;
    }

    .content-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
        padding-bottom: 24px;
        border-bottom: 1px solid #e5e7eb;
    }

    .content-header h2 {
        margin: 0;
        font-size: 28px;
        font-weight: 600;
        color: #1f2937;
    }

    .content-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .content-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .content-card h3 {
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

    .btn-danger {
        background-color: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background-color: #dc2626;
    }

    .banner-section {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 24px;
    }

    .banner-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 16px;
        margin-top: 20px;
    }

    .banner-card {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        overflow: hidden;
        background: white;
    }

    .banner-image {
        width: 100%;
        height: 150px;
        object-fit: cover;
        background-color: #f3f4f6;
    }

    .banner-content {
        padding: 16px;
    }

    .banner-title {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .banner-description {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 12px;
    }

    .banner-actions {
        display: flex;
        gap: 8px;
    }

    .banner-status {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
    }

    .banner-active {
        background-color: #f0fdf4;
        color: #16a34a;
    }

    .banner-inactive {
        background-color: #fef2f2;
        color: #dc2626;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: white;
        margin: 5% auto;
        padding: 24px;
        border-radius: 12px;
        width: 90%;
        max-width: 500px;
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid #e5e7eb;
    }

    .modal-title {
        margin: 0;
        font-size: 20px;
        font-weight: 600;
        color: #1f2937;
    }

    .close {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #6b7280;
    }
</style>

<div class="content-container">
    <div class="content-header">
        <h2><i class="bi bi-file-earmark-text" style="margin-right: 12px;"></i>Manajemen Konten</h2>
    </div>

    @if(session('success'))
        <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px;">
            <i class="bi bi-check-circle" style="margin-right: 8px;"></i>{{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px;">
            <i class="bi bi-exclamation-circle" style="margin-right: 8px;"></i>{{ session('error') }}
        </div>
    @endif

    <!-- Landing Page Content -->
    <form method="POST" action="{{ route('admin.content.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="content-grid">
            <div class="content-card">
                <h3><i class="bi bi-house"></i>Halaman Utama</h3>

                <div class="form-group">
                    <label for="landing_title">Judul Utama</label>
                    <input type="text" id="landing_title" name="landing_title" class="form-control"
                           value="{{ old('landing_title', $content['landing_title']) }}" required>
                </div>

                <div class="form-group">
                    <label for="landing_subtitle">Subjudul</label>
                    <textarea id="landing_subtitle" name="landing_subtitle" class="form-control" rows="3" required>{{ old('landing_subtitle', $content['landing_subtitle']) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="landing_image">Gambar Landing Page</label>
                    <input type="file" id="landing_image" name="landing_image" class="form-control" accept="image/*">
                    <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB. Biarkan kosong jika tidak ingin mengubah.</small>
                    @if($content['landing_image'])
                        <div style="margin-top: 10px;">
                            <img src="{{ asset($content['landing_image']) }}" alt="Current landing image" style="max-width: 200px; max-height: 150px; border: 1px solid #e5e7eb; border-radius: 8px;">
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="about_content">Konten Tentang</label>
                    <textarea id="about_content" name="about_content" class="form-control" rows="5" required>{{ old('about_content', $content['about_content']) }}</textarea>
                </div>
            </div>

            <div class="content-card">
                <h3><i class="bi bi-telephone"></i>Kontak & Sosial Media</h3>

                <div class="form-group">
                    <label for="contact_email">Email Kontak</label>
                    <input type="email" id="contact_email" name="contact_email" class="form-control"
                           value="{{ old('contact_email', $content['contact_email']) }}" required>
                </div>

                <div class="form-group">
                    <label for="contact_phone">Nomor Telepon</label>
                    <input type="text" id="contact_phone" name="contact_phone" class="form-control"
                           value="{{ old('contact_phone', $content['contact_phone']) }}" required>
                </div>

                <div class="form-group">
                    <label for="social_facebook">Facebook URL</label>
                    <input type="url" id="social_facebook" name="social_facebook" class="form-control"
                           value="{{ old('social_facebook', $content['social_facebook']) }}" placeholder="https://facebook.com/...">
                </div>

                <div class="form-group">
                    <label for="social_instagram">Instagram URL</label>
                    <input type="url" id="social_instagram" name="social_instagram" class="form-control"
                           value="{{ old('social_instagram', $content['social_instagram']) }}" placeholder="https://instagram.com/...">
                </div>

                <div class="form-group">
                    <label for="social_twitter">Twitter URL</label>
                    <input type="url" id="social_twitter" name="social_twitter" class="form-control"
                           value="{{ old('social_twitter', $content['social_twitter']) }}" placeholder="https://twitter.com/...">
                </div>

                <div class="form-group">
                    <label for="footer_text">Teks Footer</label>
                    <input type="text" id="footer_text" name="footer_text" class="form-control"
                           value="{{ old('footer_text', $content['footer_text']) }}" required>
                </div>
            </div>
        </div>

        <div style="text-align: center; margin-bottom: 32px;">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i>Simpan Perubahan
            </button>
        </div>
    </form>

    <!-- Banner Management -->
    <div class="banner-section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin: 0;"><i class="bi bi-images"></i>Manajemen Banner</h3>
            <button onclick="openModal('addBannerModal')" class="btn btn-success">
                <i class="bi bi-plus"></i>Tambah Banner
            </button>
        </div>

        <div class="banner-grid">
            @forelse($content['banners'] as $banner)
                <div class="banner-card">
                    <img src="{{ $banner['image'] ? asset('storage/' . $banner['image']) : asset('img/placeholder-banner.jpg') }}"
                         alt="{{ $banner['title'] }}" class="banner-image">
                    <div class="banner-content">
                        <div class="banner-title">{{ $banner['title'] }}</div>
                        <div class="banner-description">{{ Str::limit($banner['description'], 50) }}</div>
                        <div class="banner-status {{ $banner['is_active'] ? 'banner-active' : 'banner-inactive' }}">
                            <i class="bi bi-{{ $banner['is_active'] ? 'check-circle' : 'x-circle' }}"></i>
                            {{ $banner['is_active'] ? 'Aktif' : 'Tidak Aktif' }}
                        </div>
                        <div class="banner-actions" style="margin-top: 12px;">
                            <button onclick="editBanner('{{ $banner['id'] }}')" class="btn btn-secondary btn-sm">
                                <i class="bi bi-pencil"></i>Edit
                            </button>
                            <form method="POST" action="{{ route('admin.content.banners.delete', $banner['id']) }}"
                                  style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus banner ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 48px; color: #6b7280;">
                    <i class="bi bi-images" style="font-size: 48px; margin-bottom: 16px; display: block;"></i>
                    <p>Belum ada banner. Klik "Tambah Banner" untuk menambah banner baru.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Add Banner Modal -->
<div id="addBannerModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Tambah Banner Baru</h3>
            <span class="close" onclick="closeModal('addBannerModal')">&times;</span>
        </div>
        <form method="POST" action="{{ route('admin.content.banners.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="banner_title">Judul Banner</label>
                <input type="text" id="banner_title" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="banner_description">Deskripsi</label>
                <textarea id="banner_description" name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="banner_image">Gambar Banner</label>
                <input type="file" id="banner_image" name="image" class="form-control" accept="image/*" required>
                <small style="color: #6b7280;">Format: JPG, PNG, GIF. Maksimal 2MB.</small>
            </div>
            <div class="form-group">
                <label for="banner_link">Link (Opsional)</label>
                <input type="url" id="banner_link" name="link" class="form-control" placeholder="https://...">
            </div>
            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 8px;">
                    <input type="checkbox" name="is_active" value="1" checked>
                    Banner Aktif
                </label>
            </div>
            <div style="text-align: right;">
                <button type="button" onclick="closeModal('addBannerModal')" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Banner</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Banner Modal -->
<div id="editBannerModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Edit Banner</h3>
            <span class="close" onclick="closeModal('editBannerModal')">&times;</span>
        </div>
        <form id="editBannerForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit_banner_title">Judul Banner</label>
                <input type="text" id="edit_banner_title" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="edit_banner_description">Deskripsi</label>
                <textarea id="edit_banner_description" name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="edit_banner_image">Gambar Banner (Opsional)</label>
                <input type="file" id="edit_banner_image" name="image" class="form-control" accept="image/*">
                <small style="color: #6b7280;">Biarkan kosong jika tidak ingin mengubah gambar. Format: JPG, PNG, GIF. Maksimal 2MB.</small>
            </div>
            <div class="form-group">
                <label for="edit_banner_link">Link (Opsional)</label>
                <input type="url" id="edit_banner_link" name="link" class="form-control" placeholder="https://...">
            </div>
            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 8px;">
                    <input type="checkbox" id="edit_banner_active" name="is_active" value="1">
                    Banner Aktif
                </label>
            </div>
            <div style="text-align: right;">
                <button type="button" onclick="closeModal('editBannerModal')" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary">Update Banner</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(modalId) {
    document.getElementById(modalId).style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

function editBanner(bannerId) {
    // In a real implementation, you would fetch banner data via AJAX
    // For now, we'll use a simple approach
    openModal('editBannerModal');
    document.getElementById('editBannerForm').action = `/admin/content/banners/${bannerId}`;
}

// Close modal when clicking outside
window.onclick = function(event) {
    if (event.target.className === 'modal') {
        event.target.style.display = 'none';
    }
}
</script>
@endsection