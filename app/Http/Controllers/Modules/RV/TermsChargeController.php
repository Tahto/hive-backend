<?php

namespace App\Http\Controllers\Modules\RV;

use App\Models\Modules\Rv\TermsCharge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Modules\RV\TermsChargeRequest;

class TermsChargeController extends Controller
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
    public function store(TermsChargeRequest $request)
    {
        return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Modules\Rv\TermsCharge  $termsCharge
     * @return \Illuminate\Http\Response
     */
    public function show(TermsCharge $termsCharge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Modules\Rv\TermsCharge  $termsCharge
     * @return \Illuminate\Http\Response
     */
    public function edit(TermsCharge $termsCharge)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Modules\Rv\TermsCharge  $termsCharge
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TermsCharge $termsCharge)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Modules\Rv\TermsCharge  $termsCharge
     * @return \Illuminate\Http\Response
     */
    public function destroy(TermsCharge $termsCharge)
    {
        //
    }
}
