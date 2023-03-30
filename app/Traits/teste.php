<?php

namespace App\Traits;
use Illuminate\Support\Facades\Log;
/*
|--------------------------------------------------------------------------
| Api Responser Trait
|--------------------------------------------------------------------------
|
| This trait will be used for any response we sent to clients.
|
*/

trait teste
{
    public function handle()
    {
        Log::info('hhhhhh');
        // // updating created_by and updated_by when model is created
        // static::handle(function ($model) {
            
        // });

       
    }

}