<?php

namespace App\Listeners;


use App\Models\Modules\Wit\Planning\CapacityCharge;
use App\Models\Modules\Wit\Planning\CapacityManagerN3;
use App\Models\Modules\Wit\Planning\CapacityManagerN4;
use App\Models\Modules\Wit\Planning\CapacityManagerN5;
use App\Models\Modules\Wit\Planning\CapacityManagerSector;
use App\Models\Modules\Wit\Planning\CapacityResult;
use App\Models\Modules\Wit\Planning\CapacityIndicator;
use App\Models\Sys\User;
use App\Models\Sys\GipSectorN1;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use App\Events\WitCapcacityCharge;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;

class WitCapacityChargeETL
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\WitCapcacityCharge  $event
     * @return void
     */
    public function handle(WitCapcacityCharge $event)
    {
        $charge = $event->capacityCharge();
        // Log::info( $charge->id);

        try {

            //Abre o arquivo para manipulação 
            $contents = Storage::get($charge['file_dir']);

            //Quebra as linhas do .csv
            $contents = trim($contents, "\n");
            $lines = explode(PHP_EOL, $contents);

            // Pega o cabeçalho do arquivo na primeira linha
            $header = explode(';', $lines[0]);

            // remove a primeira linha
            array_shift($lines);

            $lines = array_filter($lines);

            // Mapeia o array para recodificar as linhas
            $lines = array_map(function ($value) use ($header, $charge) {
                // transforma o conteudo da linha em array
                $temp = explode(';', $value);

                // limpa o conteudo da linha temporrária
                $line = [];

                // corre os valores da linha para atribuir um valor do cabeçalho como key
                foreach ($temp as $key => $valueLine) {
                    $line[$header[$key]] = utf8_encode($valueLine);
                };

                $line['sector_id'] = $line['cd_setor'];
                $line['ref'] = $charge['ref'];

                $date = implode("/", array_reverse(explode("/", $line['dt_data'])));
                

                $line['date'] = $date;
                $line['cd_mat_gerente_relac'] = 'bc' . $line['cd_mat_gerente_relac'];
                $line['cd_mat_gerente_local'] = 'bc' . $line['cd_mat_gerente_local'];
                $line['cd_mat_diretor'] = 'bc' . $line['cd_mat_diretor'];

                return  $line;
            }, $lines);


            $managers = collect(array_map(function ($item) {

                $temp['manager_n3_id'] = $item['cd_mat_gerente_local'];
                $temp['manager_n4_id'] = $item['cd_mat_gerente_relac'];
                $temp['manager_n5_id'] = $item['cd_mat_diretor'];
                $temp['sector_id'] = $item['sector_id'];
                $temp['ref'] = $item['ref'];
                return $temp;
            }, $lines));

            $managerSector =  array_values($managers->unique(function ($item) {
                return $item['manager_n3_id'] . $item['manager_n4_id'] . $item['manager_n5_id'] . $item['sector_id'];
            })->toArray());

            $managerSector = array_map(function ($item) {
                $sector =   GipSectorN1::get(['id', 'name', 'uf'])->find($item['sector_id']);
                $temp['sector_id'] = $item['sector_id'];
                $temp['name'] = $sector ? $sector['name'] : '';
                $temp['uf'] = $sector ? $sector['uf'] : '';

                $temp['manager_n3_id'] = $item['manager_n3_id'];
                $temp['manager_n4_id'] = $item['manager_n4_id'];
                $temp['manager_n5_id'] = $item['manager_n5_id'];
                $temp['ref'] = $item['ref'];
                return $temp;
            },  $managerSector);

            $managerN3 =  array_values($managers->unique(function ($item) {
                return $item['manager_n3_id'] . $item['manager_n4_id'] . $item['manager_n5_id'];
            })->toArray());

            $managerN3 = array_map(function ($item) {
                $user = User::get(['id', 'name'])->find($item['manager_n3_id']);
                $temp['name'] = !$user ? '' : $user['name'];
                $temp['manager_n3_id'] = !$user ? '' : $user['id'];
                $temp['manager_n4_id'] = $item['manager_n4_id'];
                $temp['manager_n5_id'] = $item['manager_n5_id'];
                $temp['ref'] = $item['ref'];
                return $temp;
            },  $managerN3);

            $managerN4 =  array_values(collect($managerN3)->unique(function ($item) {
                return $item['manager_n4_id'] . $item['manager_n5_id'];
            })->toArray());

            $managerN4 = array_map(function ($item) {
                $user = User::get(['id', 'name'])->find($item['manager_n4_id']);
                $temp['manager_n4_id'] = !$user ? '' : $user['id'];
                $temp['name'] = !$user ? '' : $user['name'];
                $temp['manager_n5_id'] = $item['manager_n5_id'];
                $temp['ref'] = $item['ref'];
                return $temp;
            },  $managerN4);

            $managerN5 =  array_values(collect($managerN4)->unique('manager_n5_id')->toArray());

            $managerN5 = array_map(function ($item) {
                $user = User::get(['id', 'name'])->find($item['manager_n5_id']);
                $temp['manager_n5_id'] = !$user ? '' : $user['id'];
                $temp['name'] = !$user ? '' : $user['name'];
                $temp['ref'] = $item['ref'];
                return $temp;
            },  $managerN5);
        } catch (\Throwable $th) {
            Log::error($th);
        }


        $indicators = CapacityIndicator::get(['id','title'])->toArray();

        // return $managerSector;
        DB::beginTransaction();
        CapacityResult::where('ref', $charge['ref'])->delete();
        foreach ($lines as $key => $value) {
           
            $temp['sector_id'] = $value['sector_id'];
            $temp['ref'] = $value['ref'];
            $temp['date'] = $value['date'];

            foreach ($indicators as $key => $ind) {
                $temp['value'] = $value[$ind['title']];
                $temp['indicator_id'] = $ind['id'];
                if ($temp['value']) {
                    CapacityResult::create($temp);
                }
            }           
        };        
        DB::commit();

        // return $managerSector;
        DB::beginTransaction();
        CapacityManagerSector::where('ref', $charge['ref'])->delete();
        foreach ($managerSector as $key => $value) {
            if ($value['name']) {
                CapacityManagerSector::create($value);
            }
        };
        DB::commit();

        DB::beginTransaction();
        CapacityManagerN3::where('ref', $charge['ref'])->delete();
        foreach ($managerN3 as $key => $value) {
            if ($value['name']) {
                CapacityManagerN3::create($value);
            }
        };
        DB::commit();

        DB::beginTransaction();
        CapacityManagerN4::where('ref', $charge['ref'])->delete();
        foreach ($managerN4 as $key => $value) {
            if ($value['name']) {
                CapacityManagerN4::create($value);
            }
        };
        DB::commit();

        DB::beginTransaction();
        CapacityManagerN5::where('ref', $charge['ref'])->delete();
        foreach ($managerN5 as $key => $value) {
            if ($value['name']) {
                CapacityManagerN5::create($value);
            }
        };
        DB::commit();
         Log::info( $charge);
    }
}
