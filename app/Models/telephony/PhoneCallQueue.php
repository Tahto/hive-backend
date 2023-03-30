<?php

namespace App\Models\telephony;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneCallQueue extends Model
{
    use HasFactory;
    protected $primarykey = null;
    public $incrementing = false;
    protected $table = 'phone_calls_queues';
}
