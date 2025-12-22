<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanBantuan extends Model
{
    use HasFactory;
    
    // Menggunakan guarded sudah benar untuk memperbolehkan pengisian kolom baru
    protected $guarded = ['id']; 

    /**
     * Logika otomatisasi saat data dibuat
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // 1. Generate No. Permohonan otomatis (BANT-YYYYMMDD-XXX)
            $date = now()->format('Ymd');
            $count = self::whereDate('created_at', now())->count() + 1;
            
            // Mengatur format agar menjadi BANT-20251223-001
            $model->no_permohonan = "BANT-{$date}-" . str_pad($count, 3, '0', STR_PAD_LEFT);

            // 2. Set default nilai estimasi jika kosong
            if (!$model->nilai_estimasi) {
                $model->nilai_estimasi = 1000000; // Contoh default Rp 1.000.000
            }

            // 3. Set default skala prioritas
            if (!$model->skala_prioritas) {
                $model->skala_prioritas = 'Sedang';
            }
        });
    }

    // Relasi: Permohonan milik User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}