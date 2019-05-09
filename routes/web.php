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

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes(['verify' => true]);

Route::get('home', 'HomeController@index')->name('home');

Route::get('konto', 'UserController@show')->name('user.show');
Route::post('konto', 'UserController@update')->name('user.update');

Route::get('media-picker', 'MediaPickerController@show')->name('media-picker.show');
Route::post('media-picker', 'MediaPickerController@store')->name('media-picker.store');

Route::resources([
    'pages' => 'PageController',
    'components' => 'ComponentController',
    'links' => 'LinkController',
    'fields' => 'FieldController',
    'menus' => 'MenuController',
    'menu_locations' => 'MenuLocationController',
]);
