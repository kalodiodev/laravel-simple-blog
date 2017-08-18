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

Route::get('/', 'HomeController@index')->name('home');

Route::get('/articles/create', 'ArticlesController@create')->name('article.create');
Route::post('/articles', 'ArticlesController@store')->name('article.store');
Route::get('/article/{slug}', 'ArticlesController@show')->name('article');
Route::delete('/article/{slug}', 'ArticlesController@destroy')->name('article.delete');
Route::get('/article/{slug}/edit', 'ArticlesController@edit')->name('article.edit');
Route::patch('/article/{slug}', 'ArticlesController@update')->name('article.update');

Route::get('/tags/create', 'TagsController@create')->name('tag.create');
Route::get('/tags', 'TagsController@index')->name('tag.index');
Route::post('/tags', 'TagsController@store')->name('tag.store');
Route::get('/tag/{tag}', 'TagsController@articles')->name('tag.articles');

Route::get('/archives/{year?}/{month?}', 'ArchivesController@index')->name('archives');

Route::post('/article/{slug}/comment', 'CommentsController@store')->name('comment.store');
Route::get('/comment/{comment}/edit', 'CommentsController@edit')->name('comment.edit');
Route::delete('/comment/{comment}', 'CommentsController@destroy')->name('comment.delete');
Route::patch('/comment/{comment}', 'CommentsController@update')->name('comment.update');
