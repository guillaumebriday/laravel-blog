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

Route::group(['prefix' => 'auth'], function () {
    Route::get('{provider}', 'Auth\AuthController@redirectToProvider')->name('auth.provider');
    Route::get('{provider}/callback', 'Auth\AuthController@handleProviderCallback');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'PostsController@index')->name('home');
    Route::resource('posts', 'PostsController', ['only' => ['create', 'store', 'show']]);
    Route::resource('comments', 'CommentsController', ['only' => ['store', 'destroy']]);
    Route::resource('users', 'UsersController', ['only' => ['show', 'edit', 'update']]);
    Route::resource('newsletter-subscriptions', 'NewsletterSubscriptionsController', ['only' => ['store']]);
});

Route::get('newsletter-subscriptions/unsubscribe', 'NewsletterSubscriptionsController@unsubscribe')->name('newsletter-subscriptions.unsubscribe');
