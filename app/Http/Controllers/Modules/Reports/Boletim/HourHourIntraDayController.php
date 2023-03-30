<?php

namespace App\Http\Controllers\Modules\Reports\Boletim;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Modules\Reports\Boletim\HourHour\BoletimDate;
use App\Models\Modules\Reports\Boletim\HourHour\BoletimDateHour;
use App\Http\Requests\Modules\Reports\Boletim\HourHourIntraDayRequest;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiResponser;

class HourHourIntraDayController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(HourHourIntraDayRequest $request)
    {
        $dt_data =  $request->dt_data;

        $sectors_id = $request->sectors_id;

        try {
            $boletimIntraDay = BoletimDateHour::where('dt_data', $dt_data)
                ->where('nu_setor', $sectors_id)
                ->select(
                    DB::raw("1 as ordem"),
                    DB::raw("to_char(dt_data, 'YYYY-MM-DD') AS dt_data"),
                    DB::raw("SUBSTR(NO_INTERVALO,0,5) as NO_INTERVALO"),
                    'no_sigla',
                    'nu_setor',
                    // NÍVEL DE SERVIÇO
                    DB::raw("round(CAST((NU_PREV_NS_PONDERADO * 1.0 / NULLIF(NU_PREV_RECEBIDAS,0)) AS FLOAT)*100,2) AS NU_NS_DIM"),
                    DB::raw("round(CAST((NU_REAL_2_CH_NS * 1.0 / NULLIF(NU_REAL_1_CH_NS, 0)) AS FLOAT)*100,2) AS NU_REAL_NS"),
                    DB::raw("round((round(CAST((NU_REAL_2_CH_NS * 1.0 / NULLIF(NU_REAL_1_CH_NS, 0)) AS FLOAT),4) - round(CAST((NU_PREV_NS_PONDERADO * 1.0 / NULLIF(NU_PREV_RECEBIDAS,0)) AS FLOAT),4))*100,2) as NU_DIF_NS"),
                    // VOLUME
                    DB::raw("round(NU_PREV_RECEBIDAS,0) AS NU_VOL_DIM"),
                    DB::raw("round(NU_REAL_RECEBIDAS,0) AS NU_VOL_REAL"),
                    DB::raw("round(NU_REAL_ATENDIDAS,0) AS NU_VOL_ATD"),
                    DB::raw("round(CAST((NU_REAL_RECEBIDAS *1.0 / NULLIF(NU_PREV_RECEBIDAS, 0))-1 AS FLOAT)*100,2) AS NU_VOL_PERC"),
                    DB::raw("NU_REAL_ABANDONADAS AS NU_VOL_ABAND"),
                    DB::raw("round(CAST((NU_REAL_ABANDONADAS/NULLIF(NU_REAL_RECEBIDAS  *1.0,0)) AS FLOAT)*100,2) AS NU_VOL_ABAND_PERC"),
                    DB::raw("round(( NU_REAL_TP_ESPERA / NULLIF(NU_REAL_RECEBIDAS,0) )*100,0) AS NU_VOL_TME"),
                    DB::raw("NU_PREV_DN AS NU_VOL_PREV_VOL_DN"),
                    DB::raw("CAST((NU_REAL_ATENDIDAS * 1.0 / NULLIF(NU_PREV_DN, 0)) AS FLOAT)*100 AS NU_VOL_PERC_DN6"),
                    // TMA
                    DB::raw("round(NU_PREV_TP_FALADO / NULLIF((cast(NU_PREV_ATENDIDAS as float)),0),0) AS NU_TMA_DIM"),
                    DB::raw("round((NU_REAL_TP_FALADO / NULLIF(cast(NU_REAL_ATENDIDAS as float), 0)),0) AS NU_TMA_REAL_GERAL"),
                    DB::raw("round((NU_REAL_TP_FALADO_R / NULLIF(cast(NU_REAL_ATENDIDAS as float), 0)),0) AS NU_TMA_REAL_RECEP"),
                    DB::raw("round((NU_REAL_TP_FALADO / NULLIF(NU_REAL_ATENDIDAS, 0) - NU_PREV_TP_FALADO / NULLIF(NU_PREV_ATENDIDAS, 0)) / (NU_REAL_TP_FALADO / NULLIF(NU_REAL_ATENDIDAS, 0)) * 100,2) AS NU_TMA_PERC"),
                    // TRÁFEGO ENTRANTE	
                    DB::raw("round(NU_PREV_TP_FALADO,0)  AS NU_TRAF_ENT_DIM"),
                    DB::raw("cast(((NU_REAL_TP_FALADO / NULLIF(cast(NU_REAL_ATENDIDAS as float), 0)) * NU_REAL_RECEBIDAS) as int) AS NU_TRAF_ENT_REAL"),
                    DB::raw("round((cast(((NU_REAL_TP_FALADO / NULLIF(cast(NU_REAL_ATENDIDAS as float), 0)) * NU_REAL_RECEBIDAS) as float) / nullif(cast(NU_PREV_TP_FALADO as float),0)) * 100,2) -1 AS NU_TRAF_ENT_PERC"),
                    // TRÁFEGO ATD
                    DB::raw("cast((NU_REAL_TP_FALADO / NULLIF(cast(NU_REAL_ATENDIDAS as float), 0)) * NU_REAL_ATENDIDAS as int) AS NU_TRAF_ATD_REAL"),
                    DB::raw("round((((NU_REAL_TP_FALADO / NULLIF(cast(NU_REAL_ATENDIDAS as float), 0)) * NU_REAL_ATENDIDAS) / NULLIF(NU_PREV_TP_FALADO,0)) *100 ,2) -1 AS NU_TRAF_ATD_PERC"),
                    // LOGIN DIM
                    DB::raw("round(cast((NU_PREV_TP_LOGADO/1800) as float) ,0) AS NU_LOGIN_DIM_DIM"),
                    DB::raw("round(NU_PREV_TP_LOGADO,0) AS NU_LOGIN_DIM_TEMPO"),
                    DB::raw("round(cast(NU_PREV_PAUSAS/1800.00 as float) *100,0) AS NU_LOGIN_DIM_PAUSAS"),
                    DB::raw("round(cast((NU_PREV_TP_LOGADO - NU_PREV_PAUSAS) as float),0) AS NU_LOGIN_DIM_ATD"),
                    // LOGIN REAL
                    DB::raw("cast(round(cast(NU_REAL_TP_LOGADO as float)/1800,0) as int)AS NU_LOGIN_REAL_AGENTES"),
                    DB::raw("NU_REAL_TP_LOGADO AS NU_LOGIN_REAL_TEMPO"),
                    DB::raw("round(cast(NU_REAL_PAUSAS/1800.00 as float),2) AS NU_LOGIN_REAL_PAUSAS"),
                    DB::raw("(NU_REAL_TP_LOGADO - NU_REAL_PAUSAS) AS NU_LOGIN_REAL_ATD"),
                    // % LOGIN
                    DB::raw("round(((NU_REAL_TP_LOGADO/1800) - (NU_PREV_TP_LOGADO/1800) ) / NULLIF(cast((NU_PREV_TP_LOGADO/1800)as float) , 0)*100,2) AS NU_LOGIN_AGENTES"),
                    DB::raw("round(((NU_REAL_TP_LOGADO) - (NU_PREV_TP_LOGADO) ) / NULLIF((NU_PREV_TP_LOGADO) * 1.0, 0) *100,2) AS NU_LOGIN_TEMPO"),
                    DB::raw("round(((NU_REAL_PAUSAS - NU_PREV_PAUSAS ) / NULLIF(NU_PREV_PAUSAS * 1.0, 0))*100,2) AS NU_LOGIN_PAUSAS"),
                    DB::raw("round(((NU_REAL_TP_LOGADO - NU_REAL_PAUSAS) - cast((NU_PREV_TP_LOGADO - NU_PREV_PAUSAS) as float)) / nullif( cast((NU_PREV_TP_LOGADO - NU_PREV_PAUSAS) as float),0) *100,2) AS NU_LOGIN_ATD"),
                    // % PAUSAS
                    DB::raw("round(CAST(NU_REAL_PAUSA_TP_LANCHE *1.0 / NULLIF(NU_REAL_TP_LOGADO, 0) AS FLOAT),2) * 100 AS NU_PAUSAS_LANCHE"),
                    DB::raw("round(CAST(NU_REAL_PAUSA_TP_REFEICAO *1.0 / NULLIF(NU_REAL_TP_LOGADO, 0) AS FLOAT),2)  * 100  AS NU_PAUSAS_REFEICAO"),
                    DB::raw("round(CAST(NU_REAL_PAUSA_TP_DESCANSO *1.0 / NULLIF(NU_REAL_TP_LOGADO, 0) AS FLOAT),2)  * 100  AS NU_PAUSAS_DESCANSO"),
                    DB::raw("round(CAST(NU_REAL_PAUSA_TP_BANHEIRO *1.0 / NULLIF(NU_REAL_TP_LOGADO, 0) AS FLOAT),2)  * 100  AS NU_PAUSAS_BANHEIRO"),
                    DB::raw("round(CAST(NU_REAL_PAUSA_TP_FEEDBACK *1.0 / NULLIF(NU_REAL_TP_LOGADO, 0) AS FLOAT),2)  * 100  AS NU_PAUSAS_FEEDBACK"),
                    DB::raw("round(CAST(NU_REAL_PAUSA_TP_REUNIAO *1.0 / NULLIF(NU_REAL_TP_LOGADO, 0) AS FLOAT),2)  * 100  AS NU_PAUSAS_REUNIAO"),
                    DB::raw("round(CAST(NU_REAL_PAUSA_TP_EXAME_PERIODICO *1.0 / NULLIF(NU_REAL_TP_LOGADO, 0) AS FLOAT),2)  * 100  AS NU_PAUSAS_EXAME_PERIODICO"),
                    DB::raw("round(CAST(NU_REAL_PAUSA_TP_TREINAMENTO *1.0 / NULLIF(NU_REAL_TP_LOGADO, 0) AS FLOAT),2)  * 100 AS NU_PAUSAS_TREINAMENTO"),
                    DB::raw("round(CAST(NU_REAL_PAUSA_TP_BACKOFFICE *1.0 / NULLIF(NU_REAL_TP_LOGADO, 0) AS FLOAT),2)  * 100 AS NU_PAUSAS_BACKOFFICE"),
                    DB::raw("round(CAST(NU_REAL_PAUSA_TP_DEFEITO *1.0 / NULLIF(NU_REAL_TP_LOGADO, 0) AS FLOAT),2)  * 100 AS NU_PAUSAS_DEFEITO"),
                    DB::raw("round(CAST(NU_REAL_PAUSA_TP_LOGOF *1.0 / NULLIF(NU_REAL_TP_LOGADO, 0) AS FLOAT),2) * 100  AS NU_PAUSAS_LOGOF"),
                    DB::raw("round(CAST(NU_REAL_PAUSA_TP_COMUNICACAO *1.0 / NULLIF(NU_REAL_TP_LOGADO, 0) AS FLOAT),2) * 100  AS NU_PAUSAS_COMUNICACAO"),
                    DB::raw("round(CAST(NU_REAL_PAUSA_TP_FEEDBACK_SUP *1.0 / NULLIF(NU_REAL_TP_LOGADO, 0) AS FLOAT),2) * 100  AS NU_PAUSAS_FEEDBACK_SUP"),
                    DB::raw("round(CAST(NU_REAL_PAUSA_TP_CALLBACK *1.0 / NULLIF(NU_REAL_TP_LOGADO, 0) AS FLOAT),2) * 100  AS NU_PAUSAS_CALLBACK"),
                    DB::raw("round(CAST(NU_REAL_PAUSA_TP_INPUT_VENDAS *1.0 / NULLIF(NU_REAL_TP_LOGADO, 0) AS FLOAT),2) * 100  AS NU_PAUSAS_INPUT_VENDAS"),

                );


            $boletimDay = BoletimDate::where('dt_data', $dt_data)
                ->where('nu_setor', $sectors_id)
                ->union($boletimIntraDay)
                ->select(
                    DB::raw("0 as ordem"),
                    DB::raw("to_char(dt_data, 'YYYY-MM-DD') AS dt_data"),
                    DB::raw("'--:--' as NO_INTERVALO"),
                    'no_sigla',
                    'nu_setor',
                    // NÍVEL DE SERVIÇO
                    DB::raw("round(CAST((NU_PREV_NS_PONDERADO * 1.0 / NULLIF(NU_PREV_RECEBIDAS,0)) AS FLOAT)*100,2) AS NU_NS_DIM"),
                    DB::raw("round(CAST((NU_REAL_2_CH_NS * 1.0 / NULLIF(NU_REAL_1_CH_NS, 0)) AS FLOAT)*100,2) AS NU_REAL_NS"),
                    DB::raw("round((round(CAST((NU_REAL_2_CH_NS * 1.0 / NULLIF(NU_REAL_1_CH_NS, 0)) AS FLOAT),4) - round(CAST((NU_PREV_NS_PONDERADO * 1.0 / NULLIF(NU_PREV_RECEBIDAS,0)) AS FLOAT),4))*100,2) as NU_DIF_NS"),
                    // VOLUME
                    DB::raw("round(NU_PREV_RECEBIDAS,0) AS NU_VOL_DIM"),
                    DB::raw("round(NU_REAL_RECEBIDAS,0) AS NU_VOL_REAL"),
                    DB::raw("round(NU_REAL_ATENDIDAS,0) AS NU_VOL_ATD"),
                    DB::raw("round(CAST((NU_REAL_RECEBIDAS *1.0 / NULLIF(NU_PREV_RECEBIDAS, 0))-1 AS FLOAT)*100,2) AS NU_VOL_PERC"),
                    DB::raw("NU_REAL_ABANDONADAS AS NU_VOL_ABAND"),
                    DB::raw("round(CAST((NU_REAL_ABANDONADAS/NULLIF(NU_REAL_RECEBIDAS  *1.0,0)) AS FLOAT)*100,2) AS NU_VOL_ABAND_PERC"),
                    DB::raw("round(( NU_REAL_TP_ESPERA / NULLIF(NU_REAL_RECEBIDAS,0) )*100,0) AS NU_VOL_TME"),
                    DB::raw("NU_PREV_DN AS NU_VOL_PREV_VOL_DN"),
                    DB::raw("CAST((NU_REAL_ATENDIDAS * 1.0 / NULLIF(NU_PREV_DN, 0)) AS FLOAT)*100 AS NU_VOL_PERC_DN6"),
                    // TMA
                    DB::raw("round(NU_PREV_TP_FALADO / NULLIF((cast(NU_PREV_ATENDIDAS as float)),0),0) AS NU_TMA_DIM"),
                    DB::raw("round((NU_REAL_TP_FALADO / NULLIF(cast(NU_REAL_ATENDIDAS as float), 0)),0) AS NU_TMA_REAL_GERAL"),
                    DB::raw("round((NU_REAL_TP_FALADO_R / NULLIF(cast(NU_REAL_ATENDIDAS as float), 0)),0) AS NU_TMA_REAL_RECEP"),
                    DB::raw("round((NU_REAL_TP_FALADO / NULLIF(NU_REAL_ATENDIDAS, 0) - NU_PREV_TP_FALADO / NULLIF(NU_PREV_ATENDIDAS, 0)) / (NU_REAL_TP_FALADO / NULLIF(NU_REAL_ATENDIDAS, 0)) * 100,2) AS NU_TMA_PERC"),
                    // TRÁFEGO ENTRANTE	
                    DB::raw("round(NU_PREV_TP_FALADO,0)  AS NU_TRAF_ENT_DIM"),
                    DB::raw("cast(((NU_REAL_TP_FALADO / NULLIF(cast(NU_REAL_ATENDIDAS as float), 0)) * NU_REAL_RECEBIDAS) as int) AS NU_TRAF_ENT_REAL"),
                    DB::raw("round((cast(((NU_REAL_TP_FALADO / NULLIF(cast(NU_REAL_ATENDIDAS as float), 0)) * NU_REAL_RECEBIDAS) as float) / nullif(cast(NU_PREV_TP_FALADO as float),0)) * 100,2) -1 AS NU_TRAF_ENT_PERC"),
                    // TRÁFEGO ATD
                    DB::raw("cast((NU_REAL_TP_FALADO / NULLIF(cast(NU_REAL_ATENDIDAS as float), 0)) * NU_REAL_ATENDIDAS as int) AS NU_TRAF_ATD_REAL"),
                    DB::raw("round((((NU_REAL_TP_FALADO / NULLIF(cast(NU_REAL_ATENDIDAS as float), 0)) * NU_REAL_ATENDIDAS) / NULLIF(NU_PREV_TP_FALADO,0)) *100 ,2) -1 AS NU_TRAF_ATD_PERC"),
                    // LOGIN DIM
                    DB::raw("round(cast((NU_PREV_TP_LOGADO/1800) as float) ,0) AS NU_LOGIN_DIM_DIM"),
                    DB::raw("round(NU_PREV_TP_LOGADO,0) AS NU_LOGIN_DIM_TEMPO"),
                    DB::raw("round(cast(NU_PREV_PAUSAS/1800.00 as float) *100,0) AS NU_LOGIN_DIM_PAUSAS"),
                    DB::raw("round(cast((NU_PREV_TP_LOGADO - NU_PREV_PAUSAS) as float),0) AS NU_LOGIN_DIM_ATD"),
                    // LOGIN REAL
                    DB::raw("cast(round(cast(NU_REAL_TP_LOGADO as float)/1800,0) as int)AS NU_LOGIN_REAL_AGENTES"),
                    DB::raw("NU_REAL_TP_LOGADO AS NU_LOGIN_REAL_TEMPO"),
                    DB::raw("round(cast(NU_REAL_PAUSAS/1800.00 as float),2) AS NU_LOGIN_REAL_PAUSAS"),
                    DB::raw("(NU_REAL_TP_LOGADO - NU_REAL_PAUSAS) AS NU_LOGIN_REAL_ATD"),
                    // % LOGIN
                    DB::raw("round(((NU_REAL_TP_LOGADO/1800) - (NU_PREV_TP_LOGADO/1800) ) / NULLIF(cast((NU_PREV_TP_LOGADO/1800)as float) , 0)*100,2) AS NU_LOGIN_AGENTES"),
                    DB::raw("round(((NU_REAL_TP_LOGADO) - (NU_PREV_TP_LOGADO) ) / NULLIF((NU_PREV_TP_LOGADO) * 1.0, 0) *100,2) AS NU_LOGIN_TEMPO"),
                    DB::raw("round(((NU_REAL_PAUSAS - NU_PREV_PAUSAS ) / NULLIF(NU_PREV_PAUSAS * 1.0, 0))*100,2) AS NU_LOGIN_PAUSAS"),
                    DB::raw("round(((NU_REAL_TP_LOGADO - NU_REAL_PAUSAS) - cast((NU_PREV_TP_LOGADO - NU_PREV_PAUSAS) as float)) / nullif( cast((NU_PREV_TP_LOGADO - NU_PREV_PAUSAS) as float),0) *100,2) AS NU_LOGIN_ATD"),
                    // % PAUSAS
                    DB::raw("round(CAST(NU_REAL_PAUSA_TP_LANCHE *1.0 / NULLIF(NU_REAL_TP_LOGADO, 0) AS FLOAT),2) * 100 AS NU_PAUSAS_LANCHE"),
                    DB::raw("round(CAST(NU_REAL_PAUSA_TP_REFEICAO *1.0 / NULLIF(NU_REAL_TP_LOGADO, 0) AS FLOAT),2)  * 100  AS NU_PAUSAS_REFEICAO"),
                    DB::raw("round(CAST(NU_REAL_PAUSA_TP_DESCANSO *1.0 / NULLIF(NU_REAL_TP_LOGADO, 0) AS FLOAT),2)  * 100  AS NU_PAUSAS_DESCANSO"),
                    DB::raw("round(CAST(NU_REAL_PAUSA_TP_BANHEIRO *1.0 / NULLIF(NU_REAL_TP_LOGADO, 0) AS FLOAT),2)  * 100  AS NU_PAUSAS_BANHEIRO"),
                    DB::raw("round(CAST(NU_REAL_PAUSA_TP_FEEDBACK *1.0 / NULLIF(NU_REAL_TP_LOGADO, 0) AS FLOAT),2)  * 100  AS NU_PAUSAS_FEEDBACK"),
                    DB::raw("round(CAST(NU_REAL_PAUSA_TP_REUNIAO *1.0 / NULLIF(NU_REAL_TP_LOGADO, 0) AS FLOAT),2)  * 100  AS NU_PAUSAS_REUNIAO"),
                    DB::raw("round(CAST(NU_REAL_PAUSA_TP_EXAME_PERIODICO *1.0 / NULLIF(NU_REAL_TP_LOGADO, 0) AS FLOAT),2)  * 100  AS NU_PAUSAS_EXAME_PERIODICO"),
                    DB::raw("round(CAST(NU_REAL_PAUSA_TP_TREINAMENTO *1.0 / NULLIF(NU_REAL_TP_LOGADO, 0) AS FLOAT),2)  * 100 AS NU_PAUSAS_TREINAMENTO"),
                    DB::raw("round(CAST(NU_REAL_PAUSA_TP_BACKOFFICE *1.0 / NULLIF(NU_REAL_TP_LOGADO, 0) AS FLOAT),2)  * 100 AS NU_PAUSAS_BACKOFFICE"),
                    DB::raw("round(CAST(NU_REAL_PAUSA_TP_DEFEITO *1.0 / NULLIF(NU_REAL_TP_LOGADO, 0) AS FLOAT),2)  * 100 AS NU_PAUSAS_DEFEITO"),
                    DB::raw("round(CAST(NU_REAL_PAUSA_TP_LOGOF *1.0 / NULLIF(NU_REAL_TP_LOGADO, 0) AS FLOAT),2) * 100  AS NU_PAUSAS_LOGOF"),
                    DB::raw("round(CAST(NU_REAL_PAUSA_TP_COMUNICACAO *1.0 / NULLIF(NU_REAL_TP_LOGADO, 0) AS FLOAT),2) * 100  AS NU_PAUSAS_COMUNICACAO"),
                    DB::raw("round(CAST(NU_REAL_PAUSA_TP_FEEDBACK_SUP *1.0 / NULLIF(NU_REAL_TP_LOGADO, 0) AS FLOAT),2) * 100  AS NU_PAUSAS_FEEDBACK_SUP"),
                    DB::raw("round(CAST(NU_REAL_PAUSA_TP_CALLBACK *1.0 / NULLIF(NU_REAL_TP_LOGADO, 0) AS FLOAT),2) * 100  AS NU_PAUSAS_CALLBACK"),
                    DB::raw("round(CAST(NU_REAL_PAUSA_TP_INPUT_VENDAS *1.0 / NULLIF(NU_REAL_TP_LOGADO, 0) AS FLOAT),2) * 100  AS NU_PAUSAS_INPUT_VENDAS"),
                )
                ->orderBy('ordem')
                ->orderBy('no_intervalo')
                ->get();
                return $this->success(   $boletimDay , 'Lista gerada com sucesso');
        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao gerar lista', 422);
        }





        // return $this->success($list, 'Lista gerada com sucesso');
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
