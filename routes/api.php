<?php

use App\Http\Controllers\Api\V1\Auth\AuthenticateController;
use App\Http\Controllers\Api\V1\CommentController;
use App\Http\Controllers\Api\V1\MediaController;
use App\Http\Controllers\Api\V1\PostCommentController;
use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V1\PostLikeController;
use App\Http\Controllers\Api\V1\UserCommentController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\UserPostController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->group(function () {
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        // Comments
        Route::apiResource('comments', CommentController::class)->only('destroy');
        Route::apiResource('posts.comments', PostCommentController::class)->only('store');

        // Posts
        Route::apiResource('posts', PostController::class)->only(['update', 'store', 'destroy']);
        Route::post('/posts/{post}/likes', [PostLikeController::class, 'store'])->name('posts.likes.store');
        Route::delete('/posts/{post}/likes', [PostLikeController::class, 'destroy'])->name('posts.likes.destroy');

        // Users
        Route::apiResource('users', UserController::class)->only('update');

        // Media
        Route::apiResource('media', MediaController::class)->only(['store', 'destroy']);
    });

    Route::post('/authenticate', [AuthenticateController::class, 'authenticate'])->name('authenticate');

    // Comments
    Route::apiResource('posts.comments', PostCommentController::class)->only('index');
    Route::apiResource('users.comments', UserCommentController::class)->only('index');
    Route::apiResource('comments', CommentController::class)->only(['index', 'show']);

    // Posts
    Route::apiResource('posts', PostController::class)->only(['index', 'show']);
    Route::apiResource('users.posts', UserPostController::class)->only('index');

    // Users
    Route::apiResource('users', UserController::class)->only(['index', 'show']);

    // Media
    Route::apiResource('media', MediaController::class)->only('index');
});
