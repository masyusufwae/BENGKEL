<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;

    protected $table = 'work_order';
    protected $primaryKey = 'id_wo';
    protected $fillable = [
    'id_kendaraan',
    'id_mekanik',
    'nomor_wo',
    'keluhan',
    'gambar',
    'tanggal_masuk',
    'tanggal_selesai',
    'estimasi_selesai',
    'status',
    'servis_completed',
    'catatan_mekanik'
];

    protected $casts = [
        'tanggal_masuk' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'estimasi_selesai' => 'datetime',
    ];

    public function mekanik()
    {
        return $this->belongsTo(Mekanik::class, 'id_mekanik');
    }

    public function kendaraan()
    {
        return $this->belongsTo(KendaraanPelanggan::class, 'id_kendaraan');
    }

    public function invoice()
    {
        return $this->hasMany(InvoiceServis::class, 'id_wo', 'id_wo');
    }

    public function jenisServis()
    {
        return $this->belongsToMany(JenisServis::class, 'detail_wo_servis', 'id_wo', 'id_jenis')
                    ->withPivot('harga_satuan');
    }

    // public function spareparts()
    // {
    //     return $this->belongsToMany(Sparepart::class, 'detail_wo_sparepart', 'id_wo', 'id_part')
    //                 ->withPivot('jumlah', 'harga_satuan');
    // }
    public function detailServis()
{
    return $this->hasMany(\App\Models\DetailServisWo::class, 'id_wo', 'id_wo');
}

public function penggunaanSparepart()
{
    return $this->hasMany(\App\Models\PenggunaanSparepart::class, 'id_wo', 'id_wo');
}

    // Hitung total harga
 public function getTotalHargaAttribute()
{
    $jasa = $this->detailServis->sum('harga_jasa');
    $part = $this->penggunaanSparepart->sum('subtotal');

    return $jasa + $part;
}


    // Auto generate nomor WO
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($wo) {
            if (!$wo->nomor_wo) {
                $wo->nomor_wo = 'WO-' . date('Ymd') . '-' . str_pad(static::max('id_wo') + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
