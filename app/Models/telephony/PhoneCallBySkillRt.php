<?php

namespace App\Models\telephony;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneCallBySkillRt extends Model
{
    use HasFactory;
    protected $primarykey = null;
    public $incrementing = false;
    protected $table = 'phone_calls_by_skills_rt';
}
