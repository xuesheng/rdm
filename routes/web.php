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

Route::get('/requirements/create', 'RequirementsController@create');

Route::post('/requirements/implode', 'RequirementsController@implode');
Route::post('/requirements/storeSql', 'RequirementsController@storeSql');

Route::get('/requirements/edit/{id}', 'RequirementsController@edit');
Route::get('/requirements/show/{id}', 'RequirementsController@show');
Route::post('/requirements/uploadfile', 'RequirementsFilesController@upload');
Route::get('/requirements/lists', 'RequirementsController@lists');