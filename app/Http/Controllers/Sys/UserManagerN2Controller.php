<?php

namespace App\Http\Controllers\Sys;

use App\Http\Controllers\Controller;
use App\Models\Sys\UserManagerN2;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;

class UserManagerN2Controller extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //    return 1;
           try {
            $userManager = UserManagerN2::orderBy('name', 'asc')->get(['id', 'name', 'status', 'hierarchical_level','manager_n6_id', 'manager_n5_id', 'manager_n4_id', 'manager_n3_id']);
           
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sys\UserManagerN2  $UserManagerN2
     * @return \Illuminate\Http\Response
     */
    public function show(UserManagerN2 $UserManagerN2)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sys\UserManagerN2  $UserManagerN2
     * @return \Illuminate\Http\Response
     */
    public function edit(UserManagerN2 $UserManagerN2)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sys\UserManagerN2  $UserManagerN2
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserManagerN2 $UserManagerN2)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sys\UserManagerN2  $UserManagerN2
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserManagerN2 $UserManagerN2)
    {
        //
    }
}
