<?php

namespace App\Http\Controllers\Sys;

use App\Models\Sys\Module;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use App\Http\Functions\ListFunctions;
use App\Http\Requests\Sys\ModuleRequest;


class ModuleController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     

        // return Module::with('sysMenuN1.sysMenuN2')->get();
        try {
            $where = ListFunctions::where($request);
            $search  = ListFunctions::search($request);
            $orderBy  = ListFunctions::orderBy($request, 'title asc'); // Importante!!! Definir ordenação padrão
            $paginate = ListFunctions::paginate($request);;
            $result = Module::with('sysMenuN1.sysMenuN2.sysApp')
                            ->select(['id','title','icon','to','status','description'])
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
    public function store(ModuleRequest $request)
    {
       
        $payload = $request->all();
        $payload['order'] = 1;


        try {
            $module = Module::create($payload);
            if ($request->has('menuN1')) {
                $module->sysMenuN1()->createMany($request->menuN1);
            }
        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao salvar dados', 422);
        }

        return $this->success([$module]);
        // return $this->success('[$module]');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sys\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function show(Module $module)
    {
              
        try {
            $Module = $module->with('sysMenuN1')->find($module->id);
        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao salvar dados', 422);
        }

        return $this->success([$Module]);
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sys\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function edit(Module $module)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sys\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function update(ModuleRequest $request, Module $module)
    {
        try {
            $module['title'] = $request['title'];
            $module['icon'] = $request['icon'];
            $module['to'] = $request['to'];
            $module['status'] = $request['status'];
            $module->save();
        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao salvar dados', 422);
        }
        return  $this->success($module,);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sys\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function destroy(Module $module)
    {
        //
    }
}
