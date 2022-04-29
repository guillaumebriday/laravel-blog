<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsletterSubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPasswordController;
use App\Http\Controllers\UserTokenController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/.well-known/change-password', '/settings/password');

Auth::routes(['verify' => true]);

Route::prefix('auth')->group(function () {
    Route::get('{provider}', [AuthController::class, 'redirectToProvider'])->name('auth.provider');
    Route::get('{provider}/callback', [AuthController::class, 'handleProviderCallback']);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('settings')->group(function () {
        Route::get('account', [UserController::class, 'edit'])->name('users.edit');
        Route::match(['put', 'patch'], 'account', [UserController::class, 'update'])->name('users.update');

        Route::get('password', [UserPasswordController::class, 'edit'])->name('users.password');
        Route::match(['put', 'patch'], 'password', [UserPasswordController::class, 'update'])->name('users.password.update');

        Route::get('token', [UserTokenController::class, 'edit'])->name('users.token');
        Route::match(['put', 'patch'], 'token', [UserTokenController::class, 'update'])->name('users.token.update');
    });

    Route::resource('newsletter-subscriptions', NewsletterSubscriptionController::class)->only('store');
});
