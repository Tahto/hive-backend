<?php

namespace App\Http\Controllers\Modules\Wit\Planning;

use App\Models\Modules\Wit\Planning\CapacityCharge;


use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;

use App\Jobs\Modules\Wit\Planning\CapacityChargeJsonJob;
use App\Jobs\Modules\Wit\Planning\CapacityChargeResultDimJob;
use App\Jobs\Modules\Wit\Planning\CapacityChargeManagerSectorJob;
use App\Jobs\Modules\Wit\Planning\CapacityChargeManagerN3Job;
use App\Jobs\Modules\Wit\Planning\CapacityChargeManagerN4Job;
use App\Jobs\Modules\Wit\Planning\CapacityChargeManagerN5Job;
use App\Models\Modules\Wit\Planning\CapacityResult;
use App\Models\Modules\Wit\Planning\CapacityIndicator;
use App\Models\Modules\Wit\Planning\CapacityManagerN5;
use App\Models\Modules\Wit\Planning\CapacityManagerSector;

use App\Models\Sys\TimeRange;
use App\Models\Sys\Calendar;

use App\Http\Requests\Modules\Wit\Planning\CapacityChargeRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Http\Functions\ListFunctions;
use Illuminate\Support\Facades\Storage;
use  App\Models\Sys\GipDaily;


class CapacityChargeController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $where = ListFunctions::where($request);
            $search  = ListFunctions::search($request);
            $orderBy  = ListFunctions::orderBy($request, 'id desc'); // Importante!!! Definir ordenação padrão
            $paginate = ListFunctions::paginate($request);
            $return = CapacityCharge::whereRaw($where, $search)
                ->orderByRaw($orderBy)
                ->paginate($paginate)
                ->onEachSide(0);
        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao gerar lista', 422);
        }

        return  $this->success($return,);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CapacityChargeRequest $request)
    {

        $payload['ref'] = $request->ref . '-01';
        $payload['status'] = $request->status;

        // Local que o arquivo será armazenado 
        $path = 'Modules/Wit/Planning/Capacity';

        // Nome do arquivo que será armazenado
        $fileName = 'capacity_ref_' . $payload['ref'] . '_' . time();


        // Armazena o arquivo            
        $payload['file_dir'] = $request->file('file')->storeAs($path, $fileName . '.txt');
        $payload['file_dir_json'] = str_replace('.txt', '.json', $payload['file_dir']);

        $create = CapacityCharge::create($payload);


        Bus::chain([
            new CapacityChargeJsonJob($create),
            new CapacityChargeResultDimJob($create),
            new CapacityChargeManagerSectorJob($create),
            new CapacityChargeManagerN3Job($create),
            new CapacityChargeManagerN4Job($create),
            new CapacityChargeManagerN5Job($create),
        ])->dispatch();

        return 1;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Modules\Wit\Planning\CapacityCharge  $capacityCharge
     * @return \Illuminate\Http\Response
     */
    public function show(CapacityCharge $capacityCharge)
    {

        // Verifica se arquivo existe
        try {
            Storage::disk('local')->exists($capacityCharge['file_dir']);
        } catch (\Throwable $th) {
            return $this->error($th, 'Arquivo não existe', 422);
        }

        // Se existir tenta efetuar o download
        try {
            return Storage::download($capacityCharge['file_dir']);
        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao baixar o arquivo', 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Modules\Wit\Plannin\CapacityCharge  $CapacityCharge
     * @return \Illuminate\Http\Response
     */
    public function destroy(CapacityCharge $capacityManagerN3)
    {

        $url = 'https://api.2clix.com.br/Reports/ExtracaoBaseResumida?Dtinicio=2023-02-01&DtFim=2023-02-05';
        $headers = [];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,  $url );
        // SSL important
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $output = curl_exec($ch);
        curl_close($ch);


        return $output;

        /*
        $date = date('Y-m-d');
        $date = date('Y-m-d', strtotime($date . "-1 day"));

        $year = date('Y');
        $month = date('m');

        $ref = substr($date, 0, 7) . '-01';

        $sector_id = 61;

       
        $data = [];


        $title = CapacityManagerN5::where('ref', $ref)
            ->select(["manager_n5_id", "name", "ref"])
            ->orderByRaw("DECODE (MANAGER_N5_ID,'bc736084',1, '_%',2), NAME")
            ->get()->toArray();

        array_unshift($title, [
            'manager_n5_id' => '',
            'name' => 'Indicadores',
            'ref' => '1'
        ]);

        $title = array_map(function($v){
            $v['title'] = explode(' ',$v['name'])[0];
            return $v; 
        },$title );

        return $title;

        // usa os indicadores para gerar as linhas de resultados
        $lines = CapacityIndicator::orderBy('order')->get(['id', 'title', 'display', 'description'])->toArray();

        $values = [];

        foreach ($lines as $key => $value) {

            $temp = [
                'Indicator_id' => $value['id'],
                'Indicator' => $value['title'],
                'IndicatorDisplay' => $value['display'],
                'IndicatorDescription' => $value['description'],
            ];

            $values[] = $temp;
        }

        // return $values;

        return CapacityResult::with(['indicator'])
            ->where('ref', $ref)
            ->select(['date', 'indicator_id', DB::raw("SUM(value) as value")])
            ->groupBy('indicator_id', 'date')
            ->get();*/
    }
}
