<?php

namespace App\Models\telephony;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneScaledWait extends Model
{
    use HasFactory;
    protected $primarykey = null;
    public $incrementing = false;
    protected $table = 'phone_scaleds_waits';
}
