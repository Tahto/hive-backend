<?php

namespace App\Models\Modules\Reports;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class PowerBiOwner extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $table = 'reports_power_bi_owners';

    protected $fillable = [
        'owner_id',
        'report_id',
        'status', 
    ];

    public function powerBi()
    {
        return $this->belongsTo('App\Models\Modules\Reports\PowerBi', 'report_id', 'id');
    }

    public function user()
    {
        return $this->hasOne('App\Models\Sys\User', 'id','owner_id')->select(['id','name', 'email']);
    }
    
}
