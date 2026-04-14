<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sparepart extends Model
{
    protected $table = 'sparepart';
    protected $primaryKey = 'id_part';

    protected $fillable = [
        'kode_part',
        'nama_part',
        'satuan',
        'stok',
        'stok_minimum',
        'harga_beli',
        'harga_jual',
    ];

    public function penggunaanSparepart(): HasMany
    {
        return $this->hasMany(PenggunaanSparepart::class, 'id_part', 'id_part');
    }
}
