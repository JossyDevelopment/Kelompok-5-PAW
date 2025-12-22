<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopikPendampingAdmin extends Model
{
    use HasFactory;
    protected $table = 'master_topik_pendamping';
    protected $fillable = ['nama_topik', 'kategori', 'deskripsi'];
}
