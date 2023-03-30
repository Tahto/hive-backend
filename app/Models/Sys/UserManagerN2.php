<?php

namespace App\Models\Sys;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserManagerN2 extends Model
{
    use HasFactory;
    protected $table = 'sys_users_managers_n2';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'manager_n6_id',
        'manager_n5_id',
        'manager_n4_id',
        'manager_n3_id',
        'hierarchical_level',
        'status',
    ];

    public function managerN1()
    {
        return $this->hasMany('App\Models\Sys\UserManagerN1', 'manager_n2_id', 'id');
    }
}
