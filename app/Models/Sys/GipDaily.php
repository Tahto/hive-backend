<?php

namespace App\Models\Sys;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GipDaily extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $table = 'sys_gip_daily';
    protected $fillable =   [
        'ref',
        'date',
        'id',
        'name',
        'uf',
        'position',
        'position_summary',
        'sector_n1_id',
        'sector_n2_id',
        'manager_n1_id',
        'manager_n2_id',
        'manager_n3_id',
        'manager_n4_id',
        'manager_n5_id',
        'manager_n6_id',
        'hierarchical_level',
        'capacity',
        'vacation',
        'admission',
        'rescind',
        'status',
        'status_gip',
        'status_op',
        'training',
    ];
}
