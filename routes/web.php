<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Mail\TesteMail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/email', function () {
    // return new TesteMail();
    // mail("fernando.duarte@tahto.com.br","My subject",'$msg');
    // return view('mail.capacity');
    return Mail::raw('Hello World!', function($msg) {$msg->to('fernando.duarte@tahto.com.br','Fernando')->subject('Test Email'); });
    // $x = new TesteMail();
    // return Mail::send( $x);
});