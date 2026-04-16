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
        'id_kendaraan', 'id_mekanik', 'nomor_wo', 'keluhan',
        'tanggal_masuk', 'tanggal_selesai', 'estimasi_selesai',
        'status', 'catatan_mekanik'
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

    public function jenisServis()
    {
        return $this->belongsToMany(JenisServis::class, 'detail_wo_servis', 'id_wo', 'id_jenis')
                    ->withPivot('harga_satuan');
    }

    public function spareparts()
    {
        return $this->belongsToMany(Sparepart::class, 'detail_wo_sparepart', 'id_wo', 'id_part')
                    ->withPivot('jumlah', 'harga_satuan');
    }

    // Hitung total harga
    public function getTotalHargaAttribute()
    {
        $totalServis = $this->jenisServis->sum('pivot.harga_satuan');
        $totalSparepart = $this->spareparts->sum(function($sp) {
            return $sp->pivot->jumlah * $sp->pivot->harga_satuan;
        });
        return $totalServis + $totalSparepart;
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