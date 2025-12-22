<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PembudidayaController; 
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

// --- AUTHENTICATION ROUTES ---

// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

// OTP Registrasi
Route::get('/verify-otp/{id}', [AuthController::class, 'showOtpForm'])->name('otp.verify');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('otp.process');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- PASSWORD RESET ROUTES ---

// 1. Form Lupa Password
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');

// 2. Input OTP Reset Password
Route::get('/reset-password/verify/{id}', function ($id) {
    $user = App\Models\User::find($id);
    // Kita reuse view verify-otp tapi kirim flag is_reset
    return view('auth.verify-otp', compact('user'))->with('is_reset', true); 
})->name('password.otp');

// 3. Proses Cek OTP Reset
Route::post('/reset-password/verify', [AuthController::class, 'verifyOtpForReset'])->name('password.otp.process');

// 4. Form Password Baru
Route::get('/reset-password/new/{id}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset.form');
Route::post('/reset-password/new', [AuthController::class, 'updatePassword'])->name('password.update');


// --- DASHBOARD ROUTES (Agar tidak 404 setelah login) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/pembudidaya/dashboard', function () {
        return "Halo Pembudidaya! Login Berhasil."; // Ganti dengan view nanti
    });
    Route::get('/admin/dashboard', function () {
        return "Halo Admin!";
    });
    // Route::get('/petugas/dashboard', function () {
    //     return "Halo Petugas!";
    // });
});

// Update bagian Dashboard Pembudidaya di web.php

Route::middleware(['auth'])->group(function () {
    
    // Group Prefix URL Pembudidaya
    Route::prefix('pembudidaya')->name('pembudidaya.')->group(function() {
        
        // 1. Dashboard & Profil
        Route::get('/dashboard', [PembudidayaController::class, 'dashboard'])->name('dashboard');
        Route::get('/profil', [PembudidayaController::class, 'profil'])->name('profil');
        Route::post('/profil/update', [PembudidayaController::class, 'updateProfil'])->name('profil.update');
        
        // 2. Bantuan
        Route::get('/ajukan', [PembudidayaController::class, 'ajukanBantuan'])->name('ajukan');
        Route::post('/ajukan', [PembudidayaController::class, 'storeBantuan'])->name('ajukan.store');
        
        Route::get('/status', [PembudidayaController::class, 'statusLacak'])->name('status');
        
        Route::get('/penerimaan', [PembudidayaController::class, 'penerimaan'])->name('penerimaan');
        Route::post('/penerimaan', [PembudidayaController::class, 'storeKonfirmasi'])->name('penerimaan.store');
        
        // 3. Pendampingan
        Route::get('/pendampingan-ajukan', [PembudidayaController::class, 'ajukanPendampingan'])->name('pendampingan.ajukan');
        Route::post('/pendampingan-ajukan', [PembudidayaController::class, 'storePendampingan'])->name('pendampingan.store');
        
        Route::get('/pendampingan-jadwal', [PembudidayaController::class, 'jadwalFeedback'])->name('pendampingan.jadwal');
        Route::post('/pendampingan-feedback', [PembudidayaController::class, 'storeFeedback'])->name('pendampingan.feedback');
    });

});

