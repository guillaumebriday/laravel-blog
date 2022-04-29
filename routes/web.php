<?php

use App\Http\Controllers\NewsletterSubscriptionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostFeedController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/posts/feed', [PostFeedController::class, 'index'])->name('posts.feed');
Route::resource('posts', PostController::class)->only('show');
Route::resource('users', UserController::class)->only('show');

Route::get('newsletter-subscriptions/unsubscribe', [NewsletterSubscriptionController::class, 'unsubscribe'])->name('newsletter-subscriptions.unsubscribe');
