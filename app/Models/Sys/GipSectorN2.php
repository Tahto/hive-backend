<?php

namespace App\Models\Sys;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GipSectorN2 extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'sys_gip_sectors_n2';
    // public $timestamps = false; 
    public $incrementing = false;

    protected $fillable = ['id','name','sector_n2_id','uf'];
}
