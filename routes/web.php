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
Route::get('/dashboard', 'HomeController@index');

//需求路由
Route::get('/requirement/create', 'RequirementController@create');
Route::post('/requirement/implode', 'RequirementController@implode');
Route::post('/requirement/storeSql', 'RequirementController@storeSql');
Route::get('/requirement/edit/{id}', 'RequirementController@edit');
Route::get('/requirement/show/{id}', 'RequirementController@show');
Route::post('/requirement/uploadfile', 'RequirementFileController@upload');
Route::get('/requirement/lists', 'RequirementController@lists');

//用户路由
Route::get('/user/center', 'UserController@baseInfo');
Route::get('/user/zendao', 'UserController@zenDao');
Route::get('/user/secure', 'UserController@secure');
Route::post('/user/update', 'UserController@update');
Route::post('/user/passwordreset', 'UserController@passwordReset');