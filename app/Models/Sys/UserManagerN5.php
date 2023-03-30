<?php

namespace App\Models\Sys;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserManagerN5 extends Model
{
    use HasFactory;
    protected $table = 'sys_users_managers_n5';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'manager_n6_id',
        'hierarchical_level',
        'status',
    ];

    public function managerN4()
    {
        return $this->hasMany('App\Models\Sys\UserManagerN4', 'manager_n5_id', 'id');
    }

}
