<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    protected $table = 'sparepart';

    protected $fillable = [
        'nama_part',
        'stok',
        'harga_jual',
    ];
}
