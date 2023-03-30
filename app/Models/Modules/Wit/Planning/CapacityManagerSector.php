<?php

namespace App\Models\Modules\Wit\Planning;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class CapacityManagerSector extends Model
{
    use HasFactory;
    protected $connection = 'oracle-olap';
    
    protected $table = 'capacity_managers_sectors';
    public $incrementing = false;

    protected $fillable = ['sector_id','name','uf','manager_n5_id', 'manager_n4_id', 'manager_n3_id', 'ref'];
}