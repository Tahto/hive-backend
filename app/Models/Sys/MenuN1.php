<?php

namespace App\Models\Sys;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class MenuN1 extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $sequence = 'sys_unique_source_id_seq';
    protected $table = 'sys_menus_n1';

    protected $fillable = [
        'module_id',
        'title', 
        'icon', 
        'to',
        'order',
        'status',
        'route_api',
    ];

    public function sysModule(){
        return $this->belongsTo('App\Models\Sys\Module','module_id','id');
    }

    public function sysMenuN2(){
        return $this->hasMany('App\Models\Sys\MenuN2', 'menu_n1_id')->select(['id','menu_n1_id','title','icon','to','route_api',"order",'status'])->orderBy('order');
    }

  

}
