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

Route::prefix('auth')->group(function () {
    Route::get('{provider}', 'Auth\AuthController@redirectToProvider')->name('auth.provider');
    Route::get('{provider}/callback', 'Auth\AuthController@handleProviderCallback');
});

Route::prefix('admin')->middleware(['auth', 'role:admin'])->namespace('Admin')->as('admin.')->group(function () {
    Route::get('dashboard', 'ShowDashboard')->name('dashboard');
    Route::resource('posts', 'PostsController', ['only' => ['index', 'edit', 'update', 'destroy']]);
    Route::resource('users', 'UsersController', ['only' => ['index', 'edit', 'update']]);
    Route::resource('comments', 'CommentsController', ['only' => ['index', 'edit', 'update', 'destroy']]);
});

Route::middleware('auth')->group(function () {
    Route::get('/', 'PostsController@index')->name('home');
    Route::get('/files/{filename}', 'MediaController@getFile')->name('files');
    Route::get('/posts/feed', 'PostsController@feed')->name('posts.feed');
    Route::resource('posts', 'PostsController', ['only' => ['create', 'store', 'show', 'edit', 'update']]);
    Route::delete('/posts/{post}/thumbnail', 'PostsController@destroy_thumbnail')->name('posts.destroy_thumbnail');
    Route::resource('comments', 'CommentsController', ['only' => ['store', 'destroy']]);
    Route::resource('users', 'UsersController', ['only' => ['show', 'edit', 'update']]);
    Route::post('/users/{user}/api_token', 'UsersController@api_token')->name('users.api_token');
    Route::delete('/users/{user}/destroy_api_token', 'UsersController@destroy_api_token')->name('users.destroy_api_token');
    Route::resource('newsletter-subscriptions', 'NewsletterSubscriptionsController', ['only' => ['store']]);
});

Route::get('newsletter-subscriptions/unsubscribe', 'NewsletterSubscriptionsController@unsubscribe')->name('newsletter-subscriptions.unsubscribe');
