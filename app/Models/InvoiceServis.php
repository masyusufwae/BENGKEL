<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceServis extends Model
{
    protected $table = 'invoice_servis';
    protected $primaryKey = 'id_invoice';

    protected $fillable = [
        'id_wo',
        'nomor_invoice',
        'total_jasa',
        'total_part',
        'diskon',
        'pajak',
        'total_bayar',
        'status_bayar',
        'tanggal_bayar',
    ];

    protected $casts = [
        'tanggal_bayar' => 'datetime',
    ];

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class, 'id_wo', 'id_wo');
    }
}
