<?php

namespace App\Models\Sys;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class MenuN2 extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $sequence = 'sys_unique_source_id_seq';
    protected $table = 'sys_menus_n2';

    protected $fillable = [
        'menu_n1_id',
        'title',
        'icon',
        'to',
        'route_api',
        'order',
        'status',
    ];

    public function sysMenuN1()
    {
        return $this->belongsTo('App\Models\Sys\MenuN1', 'menu_n1_id', 'id');
    }

    public function sysApp()
    {
        return $this->hasMany('App\Models\Sys\App', 'menu_n2_id')->select([
            'id',
            'title',
            'route_api',
            'menu_n2_id',
            'status',
        ])->orderBy('title');
    }
}
