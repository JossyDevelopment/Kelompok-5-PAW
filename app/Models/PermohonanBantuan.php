<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanBantuan extends Model
{
    use HasFactory;
    
    // Sesuaikan field yang boleh diisi
    protected $guarded = ['id']; 

    // Relasi: Permohonan milik User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}