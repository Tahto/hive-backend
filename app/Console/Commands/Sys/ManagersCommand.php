<?php

namespace App\Console\Commands\Sys;

use Illuminate\Console\Command;
use App\Models\Sys\User;
use App\Models\Sys\UserManagerN6;
use App\Models\Sys\UserManagerN5;
use App\Models\Sys\UserManagerN4;
use App\Models\Sys\UserManagerN3;
use App\Models\Sys\UserManagerN2;
use App\Models\Sys\UserManagerN1;

class ManagersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'managers:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza lista de gestores';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {

            // Manager N6
            UserManagerN6::query()->truncate();
            $managersN6 = user::where('HIERARCHICAL_LEVEL', '6')->get(['id', 'name', 'status', 'hierarchical_level'])->toArray();
            foreach ($managersN6 as $value) {
                UserManagerN6::create($value);
            }

           // Manager N5
            UserManagerN5::query()->truncate();
            $managersN5 = user::where('HIERARCHICAL_LEVEL', '5')->get(['id', 'name', 'status', 'hierarchical_level', 'manager_n6_id',])->toArray();
            foreach ($managersN5 as $value) {
                UserManagerN5::create($value);
            }

            // Manager N4
            UserManagerN4::query()->truncate();
            $managersN4 = user::where('HIERARCHICAL_LEVEL', '4')->get(['id', 'name', 'status', 'hierarchical_level', 'manager_n6_id', 'manager_n5_id'])->toArray();
            foreach ($managersN4 as $value) {
                UserManagerN4::create($value);
            }

            // Manager N3
            UserManagerN3::query()->truncate();
            $managersN3 = user::where('HIERARCHICAL_LEVEL', '3')->get(['id', 'name', 'status', 'hierarchical_level', 'manager_n6_id', 'manager_n5_id', 'manager_n4_id'])->toArray();
            foreach ($managersN3 as $value) {
                UserManagerN3::create($value);
            }

            // Manager N2
            UserManagerN2::query()->truncate();
            $managersN2 = user::where('HIERARCHICAL_LEVEL', '2')->get(['id', 'name', 'status', 'hierarchical_level', 'manager_n6_id', 'manager_n5_id', 'manager_n4_id', 'manager_n3_id'])->toArray();
            foreach ($managersN2 as $value) {
                UserManagerN2::create($value);
            }

            // Manager N1
            UserManagerN1::query()->truncate();
            $managersN1 = user::where('HIERARCHICAL_LEVEL', '1')->get(['id', 'name', 'status', 'hierarchical_level', 'manager_n6_id', 'manager_n5_id', 'manager_n4_id', 'manager_n3_id', 'manager_n2_id'])->toArray();
            foreach ($managersN1 as $value) {
                UserManagerN1::create($value);
            }
            // UserManagerN5::insert($managersN5);
            // UserManagerN4::insert($managersN4);
            // UserManagerN3::insert($managersN3);
            // UserManagerN2::insert($managersN2);
            // UserManagerN1::insert($managersN1);
        } catch (\Throwable $th) {

            return Command::FAILURE;
        }


        return Command::SUCCESS;
    }
}
