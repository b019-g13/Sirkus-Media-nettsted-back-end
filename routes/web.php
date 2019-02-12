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

 use App\MenuLink;


Route::get('/', function () {
    $menulink = new MenuLink;
    $menulink->link_id= null;
    $menulink->menu_id=null;
    $menulink->save();
    dd($menulink);
     
    return view('welcome');
   

});
