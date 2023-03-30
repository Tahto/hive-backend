<?php

namespace App\Models\Sys;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Sys\User;

class GipSectorN1 extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sys_gip_sectors_n1';
    public $incrementing = false;

    protected $fillable = ['id', 'name', 'uf'];

    public function users()
    {
        return $this->hasMany(User::class,'sector_n1_id', 'id');
    }
}
