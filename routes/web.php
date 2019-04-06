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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
/* Country Add Controller Link*/
Route::resource('country','CountryController');

Route::resource('category','CategoryController');

Route::resource('products','ProductController');

Route::resource('product_unit','ProductUnitController');
Route::resource('product_category','ProductCategoryController');

Route::resource('state','StateController');
Route::resource('zone','ZoneController');
Route::resource('district','DistrictController');
Route::resource('route','RouteController');

Route::resource('store','StoreAttenceController');


Route::get('store_attence','ReportController@satt');



Route::get('stateallocate/{id1}/{id2}','StateController@allocate');
Route::get('zoneallocate/{id1}/{id2}','ZoneController@allocate');
Route::get('districtallocate/{id1}/{id2}','DistrictController@allocate');
Route::get('routeallocate/{id1}/{id2}','RouteController@allocate');


Route::get('state_allocate','StateController@allocate_index');
Route::get('zone_allocate','ZoneController@allocate_index');
Route::get('district_allocate','DistrictController@allocate_index');
Route::get('route_allocate','RouteController@allocate_index');





Route::resource('admin','AdminController');

Route::get('get-list/{id}','AdminController@getList');



Route::get('get-us-list','AdminController@get-us-list');

Route::get('get-zone-user-list','AdminController@getuserzone');
Route::get('get-zone-list','AdminController@getzone');
Route::get('get-district-list','AdminController@getdistrict');



Route::get('get-admin-zone-list','AdminController@getadminzone');
Route::get('get-admin-district-list','AdminController@getadmindistrict');