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
Route::get('pages/{page_slug}', 'PageController@api_show');

// Menus
Route::get('/menus', 'MenuController@api_index');
Route::get('/menus/{menu}', 'MenuController@api_show');

// Settings
Route::get('/site_settings', 'SiteSettingController@api_index');
Route::get('/site_settings/{site_setting}', 'SiteSettingController@api_show');
