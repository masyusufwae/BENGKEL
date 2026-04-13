<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mekanik extends Model
{
    protected $table = 'mekanik';
    protected $fillable = [
        'nama_mekanik',
        'nip',
        'spesialisasi',
        'status',
    ];
}
