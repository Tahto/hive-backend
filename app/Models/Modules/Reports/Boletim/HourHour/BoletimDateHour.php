<?php

namespace App\Models\Modules\Reports\Boletim\HourHour;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Awobaz\Compoships\Compoships;

class BoletimDateHour extends Model
{
    use HasFactory, Compoships;
    protected $connection = 'oracle-olap';
    protected $table = 'boletim_hh_dia_hora';
    public $incrementing = false;
}

