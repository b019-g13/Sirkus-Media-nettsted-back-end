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

Auth::routes();

// Pages
Route::get('/pages', 'PageController@index');
Route::get('pages/{page}', 'PageController@show');
Route::get('/pages/create', 'PageController@create')->name('page.create');
Route::post('/pages/create', 'PageController@store')->name('page.store');
Route::get('/pages/edit', 'PageController@edit')->name('page.edit');
Route::put('/pages/update', 'PageController@update')->name('page.update');
Route::delete('/pages/destroy', 'PageController@destroy')->name('page.destroy');

// Links
Route::get('/links', 'LinkController@index');
Route::get('/links/{link}', 'LinkController@show');
Route::get('/links/create', 'LinkController@create')->name('link.create');
Route::post('/links/create', 'LinkController@store')->name('link.store');
Route::get('/links/edit', 'LinkController@edit')->name('link.edit');
Route::put('/links/update', 'LinkController@update')->name('link.update');
Route::delete('/links/destroy', 'LinkController@destroy')->name('link.destroy');

// Menus
Route::get('/menus', 'MenuController@index');
Route::get('/menus/{menu}', 'MenuController@show');
Route::get('/menus/create', 'MenuController@create')->name('menu.create');
Route::post('/menus/create', 'MenuController@store')->name('menu.store');
Route::get('/menus/edit', 'MenuController@edit')->name('menu.edit');
Route::put('/menus/update', 'MenuController@update')->name('menu.update');
Route::delete('/menus/destroy', 'MenuController@destroy')->name('menu.destroy');

// Menu_locations
Route::get('/menu_locations', 'MenuLocationController@index');
Route::get('/menu_locations/{menu_location}', 'MenuLocationController@show');

// Components
Route::get('/components', 'ComponentController@index');
Route::get('/components/{component}',  'ComponentController@show');
Route::get('/components/create', 'ComponentController@create')->name('component.create');
Route::post('/components/store', 'ComponentController@store')->name('component.store');
Route::get('/components/edit', 'ComponentController@edit')->name('component.edit');
Route::put('/components/update', 'ComponentController@update')->name('component.update');
Route::delete('/components/destroy', 'ComponentController@destroy')->name('component.destroy');

// Fields
Route::get('/fields', 'FieldController@index');
Route::get('/fields/{field}', 'FieldController@show');
Route::get('/fields/create', 'FieldController@create')->name('field.create');
Route::post('/fields/create', 'FieldController@store')->name('field.store');
Route::get('/fields/edit', 'FieldController@edit')->name('field.edit');
Route::put('/fields/update', 'FieldController@update')->name('field.update');
Route::delete('/fields/destroy', 'FieldController@destroy')->name('field.destroy');

// Images og Image_size
Route::get('/images', 'ImageController@index');
Route::get('/images/{image}', 'FieldController@show');

Route::get('/image_sizes', 'ImageController@index');
Route::get('/images_sizes/{image_size}', 'ImageController@show');

// Users
Route::get('/users', 'UserController@index');
Route::get('/users/{user}', 'UserController@show');


Route::get('/register', 'RegisterController@create');
Route::post('register', 'RegisterController@store');
 
Route::get('/login', 'LoginController@create');
Route::post('/login', 'LoginController@store');
Route::get('/logout', 'LoginController@destroy');