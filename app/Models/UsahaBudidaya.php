<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsahaBudidaya extends Model
{
    use HasFactory;
    
    protected $table = 'usaha_budidaya';
    protected $primaryKey = 'id_usaha'; // Sesuai ERD
    protected $guarded = [];
    
    // Relasi balik ke Profil (Opsional)
    public function profilPembudidaya()
    {
        return $this->belongsTo(ProfilPembudidaya::class, 'id_profil_pembudidaya', 'id_profil_pembudidaya');
    }
}