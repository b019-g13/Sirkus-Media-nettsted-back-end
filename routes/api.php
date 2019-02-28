<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Pages
Route::get('/pages', 'PageController@index');
Route::get('pages/{page}', 'PageController@show');

// Links
Route::get('/links', 'LinkController@index');
Route::get('/links/{link}', 'LinkController@show');

// Menus
Route::get('/menus', 'MenuController@index');
Route::get('/menus/{menu}', 'MenuController@show');

// Menu_locations
Route::get('/menu_locations', 'MenuLocationController@index');
Route::get('/menu_locations/{menu_location}', 'MenuLocationController@show');

// Components
Route::get('/components', 'ComponentController@index');
Route::get('/components/{component}',  'ComponentController@show');

// Fields
Route::get('/fields', 'FieldController@index');
Route::get('/fields/{field}', 'FieldController@show');

// Images og Image_size
Route::get('/images', 'ImageController@index');
Route::get('/images/{image}', 'FieldController@show');

Route::get('/image_sizes', 'ImageController@index');
Route::get('/images_sizes/{image_size}', 'ImageController@show');

// Users
Route::get('/users', 'UserController@index');
Route::get('/users/{user}', 'UserController@show');