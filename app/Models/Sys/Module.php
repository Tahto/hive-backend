<?php

namespace App\Models\Sys;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;


class Module extends Model
{
    use HasFactory, CreatedUpdatedBy;
    
    protected $table = 'sys_modules';

    protected $fillable = [
        'title', 
        'icon', 
        'to',
        'description', 
        'order',
        'status'
    ];

    public function sysMenuN1(){
        return $this->hasMany('App\Models\Sys\MenuN1')->select([
            "id",
            "module_id",
            "title",
            "icon",
            "to",
            "route_api",
            "order",
            "status",
        ])->orderBy('order');
    }
}
