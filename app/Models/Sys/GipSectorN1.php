<?php

namespace App\Models\Sys;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use App\Models\Sys\User;

class GipSectorN1 extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'sys_gip_sectors_n1';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'uf'
    ];

    public function sysSectorN2(){
        return $this->hasMany('App\Models\Sys\GipSectorN2', 'sector_n2_id')->select(['id','name','sector_n2_id','uf']);
    }
}
