<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPendukung extends Model
{
    use HasFactory;
    
    protected $table = 'dokumen_pendukung';
    protected $primaryKey = 'id_dokumen'; // Sesuai ERD
    protected $guarded = [];
}