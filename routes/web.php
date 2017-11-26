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
    Route::resource('posts', 'PostsController');
    Route::delete('/posts/{post}/thumbnail', 'PostsThumbnailController@destroy')->name('posts_thumbnail.destroy');
    Route::resource('users', 'UsersController', ['only' => ['index', 'edit', 'update']]);
    Route::resource('comments', 'CommentsController', ['only' => ['index', 'edit', 'update', 'destroy']]);
});

Route::middleware('auth')->group(function () {
    Route::prefix('settings')->group(function () {
        Route::get('account', 'UsersController@edit')->name('users.edit');
        Route::match(['put', 'patch'], 'account', 'UsersController@update')->name('users.update');

        Route::get('password', 'UserPasswordsController@edit')->name('users.password');
        Route::match(['put', 'patch'], 'password', 'UserPasswordsController@update')->name('users.password.update');

        Route::get('token', 'UserTokensController@edit')->name('users.token');
        Route::match(['put', 'patch'], 'token', 'UserTokensController@update')->name('users.token.update');
    });

    Route::resource('newsletter-subscriptions', 'NewsletterSubscriptionsController', ['only' => 'store']);
});

Route::get('/', 'PostsController@index')->name('home');
Route::resource('media', 'MediaController', ['only' => 'show']);
Route::get('/posts/feed', 'PostsFeedController@index')->name('posts.feed');
Route::resource('posts', 'PostsController', ['only' => 'show']);
Route::resource('users', 'UsersController', ['only' => 'show']);

Route::get('newsletter-subscriptions/unsubscribe', 'NewsletterSubscriptionsController@unsubscribe')->name('newsletter-subscriptions.unsubscribe');
