<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();

Route::group(['middleware' => 'auth'], function()
{
    Route::get('/', 'PostsController@index')->name('home');
    Route::resource('posts', 'PostsController', ['only' => ['create', 'store', 'show']]);
    Route::resource('comments', 'CommentsController', ['only' => ['store', 'destroy']]);
});
