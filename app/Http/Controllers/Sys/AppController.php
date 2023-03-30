<?php

namespace App\Http\Controllers\Sys;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sys\App;
use App\Traits\ApiResponser;
use App\Http\Requests\Sys\AppRequest;
use App\Http\Functions\ListFunctions;

class AppController extends Controller
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
            $return = App::with('sysMenuN2')
                ->whereRaw($where, $search)
                ->orderByRaw($orderBy)
                ->paginate($paginate)
                ->onEachSide(0);
        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao gerar lista', 422);
        }

        return  $this->success($return,);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AppRequest $request)
    {
        $payload = $request->all();

       
        try {
            $create = App::create($payload);
           
        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao salvar dados', 422);
        }

        return $this->success([$create]);
        
    }

    /**
     * Display the specified resource.
     *
    * @param  \App\Models\Sys\App  $app
     * @return \Illuminate\Http\Response
     */
    public function show(App $app)
    {
        try {
            $app = $app->with('sysMenuN2')->get();
        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao salvar dados', 422);
        }

        return $this->success([$app]);
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
    * @param  \App\Models\App  $app
     * @return \Illuminate\Http\Response
     */
    public function update(AppRequest $request, App $app)
    {
       
        try {
            $app['menu_n2_id'] = $request['menu_n2_id'];
            $app['title'] = $request['title'];
            $app['status'] = $request['status'];
            $app['route_api'] = $request['route_api'];
            $app->save();
        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao salvar dados', 422);
        }
        return  $this->success($app,);
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
