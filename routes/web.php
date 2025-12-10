<?php

use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Pemilik\KamarController;
use App\Http\Controllers\Pemilik\KosController;
use App\Http\Controllers\Pemilik\ReportController as PemilikReportController;
use App\Http\Controllers\PemilikController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Pemilik\RoomTypeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Public routes: allow guests to browse kos and room types without logging in
Route::get('/cari-kos', [\App\Http\Controllers\RentalRequestController::class, 'index'])->name('user.kos.index');
// Landing page (optional home/marketing page)
Route::get('/', function () { return view('landing'); })->name('landing');
Route::get('/kos/{kos}/room-types', [\App\Http\Controllers\RentalRequestController::class, 'roomTypes'])->name('user.kos.room_types');
Route::get('/kos/{kos}/kamars', [\App\Http\Controllers\RentalRequestController::class, 'kamars'])->name('user.kos.kamars');

Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware(['auth', 'notbanned', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Admin: ban/unban user
    Route::post('/admin/users/{id}/ban', [AdminController::class, 'banUser'])->name('admin.user.ban');
    Route::post('/admin/users/{id}/unban', [AdminController::class, 'unbanUser'])->name('admin.user.unban');
    
    // Admin: approve/reject kos applications
    Route::post('/admin/kos/{id}/approve', [AdminController::class, 'approveKos'])->name('admin.kos.approve');
    Route::post('/admin/kos/{id}/reject', [AdminController::class, 'rejectKos'])->name('admin.kos.reject');
    
    // Admin: list pending kos applications
    Route::get('/admin/kos-applications', [AdminController::class, 'kosApplications'])->name('admin.kos.applications');
    
    // Admin: revenue report
    Route::get('/admin/revenue', [AdminController::class, 'revenueReport'])->name('admin.revenue');
    // Admin: finance report
    Route::get('/admin/reports/finance', [\App\Http\Controllers\Admin\ReportController::class, 'finance'])->name('admin.reports.finance');
    Route::get('/admin/reports/finance/export', [\App\Http\Controllers\Admin\ReportController::class, 'exportCsv'])->name('admin.reports.finance.export');
});

// Admin: manage users list
Route::middleware(['auth', 'notbanned', 'role:admin'])->group(function () {
    Route::get('/admin/users', [AdminController::class, 'usersList'])->name('admin.users.index');
});

