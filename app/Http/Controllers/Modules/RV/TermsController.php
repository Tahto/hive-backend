<?php

namespace App\Http\Controllers\Modules\RV;

use App\Models\Modules\Rv\Terms;
use App\Models\Modules\Rv\TermsCharge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Modules\RV\TermsRequest;
use App\Jobs\Modules\RV\TermChargeJob;
use Illuminate\Support\Facades\Bus;

class TermsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(TermsRequest $request)
    {
        $termsCharge['ref'] =  $request->ref . '-01';
        $termsCharge['files'] = count($request->file('file'));
        $termsCharge['filesfails'] = 0;
        $termsCharge['status'] = 0;

        $termsCharge = TermsCharge::create($termsCharge);

        // Local que o arquivo será armazenado 
        $path = 'Modules/RV/Terms/Temp/' . $termsCharge->id;

        $info = [];
        foreach ($request->file('file') as $file) {

            $filename =  $file->getClientOriginalName();
            $file->storeAs($path, $filename);
            $info[] = ['arquivo' => $filename, 'status' => 'Recebido'];

            
            $termChargeJob['ref'] =  $termsCharge->ref;
            $termChargeJob['sector_n1_id'] = '0';
            $termChargeJob['sector_n2_id'] = '0';
            $termChargeJob['version'] = '0';
            $termChargeJob['hierarchical_level'] = '0';
            $termChargeJob['maturity'] = '0';
            $termChargeJob['status'] = '0';
            $termChargeJob['campaign'] =  $filename;
            $termChargeJob['charge_id'] = $termsCharge->id;

            // new TermChargeJob(new Terms($termChargeJob));
            Bus::chain([
                new TermChargeJob(new Terms($termChargeJob))
            ])->dispatch();
    
        }

        $termsCharge->info = json_encode($info);
        $termsCharge->save();
        // $create = CapacityCharge::create($payload);
        return  $termsCharge;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Modules\Rv\Terms  $terms
     * @return \Illuminate\Http\Response
     */
    public function show(Terms $terms)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Modules\Rv\Terms  $terms
     * @return \Illuminate\Http\Response
     */
    public function edit(Terms $terms)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Modules\Rv\Terms  $terms
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Terms $terms)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Modules\Rv\Terms  $terms
     * @return \Illuminate\Http\Response
     */
    public function destroy(Terms $terms)
    {
        //
    }
}
