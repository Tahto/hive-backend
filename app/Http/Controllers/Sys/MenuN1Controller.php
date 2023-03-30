<?php

namespace App\Http\Controllers\Sys;

use App\Models\Sys\MenuN1;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Functions\ListFunctions;
use App\Http\Requests\Sys\MenuN1Request;

class MenuN1Controller extends Controller
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
            $orderBy  = ListFunctions::orderBy($request, 'title asc'); // Importante!!! Definir ordenação padrão
            $paginate = ListFunctions::paginate($request);
            $users = MenuN1::with('sysModule')
                ->whereRaw($where, $search)
                ->orderByRaw($orderBy)
                ->paginate($paginate)
                ->onEachSide(0);
        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao gerar lista', 422);
        }

        return  $this->success($users,);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuN1Request $request)
    {
        $payload = $request->all();
        $payload['order'] = 1;

        try {
            $menuN1 = MenuN1::create($payload);
        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao salvar dados', 422);
        }

        return $this->success([$menuN1]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sys\MenuN1  $menuN1
     * @return \Illuminate\Http\Response
     */
    public function show(MenuN1 $menuN1)
    {
        try {
            $MenuN1 = $menuN1->with('sysMenuN2')->get();
        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao salvar dados', 422);
        }

        return $this->success([$MenuN1]);
       
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sys\MenuN1  $menuN1
     * @return \Illuminate\Http\Response
     */
    public function update(MenuN1Request $request, MenuN1 $menuN1)
    {
        try {
            $menuN1['module_id'] = $request['module_id'];
            $menuN1['title'] = $request['title'];
            $menuN1['icon'] = $request['icon'];
            $menuN1['to'] = $request['to'];
            $menuN1['status'] = $request['status'];
            $menuN1['route_api'] = $request['route_api'];
            $menuN1->save();
        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao salvar dados', 422);
        }
        return  $this->success($menuN1,);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sys\MenuN1  $menuN1
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuN1 $menuN1)
    {
        //
    }
}
