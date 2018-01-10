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

Auth::routes();

Route::get('/', 'HomeController@splash')->name('splash');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/convert', 'HomeController@convertNumeral')->name('convertNumeral');
Route::post('/fetch', 'HomeController@getStats')->name('getStats');
Route::post('/gettable', 'HomeController@getTable')->name('getTable');
Route::post('/changetheme', 'HomeController@changeTheme')->name('changeTheme');
