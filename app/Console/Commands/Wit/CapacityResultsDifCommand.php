<?php

namespace App\Console\Commands\Wit;

use Illuminate\Console\Command;
use App\Models\Sys\User;
use App\Models\Sys\GipSectorN2;
use App\Models\Sys\GipManagerSectorN2;
use App\Models\SourceGipConsQuadroUnificado;
use App\Models\Modules\Wit\Planning\CapacityResult;
use Illuminate\Support\Facades\DB;
use App\Models\Sys\GipDaily;


class CapacityResultsDifCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'capacity:dif';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza resultados do capacity';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $job['name'] = get_class($this);
        $job['event_id'] = 0; // 0 para rotinas 
        $job['status'] = 1;
        $job['running'] = 1;

        $jobControl = job_control($job);

        $date = date('Y-m-d');
        // $date = date('Y-m-d',strtotime($date."-1 day"));
        $date = date('Y-m-d', strtotime('2023-03-03'));
        $ref = substr($date, 0, 7) . '-01';

        // Deleta os valores do periodo
        CapacityResult::where('date',  $date)
            ->where('type', 1)
            ->delete();

        // ------------------------------------------
        $indicatorId = 2; // HC Ativo - nu_hc_real

        $lines = GipDaily::Where('date', $date)
            ->select(['sector_n1_id', DB::raw("SUM(capacity) as value")])
            ->groupBy('ref', 'sector_n1_id')
            ->get();

        foreach ($lines as $key => $value) {

            $temp['ref'] =  $ref;
            $temp['date'] =  $date;
            $temp['sector_id'] =  $value->sector_n1_id;
            $temp['indicator_id'] =  $indicatorId;
            $temp['type'] =  1; // 1 para real
            $temp['value'] = $value->value;

            try {
                CapacityResult::create($temp);
            } catch (\Throwable $th) {

                $jobControl['status'] = 0;
                $jobControl['running'] = 0;

                job_control($job, $jobControl->id);
                return Command::FAILURE;
            }
        }

        // ------------------------------------------
        $indicatorId = 5; // HC Férias - nu_ferias_real

        $lines = GipDaily::Where('date', $date)
            ->select(['sector_n1_id', DB::raw("SUM(vacation) as value")])
            ->groupBy('ref', 'sector_n1_id')
            ->get();

        foreach ($lines as $key => $value) {

            $temp['ref'] =  $ref;
            $temp['date'] =  $date;
            $temp['sector_id'] =  $value->sector_n1_id;
            $temp['indicator_id'] =  $indicatorId;
            $temp['type'] =  1; // 1 para real
            $temp['value'] = $value->value;

            try {
                CapacityResult::create($temp);
            } catch (\Throwable $th) {

                $jobControl['status'] = 0;
                $jobControl['running'] = 0;

                job_control($job, $jobControl->id);
                return Command::FAILURE;
            }
        }

        // ------------------------------------------
        $indicatorId = 10; // HC Treino -  nu_treino_real

        $lines = GipDaily::Where('date', $date)
            ->select(['sector_n1_id', DB::raw("count(training) as value")])
            ->groupBy('ref', 'sector_n1_id')
            ->get();

        foreach ($lines as $key => $value) {

            $temp['ref'] =  $ref;
            $temp['date'] =  $date;
            $temp['sector_id'] =  $value->sector_n1_id;
            $temp['indicator_id'] =  $indicatorId;
            $temp['type'] =  1; // 1 para real
            $temp['value'] = $value->value;

            try {
                CapacityResult::create($temp);
            } catch (\Throwable $th) {

                $jobControl['status'] = 0;
                $jobControl['running'] = 0;

                job_control($job, $jobControl->id);
                return Command::FAILURE;
            }
        }

        // ------------------------------------------

        $indicatorId = 11; // HC Treino MIG -  nu_tr_mig_real

        $lines = GipDaily::Where('date', $date)
            ->Where('training', 'migração')
            ->select(['sector_n1_id', DB::raw("count(training) as value")])
            ->groupBy('ref', 'sector_n1_id')
            ->get();

        foreach ($lines as $key => $value) {

            $temp['ref'] =  $ref;
            $temp['date'] =  $date;
            $temp['sector_id'] =  $value->sector_n1_id;
            $temp['indicator_id'] =  $indicatorId;
            $temp['type'] =  1; // 1 para real
            $temp['value'] = $value->value;

            try {
                CapacityResult::create($temp);
            } catch (\Throwable $th) {

                $jobControl['status'] = 0;
                $jobControl['running'] = 0;

                job_control($job, $jobControl->id);
                return Command::FAILURE;
            }
        }

        // ------------------------------------------

        $indicatorId = 12; // HC Treino Inicial -  nu_tr_ini_real

        $lines = GipDaily::Where('date', $date)
            ->Where('training', 'inicial')
            ->select(['sector_n1_id', DB::raw("count(training) as value")])
            ->groupBy('ref', 'sector_n1_id')
            ->get();

        foreach ($lines as $key => $value) {

            $temp['ref'] =  $ref;
            $temp['date'] =  $date;
            $temp['sector_id'] =  $value->sector_n1_id;
            $temp['indicator_id'] =  $indicatorId;
            $temp['type'] =  1; // 1 para real
            $temp['value'] = $value->value;

            try {
                CapacityResult::create($temp);
            } catch (\Throwable $th) {

                $jobControl['status'] = 0;
                $jobControl['running'] = 0;

                job_control($job, $jobControl->id);
                return Command::FAILURE;
            }
        }
        // ------------------------------------------
        $indicatorId = 13; // HC Treino Reciclagem -  nu_tr_reci_real

        $lines = GipDaily::Where('date', $date)
            ->Where('training', 'reciclagem')
            ->select(['sector_n1_id', DB::raw("count(training) as value")])
            ->groupBy('ref', 'sector_n1_id')
            ->get();

        foreach ($lines as $key => $value) {

            $temp['ref'] =  $ref;
            $temp['date'] =  $date;
            $temp['sector_id'] =  $value->sector_n1_id;
            $temp['indicator_id'] =  $indicatorId;
            $temp['type'] =  1; // 1 para real
            $temp['value'] = $value->value;

            try {
                CapacityResult::create($temp);
            } catch (\Throwable $th) {

                $jobControl['status'] = 0;
                $jobControl['running'] = 0;

                job_control($job, $jobControl->id);
                return Command::FAILURE;
            }
        }
        // ------------------------------------------
        $indicatorId = 21; // HC Afastados -  nu_afastados_real

        $lines = GipDaily::Where('date', $date)
            ->Where('STATUS_OP', 'like', '%Afasta%')
            ->select(['sector_n1_id', DB::raw("count(*) as value")])
            ->groupBy('ref', 'sector_n1_id')
            ->get();

        foreach ($lines as $key => $value) {

            $temp['ref'] =  $ref;
            $temp['date'] =  $date;
            $temp['sector_id'] =  $value->sector_n1_id;
            $temp['indicator_id'] =  $indicatorId;
            $temp['type'] =  1; // 1 para real
            $temp['value'] = $value->value;

            try {
                CapacityResult::create($temp);
            } catch (\Throwable $th) {

                $jobControl['status'] = 0;
                $jobControl['running'] = 0;

                job_control($job, $jobControl->id);
                return Command::FAILURE;
            }
        }
        // ------------------------------------------
        $indicatorId = 22; // HC Desligados -  nu_desligados_real

        $capacityPosition = ['Agente', 'Jovem Aprendiz', 'Auxiliar'];

        $lines = GipDaily::Where('date', $date)
            ->Where('rescind', $date)
            ->WhereIn('POSITION_SUMMARY', $capacityPosition)
            ->select(['sector_n1_id', DB::raw("count(*) as value")])
            ->groupBy('date', 'sector_n1_id')
            ->get();

        foreach ($lines as $key => $value) {

            $temp['ref'] =  $ref;
            $temp['date'] =  $date;
            $temp['sector_id'] =  $value->sector_n1_id;
            $temp['indicator_id'] =  $indicatorId;
            $temp['type'] =  1; // 1 para real
            $temp['value'] = $value->value;

            try {
                CapacityResult::create($temp);
            } catch (\Throwable $th) {

                $jobControl['status'] = 0;
                $jobControl['running'] = 0;

                job_control($job, $jobControl->id);
                return Command::FAILURE;
            }
        }
        // ------------------------------------------

        $indicatorId = 14; // HC Treino Retorno -  nu_tr_ret_real

        $lines = GipDaily::Where('date', $date)
            ->Where('training', 'retorno')
            ->select(['sector_n1_id', DB::raw("count(training) as value")])
            ->groupBy('ref', 'sector_n1_id')
            ->get();

        foreach ($lines as $key => $value) {

            $temp['ref'] =  $ref;
            $temp['date'] =  $date;
            $temp['sector_id'] =  $value->sector_n1_id;
            $temp['indicator_id'] =  $indicatorId;
            $temp['type'] =  1; // 1 para real
            $temp['value'] = $value->value;

            try {
                CapacityResult::create($temp);
            } catch (\Throwable $th) {

                $jobControl['status'] = 0;
                $jobControl['running'] = 0;

                job_control($job, $jobControl->id);
                return Command::FAILURE;
            }
        }
        // ------------------------------------------

        $indicatorId = 17; // HC Ativos total -  nu_ativos_total_real


        $lines = CapacityResult::whereIn('indicator_id', [2, 5])
            ->Where('date', $date)
            ->select(['sector_id', DB::raw("sum(value) as value")])
            ->groupBy('date', 'sector_id')
            ->get();

        foreach ($lines as $key => $value) {

            $temp['ref'] =  $ref;
            $temp['date'] =  $date;
            $temp['sector_id'] =  $value->sector_id;
            $temp['indicator_id'] =  $indicatorId;
            $temp['type'] =  1; // 1 para real
            $temp['value'] = $value->value;

            try {
                CapacityResult::create($temp);
            } catch (\Throwable $th) {

                $jobControl['status'] = 0;
                $jobControl['running'] = 0;

                job_control($job, $jobControl->id);
                return Command::FAILURE;
            }
        }

        // ------------------------------------------
        $indicatorId = 19; // HC Total -  nu_total_real

        $lines = CapacityResult::whereIn('indicator_id', [2, 5, 10])
            ->Where('date', $date)
            ->select(['sector_id', DB::raw("sum(value) as value")])
            ->groupBy('date', 'sector_id')
            ->get();

        foreach ($lines as $key => $value) {

            $temp['ref'] =  $ref;
            $temp['date'] =  $date;
            $temp['sector_id'] =  $value->sector_id;
            $temp['indicator_id'] =  $indicatorId;
            $temp['type'] =  1; // 1 para real
            $temp['value'] = $value->value;

            try {
                CapacityResult::create($temp);
            } catch (\Throwable $th) {

                $jobControl['status'] = 0;
                $jobControl['running'] = 0;

                job_control($job, $jobControl->id);
                return Command::FAILURE;
            }
        }

        // ------------------------------------------


        job_control($job, $jobControl->id);
        return Command::SUCCESS;
    }

    public function failed()
    {

        $job['name'] = get_class($this);
        $job['event_id'] = 0;
        $job['status'] = 0;
        $job['running'] = 0;

        job_control($job);
    }
}