Route::middleware(['auth'])->group(function () {

    // ROUTE PETUGAS UPT
    Route::prefix('petugas')->name('petugas.')->group(function() {
        Route::get('/verifikasi-budidaya', [PetugasController::class, 'verifikasiBudidaya'])->name('verifikasi');
        // Halaman Daftar Detail (setelah klik Mulai Verifikasi)
        Route::get('/verifikasi-budidaya/list', [PetugasController::class, 'listVerifikasiData'])->name('verifikasi.list');
        Route::post('/verifikasi/store', [PetugasController::class, 'storeVerifikasi'])->name('verifikasi.store');
        Route::get('/validasi-usaha/list', [PetugasController::class, 'listValidasiUsaha'])->name('validasi.list');
        Route::get('/jadwal-survei/list', [PetugasController::class, 'listJadwalSurvei'])->name('survei.list');
        Route::get('/verifikasi-bantuan', [PetugasController::class, 'verifikasiBantuan'])->name('bantuan.index');
        Route::get('/verifikasi-bantuan/list', [PetugasController::class, 'listKelayakanBantuan'])->name('bantuan.list');
        Route::get('/verifikasi-bantuan/detail/{id}', [PetugasController::class, 'detailVerifikasiBantuan'])->name('bantuan.detail');
        Route::post('/verifikasi-bantuan/selesai', [PetugasController::class, 'storeHasilVerifikasiDokumen'])->name('bantuan.selesai');
        Route::post('/verifikasi-bantuan/kelayakan', [PetugasController::class, 'storeKelayakanBantuan'])->name('bantuan.kelayakan');
        Route::get('/verifikasi-bantuan/dokumen', [PetugasController::class, 'listVerifikasiDokumen'])->name('bantuan.dokumen.list');
        Route::get('/verifikasi-bantuan/dokumen/{id}', [PetugasController::class, 'detailVerifikasiDokumen'])->name('bantuan.dokumen.detail');
        Route::post('/verifikasi-bantuan/dokumen/store', [PetugasController::class, 'storeVerifikasiDokumen'])->name('bantuan.dokumen.store');
        Route::get('/penyaluran', [PetugasController::class, 'penyaluranIndex'])->name('penyaluran.index');
        Route::post('/penyaluran/store', [PetugasController::class, 'storePenyaluran'])->name('penyaluran.store');
        Route::post('/penyaluran/upload-bast', [PetugasController::class, 'uploadBAST'])->name('penyaluran.bast');
        Route::get('/monitoring', [PetugasController::class, 'monitoringIndex'])->name('monitoring.index');
        Route::post('/monitoring/store', [PetugasController::class, 'storeJadwalMonitoring'])->name('monitoring.store');
        Route::get('/pendampingan/daftar', [PetugasController::class, 'daftarPendampingan'])->name('pendampingan.index');
        Route::get('/pendampingan/input', [PetugasController::class, 'inputHasilPendampingan'])->name('pendampingan.input');
        Route::post('/pendampingan/jadwal/store', [PetugasController::class, 'storeJadwalPendampingan'])->name('pendampingan.storeJadwal');
        Route::get('/pendampingan/detail/{id}', [PetugasController::class, 'detailPendampingan'])->name('pendampingan.detail');
        Route::post('/pendampingan/input/store', [PetugasController::class, 'storeHasilPendampingan'])->name('pendampingan.store');
        Route::post('/verifikasi/jadwal/store', [PetugasController::class, 'storeJadwalSurvei'])->name('jadwal.store');
        Route::post('/verifikasi/jadwal/cancel', [PetugasController::class, 'cancelJadwalSurvei'])->name('jadwal.cancel');
    });

});

Route::middleware(['auth'])->group(function () {
    // Prefix URL /admin/
    Route::prefix('admin')->name('admin.')->group(function() {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        
        // Rute placeholder untuk menu lainnya sesuai sidebar gambar
        Route::get('/master-data', function() { return "Halaman Master Data"; })->name('master');
        Route::get('/master/komoditas', [AdminController::class, 'komoditasIndex'])->name('master.komoditas');
        Route::put('/master/komoditas/{id}/update', [AdminController::class, 'komoditasUpdate'])->name('master.komoditas.update');
        Route::post('/master/komoditas/store', [AdminController::class, 'komoditasStore'])->name('master.komoditas.store');
        Route::delete('/master/komoditas/{id}', [AdminController::class, 'komoditasDestroy'])->name('master.komoditas.destroy');

        Route::get('/master/wilayah', [AdminController::class, 'wilayahIndex'])->name('master.wilayah');
        Route::post('/master/wilayah/store', [AdminController::class, 'wilayahStore'])->name('master.wilayah.store');
        Route::put('/master/wilayah/{id}/update', [AdminController::class, 'wilayahUpdate'])->name('master.wilayah.update');
        Route::delete('/master/wilayah/{id}', [AdminController::class, 'wilayahDestroy'])->name('master.wilayah.destroy');

        Route::get('/master/jenis-bantuan', [AdminController::class, 'jenisBantuanIndex'])->name('master.jenis_bantuan');
        Route::post('/master/jenis-bantuan/store', [AdminController::class, 'jenisBantuanStore'])->name('master.jenis_bantuan.store');
        Route::put('/master/jenis-bantuan/{id}/update', [AdminController::class, 'jenisBantuanUpdate'])->name('master.jenis_bantuan.update');
        Route::delete('/master/jenis-bantuan/{id}', [AdminController::class, 'jenisBantuanDestroy'])->name('master.jenis_bantuan.destroy');

        Route::get('/master/topik', [AdminController::class, 'topikIndex'])->name('master.topik');
        Route::post('/master/topik/store', [AdminController::class, 'topikStore'])->name('master.topik.store');
        Route::put('/master/topik/{id}/update', [AdminController::class, 'topikUpdate'])->name('master.topik.update');
        Route::delete('/master/topik/{id}', [AdminController::class, 'topikDestroy'])->name('master.topik.destroy');
        Route::get('/permohonan', [AdminController::class, 'permohonanIndex'])->name('permohonan.index');
        Route::get('/permohonan/data/{id}', [AdminController::class, 'getDetailData'])->name('permohonan.data');
        Route::put('/permohonan/verifikasi/{id}', [AdminController::class, 'permohonanUpdateVerifikasi'])->name('permohonan.verifikasi.update');
        Route::delete('/permohonan/{id}', [AdminController::class, 'permohonanDestroy'])->name('permohonan.destroy');

        Route::get('/pendampingan', [AdminController::class, 'pendampinganIndex'])->name('pendampingan.index');
        Route::get('/laporan', [AdminController::class, 'laporanIndex'])->name('laporan.index');
    });
});