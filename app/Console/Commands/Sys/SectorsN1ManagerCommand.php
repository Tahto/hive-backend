<?php

namespace App\Console\Commands\Sys;

use Illuminate\Console\Command;
use App\Models\Sys\User;
use App\Models\Sys\GipManagerSectorN1;



class SectorsN1ManagerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sectorsn1manager:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza a lista de setores N1';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $data = user::where('status', '1')
                ->where('manager_n1_id', '<>', 'bc0')
                ->where('manager_n2_id', '<>', 'bc0')
                ->where('manager_n3_id', '<>', 'bc0')
                ->where('manager_n4_id', '<>', 'bc0')
                ->where('manager_n5_id', '<>', 'bc0')
                ->where('manager_n6_id', '<>', 'bc0')
                ->groupBy(['sector_n1_id', 'manager_n1_id', 'manager_n2_id', 'manager_n3_id', 'manager_n4_id', 'manager_n5_id', 'manager_n6_id'])
                ->get(['sector_n1_id', 'manager_n1_id', 'manager_n2_id', 'manager_n3_id', 'manager_n4_id', 'manager_n5_id', 'manager_n6_id'])
                ->toArray();
        } catch (\Throwable $th) {
            return Command::FAILURE;
        }

        GipManagerSectorN1::query()->truncate();

        foreach ($data as $value) {
            GipManagerSectorN1::create($value);
        }

        return Command::SUCCESS;
    }
}
