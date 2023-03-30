<?php

namespace App\Models\Sys;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GipManagerSectorN1 extends Model
{
    use HasFactory;
    protected $table = 'sys_gip_manager_sectors_n1';
    public $incrementing = false;

    protected $fillable = [
        'sector_n1_id', 
        'manager_n1_id', 
        'manager_n2_id', 
        'manager_n3_id', 
        'manager_n4_id', 
        'manager_n5_id', 
        'manager_n6_id'
    ];

    public function sectorN1(){
        return $this->belongsTo(GipSectorN1::class)->select(['id','name', 'uf']);
    }

    

}