Route::middleware(['auth', 'notbanned', 'role:pemilik'])->name('pemilik.')->group(function () {
    Route::get('/pemilik/dashboard', [PemilikController::class, 'index'])->name('dashboard');

    // Room types (tipe kamar) management - per kos
    Route::get('/pemilik/kos/{kos_id}/room-types', [RoomTypeController::class, 'index'])->name('room_types.index');
    Route::get('/pemilik/kos/{kos_id}/room-types/create', [RoomTypeController::class, 'create'])->name('room_types.create');
    Route::post('/pemilik/room-types', [RoomTypeController::class, 'store'])->name('room_types.store');
    Route::get('/pemilik/room-types/{roomType}/edit', [RoomTypeController::class, 'edit'])->name('room_types.edit');
    Route::put('/pemilik/room-types/{roomType}', [RoomTypeController::class, 'update'])->name('room_types.update');
    Route::delete('/pemilik/room-types/{roomType}', [RoomTypeController::class, 'destroy'])->name('room_types.destroy');

    // CRUD Kos
    Route::get('/kos', [KosController::class, 'index'])->name('kos.index');
    Route::get('/kos/create', [KosController::class, 'create'])->name('kos.create');
    Route::post('/kos', [KosController::class, 'store'])->name('kos.store');
    Route::get('/kos/{id}/edit', [KosController::class, 'edit'])->name('kos.edit');
    Route::put('/kos/{id}', [KosController::class, 'update'])->name('kos.update');
    Route::delete('/kos/{id}', [KosController::class, 'destroy'])->name('kos.destroy');

    // CRUD Kamar
    Route::get('/kos/{kos_id}/kamar', [KamarController::class, 'index'])->name('kamar.index');
    Route::get('/kos/{kos_id}/kamar/create', [KamarController::class, 'create'])->name('kamar.create');
    Route::post('/kos/{kos_id}/kamar', [KamarController::class, 'store'])->name('kamar.store');
    Route::get('/kos/{kos_id}/kamar/{id}/edit', [KamarController::class, 'edit'])->name('kamar.edit');
    Route::put('/kos/{kos_id}/kamar/{id}', [KamarController::class, 'update'])->name('kamar.update');
    Route::delete('/kos/{kos_id}/kamar/{id}', [KamarController::class, 'destroy'])->name('kamar.destroy');
    
    // Kamar Photos
    Route::get('/kos/{kos_id}/kamar/{id}/photos', [KamarController::class, 'editPhotos'])->name('kamar.edit.photos');
    Route::post('/kos/{kos_id}/kamar/{id}/photos', [KamarController::class, 'uploadPhoto'])->name('kamar.upload.photo');
    Route::delete('/kos/{kos_id}/kamar/{id}/photos/{photo_id}', [KamarController::class, 'deletePhoto'])->name('kamar.delete.photo');
    Route::post('/kos/{kos_id}/kamar/{id}/photos/{photo_id}/primary', [KamarController::class, 'setPrimaryPhoto'])->name('kamar.set.primary.photo');
    
    // Kamar Facilities
    Route::get('/kos/{kos_id}/kamar/{id}/facilities', [KamarController::class, 'editFacilities'])->name('kamar.edit.facilities');
    Route::post('/kos/{kos_id}/kamar/{id}/facilities', [KamarController::class, 'addFacility'])->name('kamar.add.facility');
    Route::delete('/kos/{kos_id}/kamar/{id}/facilities/{facility_id}', [KamarController::class, 'deleteFacility'])->name('kamar.delete.facility');

    // Pemilik: rental requests management
    Route::get('/pemilik/rental-requests', [\App\Http\Controllers\Pemilik\RentalRequestController::class, 'index'])->name('rental_requests.index');
    Route::get('/pemilik/rental-requests/{rentalRequest}', [\App\Http\Controllers\Pemilik\RentalRequestController::class, 'show'])->name('rental_requests.show');
    Route::post('/pemilik/rental-requests/{rentalRequest}/approve', [\App\Http\Controllers\Pemilik\RentalRequestController::class, 'approve'])->name('rental_requests.approve');
    Route::post('/pemilik/rental-requests/{rentalRequest}/reject', [\App\Http\Controllers\Pemilik\RentalRequestController::class, 'reject'])->name('rental_requests.reject');
    // Pemilik: verify payment proof
    Route::post('/pemilik/pembayarans/{pembayaran}/verify', [\App\Http\Controllers\Pemilik\PaymentController::class, 'verify'])->name('pembayarans.verify');
    
    // Pemilik: daftar kamar gabungan (semua kamar milik pemilik)
    Route::get('/pemilik/kamars', [KamarController::class, 'all'])->name('kamars.index');
    // Pemilik: finance report
    Route::get('/pemilik/reports/finance', [\App\Http\Controllers\Pemilik\ReportController::class, 'finance'])->name('reports.finance');
    Route::get('/pemilik/reports/finance/export', [\App\Http\Controllers\Pemilik\ReportController::class, 'exportCsv'])->name('reports.finance.export');
    Route::get('pemilik/reports/transactions', [PemilikReportController::class, 'transaksi'])
     ->name('reports.transactions');
});

Route::middleware(['auth', 'notbanned', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    
    // User: browse kos and room types, submit rental requests
    // Booking routes (require authentication)
    Route::get('/user/kos/{kos}/kamars/{kamar}/rent', [\App\Http\Controllers\RentalRequestController::class, 'createForKamar'])->name('user.rental_requests.create_kamar');
    Route::get('/user/kos/{kos}/room-types/{roomType}/rent', [\App\Http\Controllers\RentalRequestController::class, 'create'])->name('user.rental_requests.create');
    Route::post('/user/rental-requests', [\App\Http\Controllers\RentalRequestController::class, 'store'])->name('user.rental_requests.store');
    Route::get('/user/rental-requests', [\App\Http\Controllers\RentalRequestController::class, 'myRequests'])->name('user.rental_requests.index');
    Route::get('/user/rental-requests/{rentalRequest}/upload-proof', [\App\Http\Controllers\PaymentController::class, 'uploadForRentalRequest'])->name('user.rental_requests.upload_proof');

    // User: payments
    Route::get('/user/pembayarans', [\App\Http\Controllers\PaymentController::class, 'index'])->name('user.pembayarans.index');
    Route::get('/user/pembayarans/create/{penghuni}', [\App\Http\Controllers\PaymentController::class, 'create'])->name('user.pembayarans.create');
    Route::post('/user/pembayarans', [\App\Http\Controllers\PaymentController::class, 'store'])->name('user.pembayarans.store');
});