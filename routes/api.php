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




Route::post('/login', [ 'uses' => "ApiRegisterController@login"]);
Route::post('logout','ApiRegisterController@logout');

Route::post('/logout', [ 'uses' => 'ApiRegisterController@logout',   'as' => 'logout.api']);


Route::get('details/{id}','ApiController@index');
Route::get('route_details/{id}','ApiController@show');
Route::get('stores_details/{id}','ApiController@stores');

Route::get('product_categody','ApiController@pcat');
Route::get('products_list/{id}','ApiController@product');

Route::get('zone_list','ApiController@zone');
Route::get('zone_details/{id}/{id1}','ApiController@zone_details');
Route::get('sr_details/{id}','ApiController@sr_details');
Route::post('sr_store','ApiController@sr_store');




Route::get('store_create','API\StoreController@create');

Route::post('store_store','API\StoreController@store');
Route::post('store_edit/{id}','API\StoreController@update');
Route::post('store_image/{id}','API\StoreController@image_delete');
Route::get('store_list','API\StoreController@index');
Route::post('store_error','API\StoreController@error');

Route::post('day_attence','API\AttenceController@store');
Route::get('day_attence_list/{id}','API\AttenceController@day_att');

Route::post('store_attence','API\AttenceController@create');
Route::get('store_attence_list/{id}','API\AttenceController@sto_att');


Route::get('sm_sr_list','ApiController@sm_to_sr');
Route::post('sr_attence','ApiController@sr_attence');

Route::post('password_change','ApiController@pwdchge');



