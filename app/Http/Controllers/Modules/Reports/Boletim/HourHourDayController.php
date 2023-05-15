<?php

namespace App\Http\Controllers\Modules\Reports\Boletim;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Modules\Reports\Boletim\HourHour\BoletimDate;
use App\Models\Modules\Reports\Boletim\HourHour\BoletimFilter;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiResponser;

class HourHourDayController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dt_data =  $request->dt_data ? $request->dt_data : date('Y-m-d');
        $manager = $request->manager;
        $sectors_id = $request->sectors_id ? explode(',', $request->sectors_id) : ['_%'];
        $order_by = $request->order_by ? $request->order_by : 'null';
        $order_by = $order_by == 'null' ? ['nu_setor', 'asc'] :  explode(',',$order_by);

        // return $request->all();

        if (!$request->sectors_id && $manager) {

            $sectors_id = BoletimFilter::where(1, 1)
                ->select('sector_id')
                ->groupBy('sector_id')
                ->where('user_id', 'like', $manager)
                ->get()->toArray();

            $sectors_id = array_map(function ($value) {
                return $value['sector_id'];
            }, $sectors_id);
        }

        try {
            $data = BoletimDate::with('chart')
                ->where(1, 1)
                ->select(
                    DB::raw("to_char(dt_data, 'YYYY-MM-DD') AS dt_data"),
                    "no_sigla",
                    "nu_setor",
                    DB::raw("SUBSTR(NO_INTERVALO,0,5) as NO_INTERVALO"),
                    DB::raw("round((CAST((NU_REAL_2_CH_NS * 1.0 / NULLIF(NU_REAL_1_CH_NS, 0)) AS FLOAT))*100,0) AS NU_REAL_NS"),
                    DB::raw("round(((NU_REAL_TP_LOGADO) - (NU_PREV_TP_LOGADO) ) / NULLIF(cast((NU_PREV_TP_LOGADO)as float) , 0) *100,0) AS NU_LOGIN_AGENTES"),
                    DB::raw("round((round(CAST((NU_REAL_2_CH_NS * 1.0 / NULLIF(NU_REAL_1_CH_NS, 0)) AS FLOAT),4) - round(CAST((NU_PREV_NS_PONDERADO * 1.0 / NULLIF(NU_PREV_RECEBIDAS,0)) AS FLOAT),4))*100,0) as NU_DELTA_NS"),
                    DB::raw("round((NU_REAL_TP_FALADO / NULLIF(NU_REAL_ATENDIDAS, 0) - NU_PREV_TP_FALADO / NULLIF(NU_PREV_ATENDIDAS, 0)) / (NU_REAL_TP_FALADO / NULLIF(NU_REAL_ATENDIDAS, 0)) * 100,0) AS NU_DELTA_TMA"),
                    DB::raw("round((CAST((NU_REAL_RECEBIDAS *1.0 / NULLIF(NU_PREV_RECEBIDAS, 0))-1 AS FLOAT))*100,0) AS NU_DELTA_VOL"),                   
                )
                ->where('dt_data',  $dt_data)
                ->where(function ($query) use ($sectors_id) {
                    foreach ($sectors_id as $key => $sector_id) {
                        $query->orWhere('nu_setor', 'like', $sector_id);
                    };
                })
                ->orderBY( $order_by[0] ,  $order_by[1])
                ->get();
        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao gerar lista', 422);
        }

        return $this->success($data, 'Lista gerada com sucesso');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
