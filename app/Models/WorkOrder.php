<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    protected $table = 'work_order';

    protected $fillable = [
        'nomor_wo',
        'keluhan',
        'status',
    ];
}
