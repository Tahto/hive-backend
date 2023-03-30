<?php

namespace App\Http\Controllers\Sys;

use App\Models\Sys\MenuN2;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Http\Functions\ListFunctions;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sys\MenuN2Request;

class MenuN2Controller extends Controller
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
            // $users = MenuN2::with('sysApp')
            $users = MenuN2::with('sysMenuN1')
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
    public function store(MenuN2Request $request)
    {
        $payload = $request->all();
        $payload['order'] = 1;

        try {
            $menuN1 = MenuN2::create($payload);
            
        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao salvar dados', 422);
        }

        return $this->success([$menuN1]);
     
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MenuN2  $menuN2
     * @return \Illuminate\Http\Response
     */
    public function show(MenuN2 $menuN2)
    {
       
        try {
            $MenuN2 = $menuN2->with('sysMenuN1')->find($menuN2->id);
        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao salvar dados', 422);
        }

        return $this->success([$MenuN2]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MenuN2  $menuN2
     * @return \Illuminate\Http\Response
     */
    public function update(MenuN2Request $request, MenuN2 $menuN2)
    {
        try {
            $menuN2['menu_n1_id'] = $request['menu_n1_id'];
            $menuN2['title'] = $request['title'];
            $menuN2['icon'] = $request['icon'];
            $menuN2['to'] = $request['to'];
            $menuN2['status'] = $request['status'];
            $menuN2['route_api'] = $request['route_api'];
            $menuN2->save();
        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao salvar dados', 422);
        }
        return  $this->success($menuN2,);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MenuN2  $MenuN2
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuN2 $MenuN2)
    {
        //
    }
}
