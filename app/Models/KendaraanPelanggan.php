<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KendaraanPelanggan extends Model
{
    protected $table = 'kendaraan_pelanggan';
    protected $primaryKey = 'id_kendaraan';

    protected $fillable = [
        'id_pelanggan',
        'nomor_polisi',
        'merek',
        'model',
        'tahun',
        'warna',
        'nomor_rangka',
        'nomor_mesin',
        'jenis_bahan_bakar',
    ];

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pelanggan');
    }

    public function workOrders(): HasMany
    {
        return $this->hasMany(WorkOrder::class, 'id_kendaraan', 'id_kendaraan');
    }
}
