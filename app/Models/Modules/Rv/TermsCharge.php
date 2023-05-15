<?php

namespace App\Models\Modules\Rv;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class TermsCharge extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $connection = 'oracle-olap';
    protected $table = 'rv_terms_charges';

    protected $fillable = [
        'ref',
        'files',
        'filesfails',
        'info',
        'status',
    ];
}
