<?php

namespace App\Models\Sys;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMobilePhone extends Model
{
    use HasFactory;
    protected $table = 'sys_users_mobile_phones';
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'telegram_id',
        'phone_number',
        'created_by',
        'updated_by',
    ];
}
