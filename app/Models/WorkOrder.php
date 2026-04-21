<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WorkOrder extends Model
{
    use HasFactory;

    protected $table = 'work_order';
    protected $primaryKey = 'id_wo';
    protected $fillable = [
    'id_kendaraan',
    'id_mekanik',
    'id_sparepart',
    'nomor_wo',
    'keluhan',
    'gambar',
    'tanggal_masuk',
    'tanggal_selesai',
    'estimasi_selesai',
    'status',
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

    public function sparepart()
    {
        // work_order.id_sparepart references sparepart.id_part (not the default "id").
        return $this->belongsTo(Sparepart::class, 'id_sparepart', 'id_part');
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

    public function spareparts()
    {
        return $this->belongsToMany(Sparepart::class, 'detail_wo_sparepart', 'id_wo', 'id_part')
            ->withPivot('jumlah', 'harga_satuan')
            ->withTimestamps();
    }
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
    // This project has two representations of WO details:
    // - Many-to-many pivot tables: detail_wo_servis + detail_wo_sparepart (admin screens)
    // - Detail tables: detail_servis_wo + penggunaan_sparepart (mekanik screens)
    // Pick the one that has data for this WO to avoid double counting.

    // ----- Jasa servis -----
    $usePivotServis = $this->relationLoaded('jenisServis')
        ? $this->jenisServis->isNotEmpty()
        : $this->jenisServis()->exists();

    if ($usePivotServis) {
        $jasa = $this->relationLoaded('jenisServis')
            ? (float) $this->jenisServis->sum(fn ($s) => (float) ($s->pivot->harga_satuan ?? 0))
            : (float) $this->jenisServis()->sum('detail_wo_servis.harga_satuan');
    } else {
        $jasa = $this->relationLoaded('detailServis')
            ? (float) $this->detailServis->sum('harga_jasa')
            : (float) $this->detailServis()->sum('harga_jasa');
    }

    // ----- Sparepart -----
    $usePivotPart = $this->relationLoaded('spareparts')
        ? $this->spareparts->isNotEmpty()
        : $this->spareparts()->exists();

    if ($usePivotPart) {
        if ($this->relationLoaded('spareparts')) {
            $part = (float) $this->spareparts->sum(function ($p) {
                $qty = (int) ($p->pivot->jumlah ?? 0);
                $harga = (float) ($p->pivot->harga_satuan ?? 0);
                return $qty * $harga;
            });
        } else {
            $part = (float) (DB::table('detail_wo_sparepart')
                ->where('id_wo', $this->getKey())
                ->selectRaw('COALESCE(SUM(jumlah * harga_satuan), 0) AS total')
                ->value('total') ?? 0);
        }
    } else {
        $part = $this->relationLoaded('penggunaanSparepart')
            ? (float) $this->penggunaanSparepart->sum('subtotal')
            : (float) $this->penggunaanSparepart()->sum('subtotal');
    }

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
