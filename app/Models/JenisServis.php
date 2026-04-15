<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisServis extends Model
{
    use HasFactory;

    protected $table = 'jenis_servis';
    protected $primaryKey = 'id_jenis';
    protected $fillable = [
        'nama_servis', 'deskripsi', 'estimasi_waktu', 'harga_jasa', 'kategori'
    ];

    public function workOrders()
    {
        return $this->belongsToMany(WorkOrder::class, 'detail_wo_servis', 'id_jenis', 'id_wo')
                    ->withPivot('harga_satuan')
                    ->withTimestamps();
    }
}