<?php

namespace App\Http\Controllers\Sys;

use App\Http\Controllers\Controller;
use App\Models\Sys\UserManagerN5;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;

class UserManagerN5Controller extends Controller
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
            $userManager = UserManagerN5::orderBy('name', 'asc')->get(['id', 'name', 'status', 'hierarchical_level','manager_n6_id']);
           
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
     * @param  \App\Models\Sys\UserManagerN5  $UserManagerN5
     * @return \Illuminate\Http\Response
     */
    public function show(UserManagerN5 $UserManagerN5)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sys\UserManagerN5  $UserManagerN5
     * @return \Illuminate\Http\Response
     */
    public function edit(UserManagerN5 $UserManagerN5)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sys\UserManagerN5  $UserManagerN5
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserManagerN5 $UserManagerN5)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sys\UserManagerN5  $UserManagerN5
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserManagerN5 $UserManagerN5)
    {
        //
    }
}
