<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sys\GipDaily ;
use App\Models\SourceGipConsQuadroUnificado;

class gip extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
             $date = date('Y-m-d');
            //  $date = date('Y-m-d ', strtotime(date('Y-m-d')));

           GipDaily::where('ref',$date )->delete();

      
            //Pega a Base do GIP da Tahto
                $data =  SourceGipConsQuadroUnificado::get([
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
                ])->unique('id')
                ->toArray();

            //Percorre a base fazendo as devidas tratativas    
            $objTemp = [];
            foreach ($data as $value) {

                $objTemp['ref'] = $date;
                $objTemp['id'] = 'bc' . $value['id'];
                $objTemp['name'] = mb_convert_case($value['name'], MB_CASE_TITLE, 'UTF-8');
                $objTemp['uf'] = $value['uf'];
                $objTemp['position'] = mb_convert_case($value['position'], MB_CASE_TITLE, 'UTF-8');
                $objTemp['position_summary'] = mb_convert_case($value['position_summary'], MB_CASE_TITLE, 'UTF-8');
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
                $objTemp['status'] =  $value['dt_resc'] ? 0 : 1;
                $objTemp['status_gip'] = mb_convert_case($value['status_gip'], MB_CASE_TITLE, 'UTF-8');
                $objTemp['status_op'] = mb_convert_case($value['st_op'], MB_CASE_TITLE, 'UTF-8');                

                $objTemp['training'] = $value['st_op'] ==  'ATIVO NO TR INICIAL' ? 'inicial' : null;               
                $objTemp['training'] = $value['st_op'] ==  'ATIVO NO TR MIGRAÇÃO' ? 'migração' : $objTemp['training'] ;               
                $objTemp['training'] = $value['st_op'] ==  'ATIVO NO TR RECICLAGEM' ? 'reciclagem' : $objTemp['training'] ;               
                $objTemp['training'] = $value['st_op'] ==  'ATIVO NO TR RETORNO AFAST' ? 'retorno' : $objTemp['training'] ;  
                
                
                $capacityPosition = ['AGENTE','JOVEM APRENDIZ'];
                $capacityStatus  = ['ATIVIDADE NORMAL','AFAST. DOENCA MENOR 15 DIAS'];

                if( in_array( $value['position_summary'], $capacityPosition) && in_array($value['status_gip'], $capacityStatus) ){
                    $objTemp['capacity']  = 1;
                }else {
                    $objTemp['capacity']  = 0;
                };

                if( in_array( $value['position_summary'], $capacityPosition) && strpos( $value['status_gip'], 'FERIAS' ) !== false  ){
                    $objTemp['vacation']  = 1;
                }else {
                    $objTemp['vacation']  = 0;
                };

                $objTemp['training'] = '';
                
                try {
                    GipDaily::create($objTemp);
                    //code...
                } catch (\Throwable $th) {
                    throw $th;
                }
                
                $objTemp = [];
            }
           
            // return   $objTemp;
       
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
