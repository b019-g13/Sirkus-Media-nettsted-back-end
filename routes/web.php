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

 use App\MenuLocation;


Route::get('/', function () {
    $mloc = new MenuLocation; 
    $mloc->name ="Helloworld";
    $mloc->slug = "gfhd";
    $mloc->save();
    dd($mloc);
     return view('welcome');
   

});
