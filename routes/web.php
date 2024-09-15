<?php

use App\Mail\AccountActivate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\device_controller;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::get('/email' , function (){

    $mail = new AccountActivate("Peter Nagy") ;
    $mail->subject("This a Mail Test") ;
    Mail::to("peter.nagy152@gmail.com")->send($mail);


});
