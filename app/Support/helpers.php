<?php
use Illuminate\Support\Facades\Log;
use App\Models\Sys\JobHistory;

if(! function_exists('job_control') ){

    function job_control($job, $id = null){
        
        // Se o id do JobHistory for passado ele finaliza o running 
        if($id){
            $job = JobHistory::find($id);
            $job['running']  = '0';
            return  $job->save();
        } else {

            return   JobHistory::create($job);
        }
    }

}