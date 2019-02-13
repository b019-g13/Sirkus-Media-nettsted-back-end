<?php

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


  use App\Link;
  

Route::get('/', function () {
    
    $fcom = Link::all()->first();
    
    dd($fcom->menu_link);
     
    return view('welcome');
   

});
