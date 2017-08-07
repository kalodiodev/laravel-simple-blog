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

Route::get('/', 'HomeController@index');

Route::get('/articles/create', 'ArticlesController@create');
Route::post('/articles', 'ArticlesController@store');
Route::get('/article/{slug}', 'ArticlesController@show');
Route::get('/article/{slug}/edit', 'ArticlesController@edit');
Route::patch('/article/{slug}', 'ArticlesController@update');