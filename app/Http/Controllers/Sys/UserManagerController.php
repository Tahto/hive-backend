<?php

namespace App\Http\Controllers\Sys;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\DB;
// use App\Http\Functions\ListFunctions;
use App\Models\Sys\GipManagerSectorN1;
use App\Models\Sys\User;
use App\Models\Sys\UserManagerN6;
use App\Models\Sys\UserManagerN5;
use App\Models\Sys\UserManagerN4;
use App\Models\Sys\UserManagerN3;
use App\Models\Sys\UserManagerN2;
use App\Models\Sys\UserManagerN1;


class UserManagerController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // return 1;
        try {
          $userManager = User::orderBy('name', 'asc')->get(['id', 'name', 'manager_n6_id', 'manager_n5_id', 'manager_n4_id', 'manager_n3_id', 'manager_n2_id', 'manager_n1_id', 'sector_n1_id', 'sector_n2_id','status']);
        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao gerar lista', 422);
        }

        return  $this->success($userManager,);
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

        try {
            UserManagerN1::query()->truncate();
            UserManagerN2::query()->truncate();
            UserManagerN3::query()->truncate();
            UserManagerN4::query()->truncate();
            UserManagerN5::query()->truncate();
            UserManagerN6::query()->truncate();

            $managersN6 = user::where('HIERARCHICAL_LEVEL', '6')->get(['id', 'name', 'status', 'hierarchical_level'])->toArray();
            $managersN5 = user::where('HIERARCHICAL_LEVEL', '5')->get(['id', 'name', 'status', 'hierarchical_level', 'manager_n6_id',])->toArray();
            $managersN4 = user::where('HIERARCHICAL_LEVEL', '4')->get(['id', 'name', 'status', 'hierarchical_level', 'manager_n6_id', 'manager_n5_id'])->toArray();
            $managersN3 = user::where('HIERARCHICAL_LEVEL', '3')->get(['id', 'name', 'status', 'hierarchical_level', 'manager_n6_id', 'manager_n5_id', 'manager_n4_id'])->toArray();
            $managersN2 = user::where('HIERARCHICAL_LEVEL', '2')->get(['id', 'name', 'status', 'hierarchical_level', 'manager_n6_id', 'manager_n5_id', 'manager_n4_id', 'manager_n3_id'])->toArray();
            $managersN1 = user::where('HIERARCHICAL_LEVEL', '1')->get(['id', 'name', 'status', 'hierarchical_level', 'manager_n6_id', 'manager_n5_id', 'manager_n4_id', 'manager_n3_id', 'manager_n2_id'])->toArray();

            UserManagerN6::insert($managersN6);
            UserManagerN5::insert($managersN5);
            UserManagerN4::insert($managersN4);
            UserManagerN3::insert($managersN3);
            UserManagerN2::insert($managersN2);
            UserManagerN1::insert($managersN1);

        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao gravar', 422);
        }

        return  $this->success('Carga finalizada',);
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
