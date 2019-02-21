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

use Illuminate\Http\Request;
use App\Component;
use App\ComponentField;
use App\Field;
use App\Image;
use App\ImgageSize;
Use App\Link;
use App\Menu;
use App\MenuLink;
use App\menuLocation;
use App\Page;
use App\PageComponent;
use App\User;

Route::get('/', function ()
 { $page = Page::all()->first(); 
  dd($page);
     return view('welcome');
});

// Pages
Route::get('/pages', 'PagesController@index');
Route::get('pages/{page}', 'PagesController@show');

// Links
Route::get('/links', 'LinkController@index');
Route::get('/links/{id}', 'LinkController@show');

// Menus
Route::get('/menus', 'MenuController@index');
Route::get('/menus/{menu}', 'MenuController@show');

// Components
Route::get('/components', 'ComponentController@index');
Route::get('/components/{component}',  'ComponentController@show');

// Fields
Route::get('/fields', 'FieldController@index');
Route::get('/fields/{id}', 'FieldController@index');

// Images og Image_size
Route::get('/images', 'ImageController@index');
Route::get('/images/{id}', 'FieldController@show');

Route::get('/image_sizes', 'ImageController@index');
Route::get('/images-sizes/{id}', 'ImageController@show');

// Users
Route::get('/users', 'UserController@index');
Route::get('/users/{id}', 'UserController@show');


