<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Intro\IntroController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('intro', [IntroController::class, 'index'])
        ->name('intro');
});
