<?php

namespace App\Models\Sys;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GipHierarchicalLevel extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $fillable = ['id','name'];
}
