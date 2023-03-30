<?php

namespace App\Models\Modules\Wit\Robbyson;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RobbysonResult extends Model
{
    use HasFactory;

    protected $connection = 'oracle-olap';
    protected $table = 'robbyson_results';
    public $incrementing = false;


}
