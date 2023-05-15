<?php

namespace App\Models\Modules\Rv;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terms extends Model
{
    use HasFactory;
    protected $connection = 'oracle-olap';
    protected $table = 'rv_terms';

    protected $fillable = [
        'ref',
        'sector_n1_id',
        'sector_n2_id',
        'version',
        'hierarchical_level',
        'maturity',
        'campaign',
        'approver',
        'approver_ip',
        'approver_host',
        'approver_date',
        'charge_id',
        'status',
    ];
}
