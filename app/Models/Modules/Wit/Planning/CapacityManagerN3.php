<?php

namespace App\Models\Modules\Wit\Planning;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class CapacityManagerN3 extends Model
{
    use HasFactory;
    protected $connection = 'oracle-olap';
    
    protected $table = 'capacity_managers_n3';
    public $incrementing = false;

    protected $fillable = ['manager_n3_id','name', 'manager_n5_id', 'manager_n4_id', 'ref'];
}
