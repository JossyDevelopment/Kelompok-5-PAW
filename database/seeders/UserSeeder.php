<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Import Model User
use Illuminate\Support\Facades\Hash; // Import Hash untuk password

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Akun Administrator
        User::create([
            'username' => 'admin',
            'email' => 'admin@dinas.com',
            'password' => Hash::make('password123'), // Password sama semua biar gampang
            'nama_lengkap' => 'Administrator Utama',
            'nomor_hp' => '081111111111',
            'role' => 'admin',
            'status_aktif' => true, // Langsung aktif
            'otp_code' => null,
        ]);

        // 2. Akun Petugas UPT
        User::create([
            'username' => 'petugas1',
            'email' => 'petugas@dinas.com',
            'password' => Hash::make('password123'),
            'nama_lengkap' => 'Budi Santoso (Petugas)',
            'nomor_hp' => '082222222222',
            'role' => 'petugas', // Sesuai dengan logic login redirect
            'status_aktif' => true, 
            'otp_code' => null,
        ]);

        // 3. Akun Pembudidaya (Dummy yang sudah aktif)
        User::create([
            'username' => 'pembudidaya1',
            'email' => 'pembudidaya@gmail.com',
            'password' => Hash::make('password123'),
            'nama_lengkap' => 'Ahmad Pembudidaya',
            'nomor_hp' => '083333333333',
            'role' => 'pembudidaya',
            'status_aktif' => true, // Set true agar bisa login tanpa OTP
            'otp_code' => null,
        ]);
    }
}