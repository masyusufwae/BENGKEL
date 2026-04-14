<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mekanik extends Model
{
    protected $table = 'mekanik';
    protected $primaryKey = 'id_mekanik';

    protected $fillable = [
        'id_user',
        'nama_mekanik',
        'nip',
        'spesialisasi',
        'jam_masuk',
        'jam_keluar',
        'status',
    ];

    protected $casts = [
        'jam_masuk' => 'datetime:H:i:s',
        'jam_keluar' => 'datetime:H:i:s',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function workOrders(): HasMany
    {
        return $this->hasMany(WorkOrder::class, 'id_mekanik', 'id_mekanik');
    }
}
