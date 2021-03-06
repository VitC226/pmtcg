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
Route::get('/download', 'HomeController@download');
Route::get('sitemap', 'HomeController@siteMap');
Route::get('sitemap.xml', 'HomeController@siteMap');
Route::get('/lang','HomeController@lang');

//Route::get('/database', 'CardController@list');
Route::get('/search', 'CardController@search');
Route::get('/tableOrList','CardController@tableOrList');
Route::get('/database/{cate?}', 'CardController@list');
//Route::get('/result', 'CardController@result');
Route::get('/result', 'CardController@result');
Route::get('/card/{card}', 'CardController@card');
Route::get('/card/{card}', 'CardController@card');

/* Admin */
Route::get('mm/index', 'AdminController@index');
Route::get('mm/card', 'AdminController@card');
Route::get('mm/card/{cate?}', 'AdminController@card');
Route::get('mm/cardEdit/{card}', 'AdminController@cardEdit');
Route::post('mm/cardEdit/translate', 'AdminController@translate');
Route::post('mm/cardEdit/addAbility', 'AdminController@addAbility');
Route::post('mm/cardEdit/addPower', 'AdminController@addPower');
Route::post('mm/cardEdit/translateSave', 'AdminController@translateSave');
Route::post('mm/cardEdit/loadImg', 'AdminController@loadImg');
Route::get('mm/collect', 'AdminController@collect');
Route::post('mm/collectIndex', 'AdminController@collectIndex');
Route::post('mm/collectCard', 'AdminController@collectCard');

Route::get('auth/weibo', 'Auth\LoginController@weibo');
Route::get('auth/weibo/callback', 'Auth\LoginController@weibo_callback');
Route::get('auth/qq', 'Auth\LoginController@qq');
Route::get('auth/qq/callback', 'Auth\LoginController@qq_callback');

/* Shop */
Route::get('shop', 'ShopController@index');
Route::get('shop/{item}', 'ShopController@item');