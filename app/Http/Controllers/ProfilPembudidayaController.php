<?php

namespace App\Http\Controllers;

// PASTIKAN BARIS INI ADA
use App\Http\Controllers\Controller; 
use App\Models\ProfilPembudidaya;
use App\Models\UsahaBudidaya;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse; 
use Illuminate\View\View; 

// 2. Class dimulai di sini
class ProfilPembudidayaController extends Controller
{
    // Type hinting View untuk method index
    public function index(): View 
    {
        // Menampilkan data pembudidaya beserta usahanya
        $data = ProfilPembudidaya::with(['usahaBudidaya', 'wilayah'])->get();
        
        // Perbaikan dari error sebelumnya: Syntax return view
        return view('pembudidaya.index', compact('data')); 
    }

    // Type hinting RedirectResponse untuk method store
    public function store(Request $request): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'nama_lengkap' => 'required',
            'jenis_ikan' => 'required',
            // ... Tambahkan validasi lain ...
        ]);

        // Gunakan DB Transaction agar jika salah satu gagal, semua dibatalkan
        DB::transaction(function () use ($request) {
            
            // 1. Buat User Baru
            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make('password123'), // Menggunakan Hash yang sudah di-import
                'email' => $request->email,
                'nama_lengkap' => $request->nama_lengkap,
                'nomor_hp' => $request->nomor_hp,
                'role' => 'pembudidaya',
            ]);

            // 2. Buat Profil Pembudidaya
            $profil = ProfilPembudidaya::create([
                'id_user' => $user->id_user,
                'id_wilayah' => $request->id_wilayah,
                'nama' => $request->nama_lengkap,
                'NIK' => $request->nik,
                'alamat' => $request->alamat,
                'nomor_hp' => $request->nomor_hp,
                'tipe_pembudidaya' => $request->tipe_pembudidaya,
            ]);

            // 3. Buat Data Usaha Budidaya
            UsahaBudidaya::create([
                'id_profil_pembudidaya' => $profil->id_profil_pembudidaya,
                'jenis_ikan' => $request->jenis_ikan,
                'tipe_kolam' => $request->tipe_kolam,
                'luas_kolam' => $request->luas_kolam,
                'kapasitas_produksi' => $request->kapasitas_produksi,
                'jumlah_kolam' => $request->jumlah_kolam,
            ]);
        });

        return redirect()->route('pembudidaya.index')->with('success', 'Data Pembudidaya Berhasil Disimpan');
    }
} // <--- KURUNG KURAWAL PENUTUP CLASS HANYA ADA DI AKHIR FILE