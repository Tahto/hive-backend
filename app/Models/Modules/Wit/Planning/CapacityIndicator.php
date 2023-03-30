<?php

namespace App\Models\Modules\Wit\Planning;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class CapacityIndicator extends Model
{
    use HasFactory;
    protected $connection = 'oracle-olap';
 

    protected $fillable = ['title','order','type', 'display', 'description'];
}
