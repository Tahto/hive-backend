<?php

namespace App\Models\Sys;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class App extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $sequence = 'sys_unique_source_id_seq';
    protected $table = 'sys_apps';

    protected $fillable = [
        'title',
        'route_api',
        'menu_n2_id', 
        'status', 
    ];

    public function sysMenuN2(){
        return $this->belongsTo('App\Models\Sys\MenuN2','menu_n2_id','id');
    }

}
