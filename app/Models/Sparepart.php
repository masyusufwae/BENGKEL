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

    /**
     * Generate next unique kode_part (SP001, SP002, etc.)
     */
    public static function generateNextKode()
    {
        $count = self::count();
        do {
            $nextNum = $count + 1;
            $kode = 'SP' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);
            $exists = self::where('kode_part', $kode)->exists();
            if (!$exists) {
                return $kode;
            }
            $count++;
        } while (true);
    }
}
