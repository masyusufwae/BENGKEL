<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenggunaanSparepart extends Model
{
    protected $table = 'penggunaan_sparepart';
    protected $primaryKey = 'id_penggunaan';

    protected $fillable = [
        'id_wo',
        'id_part',
        'jumlah',
        'harga_satuan',
        'subtotal',
    ];

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class, 'id_wo', 'id_wo');
    }

    public function sparepart(): BelongsTo
    {
        return $this->belongsTo(Sparepart::class, 'id_part', 'id_part');
    }
}
