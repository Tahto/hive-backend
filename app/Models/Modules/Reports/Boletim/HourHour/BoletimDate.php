<?php

namespace App\Models\Modules\Reports\Boletim\HourHour;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Modules\Reports\Boletim\HourHour\BoletimDateHour;
use Illuminate\Support\Facades\DB;
use Awobaz\Compoships\Compoships;


class BoletimDate extends Model
{
    use HasFactory, Compoships;

    protected $connection = 'oracle-olap';
    protected $table = 'boletim_hh_dia';
    public $incrementing = false;


    public function chart()
    {

        return $this->hasMany(BoletimDateHour::class, ['nu_setor', 'dt_data'], ['nu_setor', 'dt_data'])

            ->select([
                // 'dt_data',
                DB::raw("to_char(dt_data, 'YYYY-MM-DD') AS dt_data"),
                'nu_setor',
                DB::raw("SUBSTR(NO_INTERVALO,0,5) as NO_INTERVALO"),
                DB::raw("ROUND(CAST((NU_REAL_2_CH_NS * 1.0 / NULLIF(NU_REAL_1_CH_NS, 0)) AS FLOAT) * 100,2) AS NU_NS"),
                DB::raw("ROUND(CAST((NU_PREV_NS_PONDERADO * 1.0 / NULLIF(NU_PREV_RECEBIDAS,0)) AS FLOAT) *100,2) AS NU_NS_DIM"),
                DB::raw("ROUND(NU_REAL_ATENDIDAS,2) AS NU_REAL_ATENDIDAS"),
                DB::raw("ROUND(NU_REAL_ABANDONADAS,2) AS NU_REAL_ABANDONADAS"),
                DB::raw("ROUND(NU_PREV_RECEBIDAS,2) AS NU_DIMENSIONADO"),
                
            ])
            ->orderBy('dt_data_hora');
    }
}
