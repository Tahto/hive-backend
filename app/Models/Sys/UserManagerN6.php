<?php

namespace App\Models\Sys;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sys\UserManagerN5;

class UserManagerN6 extends Model
{
    use HasFactory;
    protected $table = 'sys_users_managers_n6';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'hierarchical_level',
        'status',
    ];

    public function managerN5()
    {
        return $this->hasMany('App\Models\Sys\UserManagerN5', 'manager_n6_id', 'id');
    }

};
