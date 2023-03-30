<?php

namespace App\Models\Sys;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Sys\GipSectorN1;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'sys_users';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'uf',
        'position',
        'position_summary',
        'sector_n1_id',
        'sector_n2_id',
        'manager_n1_id',
        'manager_n2_id',
        'manager_n3_id',
        'manager_n4_id',
        'manager_n5_id',
        'manager_n6_id',
        'hierarchical_level',
        'type',
        'status',
        'status_real',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function sectorN1(){
        return $this->belongsTo(GipSectorN1::class);
    }

    public function managerN1(){
        return $this->belongsTo(user::class, 'manager_n1_id', 'id')->select(['id','name', 'hierarchical_level' ]);
    }

}
