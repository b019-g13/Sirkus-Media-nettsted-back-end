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
Route::get('epost-bekreftet', 'Auth\VerificationController@complete');

Route::get('home', 'HomeController@index')->name('home');

Route::get('brukere', 'UserController@index')->name('user.index');
Route::delete('bruker/{user}', 'UserController@destroy')->name('user.destroy');
Route::get('konto', 'UserController@show')->name('user.show');
Route::post('konto', 'UserController@update')->name('user.update');

Route::get('media-picker', 'MediaPickerController@show')->name('media-picker.show');
Route::get('media-picker/refresh', 'MediaPickerController@show_refresh')->name('media-picker.show_refresh');
Route::post('media-picker', 'MediaPickerController@store')->name('media-picker.store');

Route::resource('pages', 'PageController')->except(['show']);
Route::resource('menus', 'MenuController')->except(['show']);
Route::resource('components', 'ComponentController');
Route::resource('links', 'LinkController')->except(['index', 'edit']);
Route::resource('fields', 'FieldController')->except(['show']);
Route::resource('menu_locations', 'MenuLocationController')->except(['show']);
Route::resource('site_settings', 'SiteSettingController')->except(['show']);
