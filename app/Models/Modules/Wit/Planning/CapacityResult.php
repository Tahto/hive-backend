<?php

namespace App\Models\Modules\Wit\Planning;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Modules\Wit\Planning\CapacityIndicator;


class CapacityResult extends Model
{
    use HasFactory;
    protected $connection = 'oracle-olap';

    protected $table = 'capacity_results';
    public $incrementing = false;

    protected $fillable = ['sector_id', 'indicator_id', 'type', 'value', 'ref', 'date', 'manager_n3_id', 'manager_n4_id', 'manager_n5_id'];
    
    public function indicator()
    {
        return $this->belongsTo(CapacityIndicator::class, 'indicator_id', 'id')->select(['id', 'title', 'order', 'type']);;
    }
}
