<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBantuanAdmin extends Model
{
    use HasFactory;
    protected $table = 'master_jenis_bantuan';
    protected $fillable = ['nama_bantuan', 'kategori', 'status'];
}
