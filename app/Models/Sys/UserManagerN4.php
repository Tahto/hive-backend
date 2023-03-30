<?php

namespace App\Models\Sys;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserManagerN4 extends Model
{
    use HasFactory;
    protected $table = 'sys_users_managers_n4';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'manager_n6_id',
        'manager_n5_id',
        'hierarchical_level',
        'status',
    ];

    public function managerN3()
    {
        return $this->hasMany('App\Models\Sys\UserManagerN3', 'manager_n4_id', 'id');
    }
}
