<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
    Route::get('/petugas/dashboard', function () {
        return "Halo Petugas!";
    });
});