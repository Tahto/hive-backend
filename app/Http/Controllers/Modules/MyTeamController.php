<?php

namespace App\Http\Controllers\Modules;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sys\User;
use App\Http\Functions\ListFunctions;

class MyTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = [auth()->user()->id];   
               
        $whereManager = '  ? in (manager_n1_id, manager_n2_id, manager_n3_id, manager_n4_id, manager_n5_id, manager_n6_id) ';

        try {
            $where = ListFunctions::where($request);
            $search  = ListFunctions::search($request);
            $orderBy  = ListFunctions::orderBy($request, 'name asc'); // Importante!!! Definir ordenação padrão
            $paginate = ListFunctions::paginate($request);;
            $users = User::with(['sectorN1','managerN1'])
            ->whereRaw($where, $search)
            ->whereRaw($whereManager, $id)
            ->orderByRaw($orderBy)->paginate($paginate)->onEachSide(0);
        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao gerar lista', 422);
        }

        return  $users ;
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
