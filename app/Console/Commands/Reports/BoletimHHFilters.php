<?php

namespace App\Console\Commands\Reports;

use Illuminate\Console\Command;

use App\Models\Sys\GipManagerSectorN1;
use App\Models\Modules\Reports\Boletim\HourHour\BoletimDate;
use App\Models\Modules\Reports\Boletim\HourHour\BoletimFilter;

class BoletimHHFilters extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boletimhh:filters';


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

        // lista os setores do dia 
        $sectors = BoletimDate::select('nu_setor')
            ->groupBy('nu_setor')
            ->get()->toArray();

        $sectors =   array_map(function ($value) {
            return $value['nu_setor'];
        }, $sectors);


        // usando os setores, capitura os  Coordenadores
        $managersN2 = GipManagerSectorN1::selectRaw('sys_users.id as user_id, sys_users.name as user_name, sys_users.position_summary, hierarchical_level, sys_gip_sectors_n1.id as sector_id, sys_gip_sectors_n1.name as sector_name')
            ->leftJoin('sys_users', 'sys_gip_manager_sectors_n1.manager_n2_id', 'id')
            ->leftjoin('sys_gip_sectors_n1', 'sys_gip_manager_sectors_n1.sector_n1_id', 'sys_gip_sectors_n1.id')
            ->whereIn('sys_gip_manager_sectors_n1.sector_n1_id', $sectors)
            ->where('sys_users.status', 1)
            ->groupBy('sys_users.name', 'sys_users.id', 'sys_users.position_summary', 'hierarchical_level', 'sys_gip_sectors_n1.id',  'sys_gip_sectors_n1.name')
            ->get()
            ->toArray();

        // usando os setores, capitura os gerentes
        $managersN3 = GipManagerSectorN1::selectRaw('sys_users.id as user_id, sys_users.name as user_name, sys_users.position_summary, hierarchical_level, sys_gip_sectors_n1.id as sector_id, sys_gip_sectors_n1.name as sector_name')
            ->leftJoin('sys_users', 'sys_gip_manager_sectors_n1.manager_n3_id', 'id')
            ->leftjoin('sys_gip_sectors_n1', 'sys_gip_manager_sectors_n1.sector_n1_id', 'sys_gip_sectors_n1.id')
            ->whereIn('sys_gip_manager_sectors_n1.sector_n1_id', $sectors)
            ->where('sys_users.status', 1)
            ->where('sys_users.status', 1)
            ->groupBy('sys_users.name', 'sys_users.id', 'sys_users.position_summary', 'hierarchical_level', 'sys_gip_sectors_n1.id',  'sys_gip_sectors_n1.name')
            ->get()
            ->toArray();

        // usando os setores, capitura os  Superintendentes
        $managersN4 = GipManagerSectorN1::selectRaw('sys_users.id as user_id, sys_users.name as user_name, sys_users.position_summary, hierarchical_level, sys_gip_sectors_n1.id as sector_id, sys_gip_sectors_n1.name as sector_name')
            ->leftJoin('sys_users', 'sys_gip_manager_sectors_n1.manager_n4_id', 'id')
            ->leftjoin('sys_gip_sectors_n1', 'sys_gip_manager_sectors_n1.sector_n1_id', 'sys_gip_sectors_n1.id')
            ->whereIn('sys_gip_manager_sectors_n1.sector_n1_id', $sectors)
            ->where('sys_users.status', 1)
            ->groupBy('sys_users.name', 'sys_users.id', 'sys_users.position_summary', 'hierarchical_level', 'sys_gip_sectors_n1.id',  'sys_gip_sectors_n1.name')
            ->get()
            ->toArray();

        // usando os setores, capitura os Diretores
        $managersN5 = GipManagerSectorN1::selectRaw('sys_users.id as user_id, sys_users.name as user_name, sys_users.position_summary, hierarchical_level, sys_gip_sectors_n1.id as sector_id, sys_gip_sectors_n1.name as sector_name')
            ->leftJoin('sys_users', 'sys_gip_manager_sectors_n1.manager_n5_id', 'sys_users.id')
            ->leftjoin('sys_gip_sectors_n1', 'sys_gip_manager_sectors_n1.sector_n1_id', 'sys_gip_sectors_n1.id')
            ->whereIn('sys_gip_manager_sectors_n1.sector_n1_id', $sectors)
            ->where('sys_users.status', 1)
            ->groupBy('sys_users.name', 'sys_users.id', 'sys_users.position_summary', 'hierarchical_level', 'sys_gip_sectors_n1.id',  'sys_gip_sectors_n1.name')
            ->get()
            ->toArray();


        // Junta todos os gestores em uma unica lista 
        $managers =  array_merge($managersN5, $managersN4, $managersN3, $managersN2);

        // Classifica pelo cargo e nome
        usort($managers, function ($a, $b) {
            return [$b['hierarchical_level'], $a['user_name'],] <=> [$a['hierarchical_level'], $b['user_name']];
        });

        // //Remove duplicados
        $managers = array_values(array_unique($managers, SORT_REGULAR));

        BoletimFilter::truncate();


        foreach ($managers as $value) {
            BoletimFilter::create($value);
        };

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
        return Command::FAILURE;
    }
}
