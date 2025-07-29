<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PenggunaController;


// -------------------------------
// Auth
// -------------------------------
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

// -------------------------------
// Kendaraan
// -------------------------------
Route::get('/kendaraan', [KendaraanController::class, 'index']);
Route::post('/kendaraan', [KendaraanController::class, 'store']);
Route::post('/kendaraan/simpan', [KendaraanController::class, 'store']);
Route::get('/kendaraan/{id}', [KendaraanController::class, 'show']);
Route::put('/kendaraan/{id}', [KendaraanController::class, 'update']);
Route::delete('/kendaraan/{id}', [KendaraanController::class, 'destroy']);
Route::get('/gambar-kendaraan/{filename}', [KendaraanController::class, 'gambarKendaraan']);

// -------------------------------
// Pemesanan
// -------------------------------
Route::get('/pemesanan', [PemesananController::class, 'index']);
Route::post('/pemesanan/simpan', [PemesananController::class, 'simpan']);
Route::get('/pemesanan/{id}', [PemesananController::class, 'show']);
Route::get('/pemesanan/riwayat/{id_user}', [PemesananController::class, 'riwayat']);
Route::post('/pemesanan/update_status', [PemesananController::class, 'updateStatus']);

// -------------------------------
// Pembayaran
// -------------------------------
Route::get('/pembayaran', [PembayaranController::class, 'index']);
Route::post('/pembayaran/simpan', [PembayaranController::class, 'store']);
Route::post('/pembayaran/update-status', [PembayaranController::class, 'updateStatus']);
Route::get('/bukti-bayar/{filename}', [PembayaranController::class, 'buktiBayar']);

// -------------------------------
// User
// -------------------------------
Route::get('/pengguna', [UserController::class, 'index']);        // Read
Route::post('/pengguna', [UserController::class, 'store']);       // Create
Route::put('/pengguna/{id}', [UserController::class, 'update']);  // Update
Route::delete('/pengguna/{id}', [UserController::class, 'destroy']); // Delete
Route::get('/pengguna/email/{email}', [UserController::class, 'getByEmail']);



Route::post('/admin/login', [App\Http\Controllers\AdminAuthController::class, 'login']);
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index']);
Route::post('/admin', [App\Http\Controllers\AdminController::class, 'store']);
Route::put('/admin/{id}', [App\Http\Controllers\AdminController::class, 'update']);
Route::delete('/admin/{id}', [App\Http\Controllers\AdminController::class, 'destroy']);

