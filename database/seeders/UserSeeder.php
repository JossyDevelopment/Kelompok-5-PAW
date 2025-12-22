<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Import Model User
use Illuminate\Support\Facades\Hash; // Import Hash untuk password
use Illuminate\Support\Facades\DB; // Import Hash untuk password

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
    // Jalur A: ADMINISTRATOR (Via Seeder)
    User::updateOrCreate(
        ['username' => 'admin'],
        [
            'email' => 'admin@dinas.com',
            'password' => Hash::make('password123'),
            'nama_lengkap' => 'Administrator Utama',
            'nomor_hp' => '081234567890',
            'role' => 'admin',
            'status_aktif' => true,
        ]
    );

    // Jalur B: PETUGAS UPT (Via Seeder + Profil Wajib)
    $petugas = User::updateOrCreate(
        ['username' => 'petugas1'],
        [
            'email' => 'petugas@dinas.com',
            'password' => Hash::make('password123'),
            'nama_lengkap' => 'Budi Santoso (Petugas)',
            'nomor_hp' => '082222222222',   
            'role' => 'petugas',
            'status_aktif' => true,
        ]
    );

    // Wajib di-seed agar Petugas bisa melakukan verifikasi (FK id_profil_petugas)
    DB::table('profil_petugas_upt')->updateOrInsert(
        ['id_user' => $petugas->id_user],
        [
            'nama' => 'Budi Santoso',
            'upt_wilayah' => 'UPT Wilayah 1',
            'nomor_hp' => '082222222222',
            'jabatan' => 'Verifikator Lapangan',
        ]
    );
}
}