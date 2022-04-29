<?php

use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\MediaLibraryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\PostThumbnailController;
use App\Http\Controllers\Admin\ShowDashboard;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', ShowDashboard::class)->name('dashboard');
Route::resource('posts', PostController::class);
Route::delete('/posts/{post}/thumbnail', [PostThumbnailController::class, 'destroy'])->name('posts_thumbnail.destroy');
Route::resource('users', UserController::class)->only(['index', 'edit', 'update']);
Route::resource('comments', CommentController::class)->only(['index', 'edit', 'update', 'destroy']);
Route::resource('media', MediaLibraryController::class)->only(['index', 'show', 'create', 'store', 'destroy']);
