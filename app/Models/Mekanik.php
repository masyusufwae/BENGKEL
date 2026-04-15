<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mekanik extends Model
{
    use HasFactory;

    protected $table = 'mekanik';
    protected $primaryKey = 'id_mekanik';
    protected $fillable = [
        'id_user', 'nip', 'nama_mekanik', 'spesialisasi',
        'jam_masuk', 'jam_keluar', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function workOrders()
    {
        return $this->hasMany(WorkOrder::class, 'id_mekanik');
    }
}