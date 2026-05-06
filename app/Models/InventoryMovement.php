<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryMovement extends Model
{
    protected $table = 'inventory_movements';
    protected $primaryKey = 'id_movement';

    protected $fillable = [
        'id_part',
        'id_wo',
        'jenis',
        'jumlah',
        'harga_satuan',
        'subtotal',
        'sumber',
        'keterangan',
    ];

    public function sparepart(): BelongsTo
    {
        return $this->belongsTo(Sparepart::class, 'id_part', 'id_part');
    }

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class, 'id_wo', 'id_wo');
    }
}
