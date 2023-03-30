<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Middleware\LogAccessMiddleware;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('auth', 'App\Http\Controllers\Sys\AuthController');

Route::group(['middleware' => ['auth:sanctum','log']], function () { 
    // Core
    Route::apiResource('user', 'App\Http\Controllers\Sys\UserController');
    Route::apiResource('userManager', 'App\Http\Controllers\Sys\UserManagerController')->withoutMiddleware(['log']);
    Route::apiResource('userManagerN1', 'App\Http\Controllers\Sys\UserManagerN1Controller')->withoutMiddleware(['log']);
    Route::apiResource('userManagerN2', 'App\Http\Controllers\Sys\UserManagerN2Controller')->withoutMiddleware(['log']);
    Route::apiResource('userManagerN3', 'App\Http\Controllers\Sys\UserManagerN3Controller')->withoutMiddleware(['log']);
    Route::apiResource('userManagerN4', 'App\Http\Controllers\Sys\UserManagerN4Controller')->withoutMiddleware(['log']);
    Route::apiResource('userManagerN5', 'App\Http\Controllers\Sys\UserManagerN5Controller')->withoutMiddleware(['log']);
    Route::apiResource('userManagerN6', 'App\Http\Controllers\Sys\UserManagerN6Controller')->withoutMiddleware(['log']);
    Route::apiResource('statusDefault', 'App\Http\Controllers\Sys\StatusDefaultController')->withoutMiddleware(['log']);
    Route::apiResource('myTeam', 'App\Http\Controllers\Modules\MyTeamController');
    Route::apiResource('sectorN1', 'App\Http\Controllers\Sys\GipSectorN1Controller');
    Route::apiResource('sectorN2', 'App\Http\Controllers\Sys\GipSectorN2Controller');
    Route::apiResource('managerSectorN1', 'App\Http\Controllers\Sys\GipManagerSectorN1Controller');
    // Módulo Wit
    Route::apiResource('app', 'App\Http\Controllers\Sys\AppController');
    Route::apiResource('module', 'App\Http\Controllers\Sys\ModuleController');
    Route::apiResource('menuN1', 'App\Http\Controllers\Sys\MenuN1Controller');
    Route::apiResource('menuN2', 'App\Http\Controllers\Sys\MenuN2Controller');
    Route::apiResource('routePermission', 'App\Http\Controllers\Sys\RoutePermissionController');
    Route::apiResource('routePermissionTest', 'App\Http\Controllers\Sys\RoutePermissionTestController');
    Route::apiResource('routeAllowed', 'App\Http\Controllers\Sys\RouteAllowedController')->withoutMiddleware(['log']);
    Route::apiResource('userAvatar', 'App\Http\Controllers\Sys\UserAvatarController');    

    Route::apiResource('capacityCharges', 'App\Http\Controllers\Modules\Wit\Planning\CapacityChargeController');
    
    // Módulo Reports
    Route::apiResource('powerBi', 'App\Http\Controllers\Modules\Reports\PowerBi\PowerBiController');
    Route::apiResource('boletimHHfilters', 'App\Http\Controllers\Modules\Reports\Boletim\HourHourFilterController');
    Route::apiResource('boletimHHDay', 'App\Http\Controllers\Modules\Reports\Boletim\HourHourDayController');
    Route::apiResource('boletimHHIntraDay', 'App\Http\Controllers\Modules\Reports\Boletim\HourHourIntraDayController');

});

Route::apiResource('gip', 'App\Http\Controllers\gip');

Route::get('email', function () {
    $user = new stdClass();
    $user->name = 'Fernando';
    $user->email = 'hodnan@gmail.com';    
    Mail::queue(new \App\Mail\TestMail($user));
  });


