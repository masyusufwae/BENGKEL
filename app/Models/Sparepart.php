<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    use HasFactory;

    protected $table = 'sparepart';
    protected $primaryKey = 'id_part';
    protected $fillable = [
        'kode_part', 'nama_part', 'gambar', 'satuan', 'stok',
        'stok_minimum', 'harga_beli', 'harga_jual'
    ];

    // public function workOrders()
    // {
    //     return $this->belongsToMany(WorkOrder::class, 'detail_wo_sparepart', 'id_part', 'id_wo')
    //                 ->withPivot('jumlah', 'harga_satuan')
    //                 ->withTimestamps();
    // }
    public function penggunaanSparepart()
{
    return $this->hasMany(\App\Models\PenggunaanSparepart::class, 'id_part', 'id_part');
}
}
