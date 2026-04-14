<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkOrder extends Model
{
    protected $table = 'work_order';
    protected $primaryKey = 'id_wo';

    protected $fillable = [
        'id_kendaraan',
        'id_mekanik',
        'nomor_wo',
        'keluhan',
        'tanggal_masuk',
        'tanggal_selesai',
        'estimasi_selesai',
        'status',
        'catatan_mekanik',
    ];

    protected $casts = [
        'tanggal_masuk' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'estimasi_selesai' => 'datetime',
    ];

    /**
     * Relasi dengan KendaraanPelanggan
     */
    public function kendaraan(): BelongsTo
    {
        return $this->belongsTo(KendaraanPelanggan::class, 'id_kendaraan', 'id_kendaraan');
    }

    /**
     * Relasi dengan Mekanik
     */
    public function mekanik(): BelongsTo
    {
        return $this->belongsTo(Mekanik::class, 'id_mekanik', 'id_mekanik');
    }

    /**
     * Relasi dengan InvoiceServis
     */
    public function invoice(): HasMany
    {
        return $this->hasMany(InvoiceServis::class, 'id_wo', 'id_wo');
    }
}
