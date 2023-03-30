<?php

namespace App\Models\Sys;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = 'sys_calendar';

    protected $fillable = [
        'year',
        'month',
        'day',
        'date',
        'weekday',
        'business_day',
        'active',
        'passed',
    ];
}
