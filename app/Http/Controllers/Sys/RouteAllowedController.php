<?php

namespace App\Http\Controllers\Sys;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sys\RoutePermission;
use App\Models\Sys\App;
use App\Models\Sys\MenuN2;
use Illuminate\Support\Facades\Route;
// use App\Models\Sys\MenuN1;
// use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Artisan;


class RouteAllowedController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
        try {
            $route = $request['check'] ? $request['check'] : '';
            $menuN2Id = MenuN2::where('route_api', $route)->first()->id;
            $routeApi = App::where('menu_n2_id', $menuN2Id)->get('route_api');

            $routes = $routeApi->map(function ($item, $key) {
                return $item['route_api'];
            });
        } catch (\Throwable $th) {
            $routes = null;
        }
      
        // $userRoles = RoutePermission::userRules();

        // $routes = $routes ? $routes : [Route::getCurrentRoute()->getName()];
        // $routeName = [Route::getCurrentRoute()->getName()];

        // //verifica se o usuário possue permissão de acesso
        // $permission = RoutePermission::whereRaw($userRoles['where'],  $userRoles['search'])
        //     // ->whereRaw('? like route_name', [$routeName])
        //     ->where(function ($query) use ($routes) {
        //         foreach ($routes as $key => $route) {
        //             $key == 0 ? $query->where('route_name', 'like', $route) : $query->orWhere('route_name', 'like', $route);
        //         };
                
        //     })
        //     ->get();
        // return $permission;

       
        // return RoutePermission::accesses($request->check);
        // return RoutePermission::accesses();
        return RoutePermission::accesses($routes);
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
        // Pega os filtros de regra para permissão de acessos
        $userRoles = RoutePermission::userRules();

        // Adciona a regra e o filtro de rota
        $userRoles['where'] = $userRoles['where'] . ' and ? like route_name';
        array_push($userRoles['search'], $id);

        //lista as rotas liberadas para o usuário
        $routes = RoutePermission::whereRaw($userRoles['where'],  $userRoles['search'])
            ->where('allowed', '1')
            ->get(['route_name', 'allowed']);

        // Se não for encontrado regra traz 0
        $allowed = !empty($routes['allowed']) ? $routes['allowed'] :  0;
        return $allowed;
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
