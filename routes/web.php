<?php

use Illuminate\Support\Facades\Route;

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

Route::get('verified', function (){
   return "email verified";
})->name('verify');

Route::get('averified', function (){
    return "email already verified";
})->name('already');

Route::get('/password/reset', function (){
   return "password reset form";
})->name('password.reset');
