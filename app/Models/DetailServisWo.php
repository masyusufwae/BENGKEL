<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailServisWo extends Model
{
    protected $table = 'detail_servis_wo';
    protected $primaryKey = 'id_detail';

    protected $fillable = [
        'id_wo',
        'id_jenis',
        'harga_jasa',
        'keterangan',
    ];

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class, 'id_wo', 'id_wo');
    }

    public function jenisServis(): BelongsTo
    {
        return $this->belongsTo(JenisServis::class, 'id_jenis', 'id_jenis');
    }
}
