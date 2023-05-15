<?php

namespace App\Console\Commands\Sys;

use Illuminate\Console\Command;

use App\Models\SourceGipConsQuadroUnificado;
use App\Models\Sys\GipDaily;
use Illuminate\Support\Facades\Log;

class GipDailyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gip:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza base de funcionários do GIP ';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $date = date('Y-m-d');
        $date = date('Y-m-d', strtotime($date . "-1 day"));
        $ref = date('Y-m-01');
        // $date = date('Y-m-d ', strtotime('2023-03-06'));

        GipDaily::where('date', $date)->delete();

        // Pega a Base do GIP da Tahto
        $data = SourceGipConsQuadroUnificado::whereRaw('dt_resc is null or dt_resc >= ?', [$date])
            ->where('dt_adm', '<=', $date)
            ->get([
                'matricula as id',
                'nome as name',
                'uf',
                'CARGO as position',
                'cargo_resumido as position_summary',
                'cod_dpto as sector_n1_id',
                'cod_sub_setor as sector_n2_id',
                'mtr_sup as manager_n1_id',
                'mtr_coord as manager_n2_id',
                'mtr_ger_n2 as manager_n3_id',
                'mtr_ger_n1 as manager_n4_id',
                'mtr_ger_diretoria as manager_n5_id',
                'status_gip',
                'st_op',
                'dt_resc',
                'dt_adm'
            ])->unique('id')->toArray();

        //Percorre a base fazendo as devidas tratativas    
        $objTemp = [];
        foreach ($data as $value) {

            $objTemp['ref'] = $ref;
            $objTemp['date'] = $date;
            $objTemp['id'] = 'bc' . $value['id'];
            $objTemp['name'] = ucfirstException($value['name']);
            $objTemp['uf'] = $value['uf'];
            $objTemp['position'] = ucfirstException($value['position']);
            $objTemp['position_summary'] = ucfirstException($value['position_summary']);
            $objTemp['sector_n1_id'] = $value['sector_n1_id'];
            $objTemp['sector_n2_id'] = $value['sector_n2_id'] == 0 ? null : $value['sector_n2_id'];
            $objTemp['manager_n1_id'] = 'bc' . $value['manager_n1_id'];
            $objTemp['manager_n2_id'] = 'bc' . $value['manager_n2_id'];
            $objTemp['manager_n3_id'] = 'bc' . $value['manager_n3_id'];
            $objTemp['manager_n4_id'] = 'bc' . $value['manager_n4_id'];
            $objTemp['manager_n5_id'] = 'bc' . $value['manager_n5_id'];
            $objTemp['manager_n6_id'] = 'bc756399'; // Temporariamente, setar a Matricula do CO Atual 
            $objTemp['hierarchical_level'] = 0;
            $objTemp['hierarchical_level'] = $value['id'] == $objTemp['manager_n1_id'] ? 1 : $objTemp['hierarchical_level'];
            $objTemp['hierarchical_level'] = $value['id'] == $objTemp['manager_n2_id'] ? 2 : $objTemp['hierarchical_level'];
            $objTemp['hierarchical_level'] = $value['id'] == $objTemp['manager_n3_id'] ? 3 : $objTemp['hierarchical_level'];
            $objTemp['hierarchical_level'] = $value['id'] == $objTemp['manager_n4_id'] ? 4 : $objTemp['hierarchical_level'];
            $objTemp['hierarchical_level'] = $value['id'] == $objTemp['manager_n5_id'] ? 5 : $objTemp['hierarchical_level'];
            $objTemp['hierarchical_level'] = $value['id'] == $objTemp['manager_n6_id'] ? 6 : $objTemp['hierarchical_level'];
            $objTemp['status'] = $value['dt_resc'] && str_contains($value['status_gip'], 'RESC')  ? 0 : 1;
            $objTemp['status_gip'] = ucfirstException($value['status_gip']);
            $objTemp['status_op'] = ucfirstException($value['st_op']);
            $objTemp['rescind'] = $value['dt_resc'] ?  $value['dt_resc'] : null;
            $objTemp['admission'] = $value['dt_adm'] ?  $value['dt_adm'] : null;

            $objTemp['training'] = $value['st_op'] ==  'ATIVO NO TR INICIAL' ? 'inicial' : null;
            $objTemp['training'] = $value['st_op'] ==  'ATIVO NO TR MIGRAÇÃO' ? 'migração' : $objTemp['training'];
            $objTemp['training'] = $value['st_op'] ==  'ATIVO NO TR RECICLAGEM' ? 'reciclagem' : $objTemp['training'];
            $objTemp['training'] = $value['st_op'] ==  'ATIVO NO TR RETORNO AFAST' ? 'retorno' : $objTemp['training'];

            $capacityPosition = ['AGENTE', 'JOVEM APRENDIZ', 'AUXILIAR'];
            $capacityStatus  = ['ATIVIDADE NORMAL', 'AFAST. DOENCA MENOR 15 DIAS'];

            if (in_array($value['position_summary'], $capacityPosition) && in_array($value['status_gip'], $capacityStatus)) {
                $objTemp['capacity']  = 1;
            } else {
                $objTemp['capacity']  = 0;
            };

            if (in_array($value['position_summary'], $capacityPosition) && strpos($value['status_gip'], 'FERIAS') !== false) {
                $objTemp['vacation']  = 1;
            } else {
                $objTemp['vacation']  = 0;
            };

            // $objTemp['training'] = '';x

            try {
                GipDaily::create($objTemp);
            } catch (\Throwable $th) {
                // return Command::FAILURE;
                LOG::info($th);
            }

            $objTemp = [];
        }
        return Command::SUCCESS;
    }
}
