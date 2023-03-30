<?php

namespace App\Http\Controllers\Sys;

use App\Http\Controllers\Controller;
use App\Models\Sys\UserManagerN6;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;

class UserManagerN6Controller extends Controller
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
            $userManager = UserManagerN6::orderBy('name', 'asc')->get(['id', 'name', 'status', 'hierarchical_level']);
           
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
     * @param  \App\Models\Sys\UserManagerN6  $UserManagerN6
     * @return \Illuminate\Http\Response
     */
    public function show(UserManagerN6 $UserManagerN6)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sys\UserManagerN6  $UserManagerN6
     * @return \Illuminate\Http\Response
     */
    public function edit(UserManagerN6 $UserManagerN6)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sys\UserManagerN6  $UserManagerN6
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserManagerN6 $UserManagerN6)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sys\UserManagerN6  $UserManagerN6
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserManagerN6 $UserManagerN6)
    {
        //
    }
}
