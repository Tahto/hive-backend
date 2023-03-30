<?php

namespace App\Http\Controllers\Sys;

use App\Models\Sys\GipSectorN1;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Models\SourceGipConsQuadroUnificado;
use App\Http\Functions\ListFunctions;

class GipSectorN1Controller extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
        try {
            $where = ListFunctions::where($request);
            $search  = ListFunctions::search($request);
            $orderBy  = ListFunctions::orderBy($request, 'name asc'); // Importante!!! Definir ordenação padrão
            $paginate = ListFunctions::paginate($request);;
            $result = GipSectorN1::with('sysSectorN2')
                            ->select(['id','name','uf'])
                            ->whereRaw($where, $search)
                            ->orderByRaw($orderBy)
                            ->paginate($paginate)
                            ->onEachSide(0);
        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao gerar lista', 422);
        }

        return  $this->success($result,);
        
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dados =  SourceGipConsQuadroUnificado::whereNotNull('cod_dpto')
            ->get(['cod_dpto as id', 'dpto as name', 'uf'])
            ->unique('id')
            ->toArray();

        // return $dados;
        foreach ($dados as $value) {
            $obj = GipSectorN1::find($value['id']) ? GipSectorN1::find($value['id']) : new GipSectorN1($value);

            $obj['name'] = mb_convert_case($value['name'], MB_CASE_TITLE, 'UTF-8');
            $obj['uf'] = $value['uf'];

            $obj->save();
        }


        return $dados;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sys\GipSectorN1  $sectorN1
     * @return \Illuminate\Http\Response
     */
    public function show(GipSectorN1 $sectorN1)
    {
        return $sectorN1;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sys\GipSectorN1  $gipSectorN1
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GipSectorN1 $gipSectorN1)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sys\GipSectorN1  $gipSectorN1
     * @return \Illuminate\Http\Response
     */
    public function destroy(GipSectorN1 $gipSectorN1)
    {
        //
    }
}
