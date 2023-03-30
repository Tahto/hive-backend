<?php

namespace App\Models\Modules\Reports\Boletim\HourHour;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoletimFilter extends Model
{
    use HasFactory;
    protected $connection = 'oracle-olap';
    protected $table = 'boletim_hh_filters';
    public $incrementing = false;


    protected $fillable = [
        'user_id',
        'user_name',
        'position_summary',
        'hierarchical_level',
        'sector_id',
        'sector_name',
    ];
}
