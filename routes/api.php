<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->namespace('Api\V1')->group(function () {
    Route::middleware('auth:api')->group(function () {
        // Comments
        Route::resource('comments', 'CommentController', ['only' => 'destroy']);
        Route::resource('posts.comments', 'PostCommentController', ['only' => 'store']);

        // Posts
        Route::resource('posts', 'PostController', ['only' => ['update', 'store', 'destroy']]);
        Route::delete('/posts/{post}/thumbnail', 'PostThumbnailController@destroy')->name('posts.thumbnail.destroy');
        Route::post('/posts/{post}/likes', 'PostLikeController@store')->name('posts.likes.store');
        Route::delete('/posts/{post}/likes', 'PostLikeController@destroy')->name('posts.likes.destroy');

        // Users
        Route::resource('users', 'UserController', ['only' => 'update']);
    });

    Route::post('/authenticate', 'Auth\AuthenticateController@authenticate')->name('authenticate');

    // Comments
    Route::resource('posts.comments', 'PostCommentController', ['only' => 'index']);
    Route::resource('users.comments', 'UserCommentController', ['only' => 'index']);
    Route::resource('comments', 'CommentController', ['only' => ['index', 'show']]);

    // Posts
    Route::resource('posts', 'PostController', ['only' => ['index', 'show']]);
    Route::resource('users.posts', 'UserPostController', ['only' => 'index']);

    // Users
    Route::resource('users', 'UserController', ['only' => ['index', 'show']]);
});
