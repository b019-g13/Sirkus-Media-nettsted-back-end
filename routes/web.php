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


  use App\Page;
  

Route::get('/pages', function ()
 {
    
    $chil = Page::all()->first();
    
    dd($chil);
     
    return view('welcome');
   

});
