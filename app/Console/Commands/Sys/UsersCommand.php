<?php

namespace App\Console\Commands\Sys;

use Illuminate\Console\Command;
use App\Models\Sys\User;
use App\Models\SourceGipConsQuadroUnificado;
use Illuminate\Support\Facades\Hash;

class UsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza base de funcionários do GIP (dados em d-5 do DT_ULTIMA_ATUALIZACAO)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = date('Y-m-d ', strtotime(date('Y-m-d') . ' -30 day'));

        try {
            //Pega a Base do GIP da Tahto
            $data =  SourceGipConsQuadroUnificado::
                get([
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
                    'status_gip as status_real',
                    'dt_resc',
                    'dt_adm'
                ])->unique('id')
                ->toArray();
            $hash = Hash::make('123456');


            //Percorre a base fazendo as devidas tratativas    
            foreach ($data as $value) {
                $value['id'] = 'bc' . $value['id'];
                $value['manager_n1_id'] = 'bc' . $value['manager_n1_id'];
                $value['manager_n2_id'] = 'bc' . $value['manager_n2_id'];
                $value['manager_n3_id'] = 'bc' . $value['manager_n3_id'];
                $value['manager_n4_id'] = 'bc' . $value['manager_n4_id'];
                $value['manager_n5_id'] = 'bc' . $value['manager_n5_id'];
                $value['manager_n6_id'] = 'bc756399'; // Temporariamente, setar a Matricula do CO Atual 

                $obj = User::find($value['id']) ? User::find($value['id']) : new User($value);

                $obj['name'] = ucfirstException($value['name']);
                $obj['uf'] = $value['uf'];
                $obj['position'] = ucfirstException($value['position']);
                $obj['position_summary'] = ucfirstException($value['position_summary']);
                $obj['sector_n1_id'] = $value['sector_n1_id'];
                $obj['sector_n2_id'] = $value['sector_n2_id'] == 0 ? null : $value['sector_n2_id'];
                $obj['manager_n1_id'] = $value['manager_n1_id'];
                $obj['manager_n2_id'] = $value['manager_n2_id'];
                $obj['manager_n3_id'] = $value['manager_n3_id'];
                $obj['manager_n4_id'] = $value['manager_n4_id'];
                $obj['manager_n5_id'] = $value['manager_n5_id'];
                $obj['manager_n6_id'] = $value['manager_n6_id'];
                $obj['status_real'] = ucfirstException($value['status_real']);
                $obj['hierarchical_level'] = 0;
                $obj['hierarchical_level'] = $value['id'] == $obj['manager_n1_id'] ? 1 : $obj['hierarchical_level'];
                $obj['hierarchical_level'] = $value['id'] == $obj['manager_n2_id'] ? 2 : $obj['hierarchical_level'];
                $obj['hierarchical_level'] = $value['id'] == $obj['manager_n3_id'] ? 3 : $obj['hierarchical_level'];
                $obj['hierarchical_level'] = $value['id'] == $obj['manager_n4_id'] ? 4 : $obj['hierarchical_level'];
                $obj['hierarchical_level'] = $value['id'] == $obj['manager_n5_id'] ? 5 : $obj['hierarchical_level'];
                $obj['hierarchical_level'] = $value['id'] == $obj['manager_n6_id'] ? 6 : $obj['hierarchical_level'];
                $obj['type'] =  'bc';
                $obj['status'] = $value['dt_resc'] && str_contains( $value['status_real'] , 'RESC' )  ? 0 : 1;
                $obj['email'] = $value['id'] . '@oicorp.mail.onmicrosoft.com';
                $obj['password'] = $hash;
                // print_r(  $obj);
                $obj->save();
            }
        } catch (\Throwable $th) {

            return 'Command::FAILURE';
        }

        return 'Command::SUCCESS';
    }
}
