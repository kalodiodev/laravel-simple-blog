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

/*
 * Article Routes
 */
Route::get('/articles/create', 'ArticlesController@create')->name('article.create');
Route::post('/articles', 'ArticlesController@store')->name('article.store');
Route::get('/article/{slug}', 'ArticlesController@show')->name('article');
Route::delete('/article/{slug}', 'ArticlesController@destroy')->name('article.delete');
Route::get('/article/{slug}/edit', 'ArticlesController@edit')->name('article.edit');
Route::patch('/article/{slug}', 'ArticlesController@update')->name('article.update');

/*
 * Tag Routes
 */
Route::get('/tags', 'TagsController@index')->name('tag.index');
Route::post('/tags', 'TagsController@store')->name('tag.store');
Route::get('/tags/create', 'TagsController@create')->name('tag.create');
Route::get('/tags/{tag}/edit','TagsController@edit')->name('tag.edit');
Route::patch('tags/{tag}', 'TagsController@update')->name('tag.update');
Route::delete('tags/{tag}', 'TagsController@delete')->name('tag.delete');
Route::get('/tag/{tag}', 'TagsController@articles')->name('tag.articles');

/*
 * Archive Routes
 */
Route::get('/archives/{year?}/{month?}', 'ArchivesController@index')->name('archives');

/*
 * Comment Routes
 */
Route::post('/article/{slug}/comment', 'CommentsController@store')->name('comment.store');
Route::get('/comment/{comment}/edit', 'CommentsController@edit')->name('comment.edit');
Route::delete('/comment/{comment}', 'CommentsController@destroy')->name('comment.delete');
Route::patch('/comment/{comment}', 'CommentsController@update')->name('comment.update');

/*
 * Images
 */
Route::get('/images/avatar/{image}', 'ImagesController@avatar')->name('images.avatar');
Route::get('/images/article/{image}', 'ImagesController@article')->name('images.article');
Route::post('/images/article/', 'ImagesController@articleStore')->name('images.article.upload');

/*
 * Images Administration
 */
Route::get('/admin/images', 'AdminImagesController@index')->name('images.admin.index');

/*
 * User Images
 */
Route::get('/user/images', 'UserImagesController@index')->name('images.index');
Route::get('/user/images/{image}', 'UserImagesController@show')->name('images.show');
Route::delete('/user/images/{image}', 'UserImagesController@delete')->name('images.delete');

/*
 * Profiles
 */
Route::get('/profile/{user}', 'ProfilesController@show')->name('profile.show');
Route::get('/profile/{user}/edit', 'ProfilesController@edit')->name('profile.edit');
Route::patch('/profile/{user}', 'ProfilesController@update')->name('profile.update');

/*
 * Users
 */
Route::get('/users', 'UsersController@index')->name('users.index');
Route::post('/users', 'UsersController@store')->name('users.store');
Route::get('/users/create', 'UsersController@create')->name('users.create');
Route::get('/users/{user}', 'UsersController@show')->name('users.show');
Route::patch('/users/{user}', 'UsersController@update')->name('users.update');
Route::delete('/users/{user}', 'UsersController@destroy')->name('users.delete');
Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');

