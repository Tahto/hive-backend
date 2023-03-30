<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SourceGipConsQuadroUnificado extends Model
{
    use HasFactory;

    protected $connection = 'siwebApiGip';

    protected $table = 'GIP_CONS_QUADRO_UNIFICADO';
    public $timestamps = false; 
    protected $primarykey = null;
    public $incrementing = false;
}
