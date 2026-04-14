<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisServis extends Model
{
    protected $table = 'jenis_servis';
    protected $primaryKey = 'id_jenis';

    protected $fillable = [
        'nama_servis',
        'deskripsi',
        'harga_jasa',
        'estimasi_waktu',
        'kategori',
    ];

    public function detailServis(): HasMany
    {
        return $this->hasMany(\App\Models\DetailServisWo::class, 'id_jenis', 'id_jenis');
    }
}
