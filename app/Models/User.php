<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // 1. Definisikan Primary Key (Karena kamu pakai id_user, bukan id)
    protected $primaryKey = 'id_user';

    // 2. DAFTARKAN SEMUA KOLOM DISINI (PENTING!)
    protected $fillable = [
        'nama_lengkap',
        'username',
        'email',
        'nomor_hp',
        'password',
        'role',
        'status_aktif',
        'otp_code',        // Tambahan baru
        'otp_expired_at',  // Tambahan baru
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'status_aktif' => 'boolean', // Casting agar otomatis jadi true/false
    ];

    // app/Models/User.php
    public function profil()
    {
        return $this->hasOne(ProfilPembudidaya::class, 'id_user', 'id_user');
    }
}