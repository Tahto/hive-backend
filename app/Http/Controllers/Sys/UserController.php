<?php

namespace App\Http\Controllers\Sys;

use App\Models\Sys\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Functions\ListFunctions;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

use App\Models\SourceGipConsQuadroUnificado;

class UserController extends Controller
{
    use ApiResponser;

    public function index(Request $request)
    {
        try {
            $where = ListFunctions::where($request);
            $search  = ListFunctions::search($request);
            $orderBy  = ListFunctions::orderBy($request, 'name asc'); // Importante!!! Definir ordenação padrão
            $paginate = ListFunctions::paginate($request);;
            $users = User::whereRaw($where, $search)->orderByRaw($orderBy)->paginate($paginate)->onEachSide(0);
        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao gerar lista', 422);
        }

        return  $this->success($users,);
    }


    public function store(Request $request)
    {

       $date = date('Y-m-d ',strtotime(date('Y-m-d'). ' -5 day'));

        try {
            //Pega a Base do GIP da Tahto
            $dados =  SourceGipConsQuadroUnificado::
                whereRaw("TO_CHAR(DT_ADM, 'YYYY-MM-DD') >= ?
                          OR TO_CHAR(DT_ULTIMA_ATUALIZACAO, 'YYYY-MM-DD') >= ?", [$date,$date])
              -> get([
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
                // $listings->whereRaw('CAST(number_of_floors as DECIMAL(9,2)) = ?', [1]);
            $hash = Hash::make('123456');

            
            //Percorre a base fazendo as devidas tratativas    
            foreach ($dados as $value) {
                $value['id'] = 'bc' . $value['id'];
                $value['manager_n1_id'] = 'bc' . $value['manager_n1_id'];
                $value['manager_n2_id'] = 'bc' . $value['manager_n2_id'];
                $value['manager_n3_id'] = 'bc' . $value['manager_n3_id'];
                $value['manager_n4_id'] = 'bc' . $value['manager_n4_id'];
                $value['manager_n5_id'] = 'bc' . $value['manager_n5_id'];
                $value['manager_n6_id'] = 'bc756399'; // Temporariamente, setar a Matricula do CO Atual 

                $obj = User::find($value['id']) ? User::find($value['id']) : new User($value);

                $obj['name'] = mb_convert_case($value['name'], MB_CASE_TITLE, 'UTF-8');
                $obj['uf'] = $value['uf'];
                $obj['position'] = mb_convert_case($value['position'], MB_CASE_TITLE, 'UTF-8');
                $obj['position_summary'] = mb_convert_case($value['position_summary'], MB_CASE_TITLE, 'UTF-8');
                $obj['sector_n1_id'] = $value['sector_n1_id'];
                $obj['sector_n2_id'] = $value['sector_n2_id'] == 0 ? null : $value['sector_n2_id'];
                $obj['manager_n1_id'] = $value['manager_n1_id'];
                $obj['manager_n2_id'] = $value['manager_n2_id'];
                $obj['manager_n3_id'] = $value['manager_n3_id'];
                $obj['manager_n4_id'] = $value['manager_n4_id'];
                $obj['manager_n5_id'] = $value['manager_n5_id'];
                $obj['manager_n6_id'] = $value['manager_n6_id'];
                $obj['status_real'] = mb_convert_case($value['status_real'], MB_CASE_TITLE, 'UTF-8');
                $obj['hierarchical_level'] = 0;
                $obj['hierarchical_level'] = $value['id'] == $obj['manager_n1_id'] ? 1 : $obj['hierarchical_level'];
                $obj['hierarchical_level'] = $value['id'] == $obj['manager_n2_id'] ? 2 : $obj['hierarchical_level'];
                $obj['hierarchical_level'] = $value['id'] == $obj['manager_n3_id'] ? 3 : $obj['hierarchical_level'];
                $obj['hierarchical_level'] = $value['id'] == $obj['manager_n4_id'] ? 4 : $obj['hierarchical_level'];
                $obj['hierarchical_level'] = $value['id'] == $obj['manager_n5_id'] ? 5 : $obj['hierarchical_level'];
                $obj['hierarchical_level'] = $value['id'] == $obj['manager_n6_id'] ? 6 : $obj['hierarchical_level'];
                $obj['type'] =  'bc';
                $obj['status'] =  $value['dt_resc'] ? 0 : 1;
                $obj['email'] = $value['id'] . '@oicorp.mail.onmicrosoft.com';
                $obj['password'] = $hash;
                // print_r(  $obj);
                $obj->save();
            }
        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao salvar dados ', 422);
        }
        return  $this->success('Dados Salvados',);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sys\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        // $response = Http::withOptions([
        //     'proxy' => 'http://SPANM6001:5sqLK7cc@10.35.150.40:82'
        //  ])->get('http://fotoparacracha.oiservicos.com.br/api/photo',['matricula' => '759292']);
        return  $user;

        // return $response['Imagem'];
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sys\User  $gip_Quadro_Unificado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sys\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
