<?php

namespace App\Http\Controllers\Sys;

use App\Models\Sys\Module;
use App\Models\Sys\RoutePermission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use App\Http\Requests\Sys\RoutePermissionRequest;
use App\Http\Functions\ListFunctions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class RoutePermissionController extends Controller
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
            $orderBy  = ListFunctions::orderBy($request, 'id asc'); // Importante!!! Definir ordenação padrão
            $paginate = ListFunctions::paginate($request);
            $result = RoutePermission::with('sysApp.sysMenuN2.sysMenuN1.sysModule')
                ->select([
                    'id', 
                    'route_name',
                    'user_id',
                    'sector_n1_id',
                    'sector_n2_id',
                    'manager_n1_id',
                    'manager_n2_id',
                    'manager_n3_id',
                    'manager_n4_id',
                    'manager_n5_id',
                    'manager_n6_id',
                    'hierarchical_level',
                    'type',
                    'allowed'
                ])
                ->whereRaw($where, $search)
                ->orderByRaw($orderBy)
                ->paginate($paginate)
                ->onEachSide(0);
            // $result = $result = RoutePermission::select(
            //     "sys_route_permissions.id",
            //     "sys_route_permissions.route_name",
            //     "sys_modules.id as module_id",
            //     "sys_modules.title as module_title",
            //     "sys_menus_n1.id as menu_n1_id",
            //     "sys_menus_n1.title as menu_n1_title",
            //     "sys_menus_n2.id as menu_n2_id",
            //     "sys_menus_n2.title as menu_n2_title",
            //     'sys_apps.id as app_id',
            //     'sys_apps.title as app_title',
            //     "sys_route_permissions.user_id",
            //     'sys_users.name as user_name',
            //     "sys_route_permissions.sector_n1_id",
            //     "sys_gip_sectors_n1.name as sector_n1_name ",
            //     "sys_route_permissions.sector_n2_id",
            //     "sys_gip_sectors_n2.name as sector_n2_name ",
            //     "sys_route_permissions.manager_n1_id",
            //     "mn1.name as manager_n1_name",
            //     "sys_route_permissions.manager_n2_id",
            //     "mn2.name as manager_n2_name",
            //     "sys_route_permissions.manager_n3_id",
            //     "mn3.name as manager_n3_name",
            //     "sys_route_permissions.manager_n4_id",
            //     "mn4.name as manager_n4_name",
            //     "sys_route_permissions.manager_n5_id",
            //     "mn5.name as manager_n5_name",
            //     "sys_route_permissions.manager_n6_id",
            //     "mn6.name as manager_n6_name",
            //     "sys_route_permissions.hierarchical_level",
            //     "sys_route_permissions.type",
            //     "sys_route_permissions.allowed",

            // )
            //     ->leftJoin('sys_apps', 'sys_route_permissions.route_name', '=', 'sys_apps.route_api')
            //     ->leftJoin('sys_menus_n2', function ($join) {
            //         $join->on('sys_apps.menu_n2_id', '=', 'sys_menus_n2.id');
            //         $join->orOn('sys_route_permissions.route_name', '=', 'sys_menus_n2.to');
            //     })
            //     ->leftJoin('sys_menus_n1', 'sys_menus_n2.menu_n1_id', '=', 'sys_menus_n1.id')
            //     ->leftJoin('sys_modules', 'sys_menus_n1.module_id', '=', 'sys_modules.id')
            //     ->leftJoin('sys_users', 'sys_route_permissions.user_id', '=', 'sys_users.id')
            //     ->leftJoin('sys_gip_sectors_n1', 'sys_route_permissions.sector_n1_id', '=', DB::raw("TO_CHAR(sys_gip_sectors_n1.id)"))
            //     ->leftJoin('sys_gip_sectors_n2', 'sys_route_permissions.sector_n2_id', '=', DB::raw("TO_CHAR(sys_gip_sectors_n2.id)"))
            //     ->leftJoin('sys_users as mn1', 'sys_route_permissions.manager_n1_id', '=', 'mn1.id')
            //     ->leftJoin('sys_users as mn2', 'sys_route_permissions.manager_n2_id', '=', 'mn2.id')
            //     ->leftJoin('sys_users as mn3', 'sys_route_permissions.manager_n3_id', '=', 'mn3.id')
            //     ->leftJoin('sys_users as mn4', 'sys_route_permissions.manager_n4_id', '=', 'mn4.id')
            //     ->leftJoin('sys_users as mn5', 'sys_route_permissions.manager_n5_id', '=', 'mn5.id')
            //     ->leftJoin('sys_users as mn6', 'sys_route_permissions.manager_n6_id', '=', 'mn6.id')
            // ->whereRaw($where, $search)
            // ->orderByRaw($orderBy)
            // ->paginate($paginate)
            // ->onEachSide(0);
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
    public function store(RoutePermissionRequest $request)
    {
        $payload = $request->all();
        try {
            $route = RoutePermission::create($payload);
        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao salvar dados', 422);
        }
        return $this->success([$route]);
        // return $this->success([$payload]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RoutePermission  $RoutePermission
     * @return \Illuminate\Http\Response
     */
    public function show(RoutePermission $RoutePermission)
    {

        return RoutePermission::find('route_name', 'auth.login');
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RoutePermission  $RoutePermission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RoutePermission $RoutePermission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RoutePermission  $RoutePermission
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoutePermission $RoutePermission)
    {
        //
    }
}
