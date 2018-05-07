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

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Route::get('/database', 'CardController@list');
Route::get('/database/{cate?}', 'CardController@list');
Route::get('/card/{card}', 'CardController@card');

/* Admin */
Route::get('admin/index', 'AdminController@index');
Route::get('admin/card', 'AdminController@card');
Route::get('admin/cardEdit/{card}', 'AdminController@cardEdit');
Route::post('admin/cardEdit/translate', 'AdminController@translate');
Route::post('admin/cardEdit/translateSave', 'AdminController@translateSave');
Route::post('admin/cardEdit/loadImg', 'AdminController@loadImg');
Route::get('admin/collect', 'AdminController@collect');
Route::post('admin/collectIndex', 'AdminController@collectIndex');
Route::post('admin/collectCard', 'AdminController@collectCard');