<?php

namespace App\Models\Modules\Wit\Planning;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class CapacityCharge extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $connection = 'oracle-olap';

 
    protected $fillable = [
        'ref',
        'file_dir',
        'status',
    ];
}
