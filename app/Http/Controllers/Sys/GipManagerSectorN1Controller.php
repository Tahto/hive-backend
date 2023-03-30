<?php

namespace App\Http\Controllers\Sys;

use App\Models\Sys\GipManagerSectorN1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sys\User;
use App\Traits\ApiResponser;

class GipManagerSectorN1Controller extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {


            $sectorN1Manager = user::where('status', '1')
                ->where('manager_n1_id', '<>', 'bc0')
                ->where('manager_n2_id', '<>', 'bc0')
                ->where('manager_n3_id', '<>', 'bc0')
                ->where('manager_n4_id', '<>', 'bc0')
                ->where('manager_n5_id', '<>', 'bc0')
                ->where('manager_n6_id', '<>', 'bc0')
                ->groupBy(['sector_n1_id', 'manager_n1_id', 'manager_n2_id', 'manager_n3_id', 'manager_n4_id', 'manager_n5_id', 'manager_n6_id'])
                ->get(['sector_n1_id', 'manager_n1_id', 'manager_n2_id', 'manager_n3_id', 'manager_n4_id', 'manager_n5_id', 'manager_n6_id'])
                // ->take(20)
                ->toArray();

            GipManagerSectorN1::query()->truncate();

            GipManagerSectorN1::insert($sectorN1Manager);
        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao gravar', 422);
        }

        return  $this->success('Carga finalizada',);
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
     * @param  \App\Models\Sys\GipManagerSectorN1  $GipManagerSectorN1
     * @return \Illuminate\Http\Response
     */
    public function show(GipManagerSectorN1 $GipManagerSectorN1)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sys\GipManagerSectorN1  $GipManagerSectorN1
     * @return \Illuminate\Http\Response
     */
    public function edit(GipManagerSectorN1 $GipManagerSectorN1)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sys\GipManagerSectorN1  $GipManagerSectorN1
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GipManagerSectorN1 $GipManagerSectorN1)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sys\GipManagerSectorN1  $GipManagerSectorN1
     * @return \Illuminate\Http\Response
     */
    public function destroy(GipManagerSectorN1 $GipManagerSectorN1)
    {
        //
    }
}
