<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WilayahAdmin extends Model
{
    use HasFactory;
    protected $table = 'master_wilayah';
    protected $fillable = ['nama', 'status'];
}
