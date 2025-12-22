<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Wilayah;
use App\Models\UsahaBudidaya;
use App\Models\DokumenPendukung;
use App\Models\Verifikasi;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProfilPembudidaya extends Model
{
    use HasFactory;

    protected $table = 'profil_pembudidaya';
    protected $primaryKey = 'id_profil_pembudidaya';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'id_wilayah', 'id_wilayah');
    }

    public function usahaBudidaya(): HasMany
    {
        return $this->hasMany(UsahaBudidaya::class, 'id_profil_pembudidaya', 'id_profil_pembudidaya');
    }

    public function dokumen(): HasMany
    {
        return $this->hasMany(DokumenPendukung::class, 'id_profil_pembudidaya', 'id_profil_pembudidaya');
    }

    public function verifikasi(): HasMany
    {
        return $this->hasMany(Verifikasi::class, 'id_profil_pembudidaya', 'id_profil_pembudidaya');
    }

    public function usaha() {
        return $this->hasOne(UsahaBudidaya::class, 'id_profil_pembudidaya', 'id_profil_pembudidaya');
    }

}