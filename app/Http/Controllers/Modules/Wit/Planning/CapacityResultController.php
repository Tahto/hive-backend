<?php

namespace App\Http\Controllers;

use App\Models\Modules\Wit\Planning\CapacityResult;
use Illuminate\Http\Request;
use App\Models\SourceGipConsQuadroUnificado;

class CapacityResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return  $data =  SourceGipConsQuadroUnificado::
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
     * @param  \App\Models\Modules\Wit\Planning\CapacityResult  $capacityResult
     * @return \Illuminate\Http\Response
     */
    public function show(CapacityResult $capacityResult)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Modules\Wit\Planning\CapacityResult  $capacityResult
     * @return \Illuminate\Http\Response
     */
    public function edit(CapacityResult $capacityResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Modules\Wit\Planning\CapacityResult  $capacityResult
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CapacityResult $capacityResult)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Modules\Wit\Planning\CapacityResult  $capacityResult
     * @return \Illuminate\Http\Response
     */
    public function destroy(CapacityResult $capacityResult)
    {
        //
    }
}
