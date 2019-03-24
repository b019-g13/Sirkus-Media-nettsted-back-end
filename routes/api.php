<?php

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

// Pages
Route::get('pages', 'PageController@api_index');
Route::get('pages/{page}', 'PageController@api_show');


// Links
Route::get('/links', 'LinkController@index');
Route::get('/links/{link}', 'LinkController@show');

// Menus
Route::get('/menus', 'MenuController@api_index');
Route::get('/menus/{menu}', 'MenuController@api_show');

// Menu_location
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


