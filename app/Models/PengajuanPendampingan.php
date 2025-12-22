<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanPendampingan extends Model
{
    use HasFactory;

    // Menggunakan guarded memperbolehkan kolom baru 'id_topik' diisi otomatis
    protected $guarded = ['id'];

    /**
     * Relasi ke Pembudidaya (User)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Relasi ke Petugas UPT (User)
     * Menghubungkan id_petugas di tabel ini ke id di tabel users
     */
    public function petugas()
    {
        return $this->belongsTo(User::class, 'id_petugas', 'id');
    }

    /**
     * Relasi ke Master Topik Pendampingan
     * Menghubungkan id_topik ke tabel master_topik_pendamping
     */
    public function topik()
    {
        return $this->belongsTo(TopikPendampingAdmin::class, 'id_topik', 'id');
    }
}