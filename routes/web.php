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
    Route::resource('users', 'UsersController', ['only' => ['edit', 'update']]);
    Route::get('/users/{user}/password', 'UserPasswordsController@edit')->name('users.password');
    Route::patch('/users/{user}/password', 'UserPasswordsController@update')->name('users.password.update');
    Route::post('/tokens/{user}', 'TokensController@store')->name('tokens.store');
    Route::resource('newsletter-subscriptions', 'NewsletterSubscriptionsController', ['only' => 'store']);
});

Route::get('/', 'PostsController@index')->name('home');
Route::resource('media', 'MediaController', ['only' => 'show']);
Route::get('/posts/feed', 'PostsFeedController@index')->name('posts.feed');
Route::resource('posts', 'PostsController', ['only' => 'show']);
Route::resource('users', 'UsersController', ['only' => 'show']);

Route::get('newsletter-subscriptions/unsubscribe', 'NewsletterSubscriptionsController@unsubscribe')->name('newsletter-subscriptions.unsubscribe');
