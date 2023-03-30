<?php

namespace App\Models\Modules\Reports;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class PowerBi extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $table = 'reports_power_bi';

    protected $fillable = [
        'title',
        'url',
        'status', 
    ];

    public function owners()
    {
        return $this->hasMany('App\Models\Modules\Reports\PowerBiOwner', 'report_id')->where('status',1)->select(['id','owner_id', 'report_id']);
    }

    public function status()
    {
        return $this->hasOne('App\Models\Sys\StatusDefaultBoolean', 'id','status');
    }
    
}
