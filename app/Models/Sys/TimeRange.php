<?php

namespace App\Models\Sys;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeRange extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = 'sys_time_ranges';

    protected $fillable = [
        'time',
        'hour',
        'minute',
        'active',
        'passed',
    ];
}
