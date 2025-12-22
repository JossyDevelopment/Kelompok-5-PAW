<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komoditas extends Model
{
    protected $table = 'master_komoditas';
    protected $fillable = ['nama', 'status'];
}