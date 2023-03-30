<?php

namespace App\Http\Controllers\Sys;

use Illuminate\Http\Request;
use App\Models\Sys\GipSectorN2;
use App\Http\Controllers\Controller;
use App\Models\SourceGipConsQuadroUnificado;

class GipSectorN2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return  GipSectorN2::all();
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
        $dados =  SourceGipConsQuadroUnificado::orderBy('id', 'asc')
            ->whereNotNull('cod_sub_setor')
            ->where('cod_sub_setor','<>',0)
            ->get(['cod_sub_setor as id', 'cod_dpto as sector_n2_id', 'sub_setor as name', 'uf'])
            ->unique('id')
            ->toArray();
            // dd($dados);

        foreach($dados as $value)
        {
            $obj = GipSectorN2::find($value['id']) ? GipSectorN2::find($value['id']) : new GipSectorN2($value);
            
            $obj['name'] = mb_convert_case($value['name'], MB_CASE_TITLE , 'UTF-8' );
            $obj['uf'] = $value['uf'];
            $obj['sector_n2_id'] = $value['sector_n2_id'];

            $obj ->save();
        }

        // return  $dados;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sys\GipSectorN2  $sectorN2
     * @return \Illuminate\Http\Response
     */
    public function show(GipSectorN2 $sectorN2)
    {
        return $sectorN2;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sys\GipSectorN2  $GipSectorN2
     * @return \Illuminate\Http\Response
     */
    public function edit(GipSectorN2 $GipSectorN2)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sys\GipSectorN2  $GipSectorN2
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GipSectorN2 $GipSectorN2)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sys\GipSectorN2  $GipSectorN2
     * @return \Illuminate\Http\Response
     */
    public function destroy(GipSectorN2 $GipSectorN2)
    {
        //
    }
}
