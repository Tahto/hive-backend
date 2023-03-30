<?php

namespace App\Http\Controllers\Modules\Reports\Boletim;


use App\Models\Modules\Reports\Boletim\HourHour\BoletimDate;

use App\Traits\ApiResponser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Modules\Reports\Boletim\HourHour\BoletimFilter;

use Illuminate\Support\Facades\DB;

class HourHourFilterController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        $sectors_id = $request->sectors_id ? $request->sectors_id : ['_%'];

        $manager = (empty($request->manager) or $request->manager == 'null') ? '_%' : $request->manager;

        try {
            $managers = BoletimFilter::where(1, 1)
                ->select(
                    'user_id as id',
                    DB::raw("user_name || ' (' || user_id || ')' as title"),
                    'position_summary',
                    'hierarchical_level',
                )
                ->groupBy(
                    'user_id',
                    'user_name',
                    'position_summary',
                    'hierarchical_level',
                )
                ->where(function ($query) use ($sectors_id) {
                    foreach ($sectors_id as $key => $sector_id) {
                        $query->orWhere('sector_id', 'like', $sector_id);
                    };
                })
                // ->whereIn('sector_id', $sectors_id )
                ->where('user_id', 'like', $manager)
                ->orderBy('hierarchical_level', 'desc')
                ->orderBy('user_name', 'asc')
                ->get();

            $sectors = BoletimFilter::where(1, 1)
                ->select(
                    'sector_id as id',
                    DB::raw("lpad(sector_id, 5, '0')  || ' - '  || sector_name as title"),
                )
                ->groupBy(
                    'sector_id',
                    'sector_name',
                )
                ->where(function ($query) use ($sectors_id) {
                    foreach ($sectors_id as $key => $sector_id) {
                        $query->orWhere('sector_id', 'like', $sector_id);
                    };
                })
                ->where('user_id', 'like', $manager)
                ->orderBy('sector_name', 'asc')
                ->get();
        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao gerar lista', 422);
        }




        return $this->success(['managers' =>  $managers, 'sectors' => $sectors], 'Lista gerada com sucesso');
    }
}
