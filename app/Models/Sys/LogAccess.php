<?php

namespace App\Models\Sys;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAccess extends Model
{
    use HasFactory;
    protected $table = 'sys_log_accesses';

    protected $fillable = [
            'route_uri', 
            'route_name', 
            'user_id', 
            'user', 
            'ip', 
            'hostname',            
            'request', 
            'user_agent',
            'browser_name',
            'browser_family',
            'browser_version',
            'platform_name',
            'platform_family',
            'platform_version',
            'allowed'
        ];
}
