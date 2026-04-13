<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisServis extends Model
{
    protected $table = 'jenis_servis';

    protected $fillable = [
        'nama_servis',
        'harga_jasa',
        'estimasi_waktu',
    ];
}
