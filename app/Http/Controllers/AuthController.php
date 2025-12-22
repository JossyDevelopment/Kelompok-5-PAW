<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AuthController extends Controller
{
    // 1. Tampilkan Halaman Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 2. Proses Login
    // 2. Proses Login (YANG SUDAH DIPERBAIKI)
    public function login(Request $request)
    {
        // 1. Validasi input (Tetap gunakan nama field 'username' dari form HTML)
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // 2. Cek apakah yang diinput user itu Format Email atau Biasa?
        $loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // 3. Susun kredensial berdasarkan tipe tadi
        // Jika input email, jadinya ['email' => 'nama@gmail.com', 'password' => '...']
        // Jika input username, jadinya ['username' => 'alfin123', 'password' => '...']
        $credentials = [
            $loginType => $request->username,
            'password' => $request->password
        ];

        // 4. Eksekusi Login
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // PENTING: Cek Status Aktif (OTP)
            if ($user->status_aktif == 0) {
                Auth::logout();
                return redirect()->route('otp.verify', ['id' => $user->id_user])
                    ->with('error', 'Akun Anda belum diverifikasi. Cek email untuk kode OTP.');
            }

            $request->session()->regenerate();

            // Redirect sesuai Role
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->role === 'pembudidaya') {
                return redirect()->intended('/pembudidaya/dashboard');
            } else {
                return redirect()->intended('/petugas/verifikasi-budidaya');
            }
        }

        // Jika gagal
        return back()->withErrors([
            'username' => 'Email/Username atau password salah.',
        ])->onlyInput('username');
    }
    // 3. Tampilkan Halaman Register (Khusus Pembudidaya)
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // 4. Proses Register Pembudidaya
    public function register(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'nomor_hp' => 'required',
            'password' => 'required|min:6',
        ]);

        $otp = rand(1000, 9999); // Ubah jadi 4 digit

        // 3. Simpan ke Database
        // Catatan: status_aktif = 0 (False)
        $user = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            // Buat username otomatis dari bagian depan email + angka acak (opsional)
            'username' => explode('@', $request->email)[0] . rand(100, 999), 
            'email' => $request->email,
            'nomor_hp' => $request->nomor_hp,
            'password' => Hash::make($request->password),
            'role' => 'pembudidaya', 
            'status_aktif' => false, 
            'otp_code' => $otp,
            'otp_expired_at' => Carbon::now()->addMinutes(10), // Berlaku 10 menit
        ]);

        // 4. Kirim Email OTP (Gunakan Try-Catch agar tidak error jika internet mati)
        try {
            // Ini cara simpel kirim email tanpa buat file Mailable terpisah
            // Pastikan .env sudah disetting SMTP Gmail-nya
            Mail::raw("Halo {$user->nama_lengkap}, \n\nKode OTP pendaftaran Anda adalah: {$otp}. \nKode ini berlaku selama 10 menit.", function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Kode Verifikasi Dinas Perikanan');
            });
        } catch (\Exception $e) {
            // Jika gagal kirim email (misal tidak ada koneksi), 
            // kita log saja kodenya untuk testing manual
            \Log::info("Gagal kirim email. Kode OTP User {$user->email}: {$otp}");
        }

        // 5. Redirect ke Halaman Input OTP membawa ID User
        return redirect()->route('otp.verify', ['id' => $user->id_user])
            ->with('success', 'Registrasi berhasil! Kode OTP telah dikirim ke email Anda.');
    }

    // =================================================================
    // TAMBAHAN WAJIB: METHOD UNTUK HALAMAN OTP
    // =================================================================

    // Menampilkan halaman input OTP
    public function showOtpForm($id)
    {
        $user = User::find($id);
        if (!$user) return redirect()->route('login');
        return view('auth.verify-otp', compact('user'));
    }

    // Proses Cek OTP (Untuk Registrasi Awal)
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'id_user' => 'required',
            'otp_code' => 'required|numeric',
        ]);

        $user = User::find($request->id_user);

        // Validasi
        if (!$user || $user->otp_code != $request->otp_code) {
            return back()->with('error', 'Kode OTP salah!');
        }

        // Aktifkan User
        $user->update([
            'status_aktif' => true,
            'otp_code' => null,
            'otp_expired_at' => null
        ]);

        // Login otomatis & Redirect
        Auth::login($user);
        return redirect()->intended('/pembudidaya/dashboard');
    }

    public function showForgotPasswordForm()
{
    return view('auth.forgot-password');
}

// 2. Proses Kirim OTP Lupa Password
public function sendResetLinkEmail(Request $request)
{
    $request->validate(['email' => 'required|email']);

    // Cek apakah user ada
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'Email tidak ditemukan dalam sistem kami.']);
    }

    $otp = rand(1000, 9999); // Ubah jadi 4 digit
    
    // Update data user dengan OTP baru
    $user->otp_code = $otp;
    $user->otp_expired_at = Carbon::now()->addMinutes(10);
    $user->save();

    // Kirim Email (Simulasi/Real)
    try {
        Mail::raw("Halo {$user->nama_lengkap}, \n\nKode OTP untuk reset password Anda adalah: {$otp}. \nJangan berikan kode ini ke siapa pun.", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Reset Password - Dinas Perikanan');
        });
    } catch (\Exception $e) {
        // Log error jika mail gagal
    }

    // Redirect ke Halaman Input OTP (Kita pakai route verifikasi yang sama tapi nanti diarahkan ke reset password)
    // Atau buat halaman OTP khusus reset password
    return redirect()->route('password.otp', ['id' => $user->id_user])
        ->with('success', 'Kode OTP telah dikirim ke email Anda.');
}

    // =================================================================
    // 5. LOGIC RESET PASSWORD (KHUSUS)
    // =================================================================

    // A. Method Khusus Verifikasi OTP Reset Password
    public function verifyOtpForReset(Request $request)
    {
        $request->validate([
            'id_user' => 'required',
            'otp_code' => 'required|numeric',
        ]);

        $user = User::find($request->id_user);

        // Validasi Standar OTP
        if (!$user || $user->otp_code != $request->otp_code || Carbon::now()->greaterThan($user->otp_expired_at)) {
            return back()->with('error', 'Kode OTP salah atau sudah kadaluarsa.');
        }

        // BEDA DISINI: Jika sukses, jangan login, tapi redirect ke form password baru
        // Kita clear OTP dulu agar tidak bisa dipakai ulang, tapi beri flag akses sementara (opsional)
        $user->update(['otp_code' => null]); 

        return redirect()->route('password.reset.form', ['id' => $user->id_user]);
    }

    // B. Menampilkan Halaman Buat Password Baru
    public function showResetPasswordForm($id)
    {
        // Kirim ID User ke view agar form tahu user mana yang diupdate
        return view('auth.reset-password', ['id_user' => $id]);
    }

    // C. Proses Simpan Password Baru
    public function updatePassword(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'password' => 'required|min:8|confirmed', // 'confirmed' otomatis cek name="password_confirmation"
        ]);

        $user = User::find($request->id_user);

        $user->update([
            'password' => Hash::make($request->password),
            'otp_code' => null, // Bersihkan OTP
            'otp_expired_at' => null
        ]);

        return redirect()->route('login')->with('success', 'Password berhasil diubah! Silakan masuk dengan password baru.');
    }

    // 5. Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}