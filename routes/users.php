<?php

use App\Http\Controllers\Users\UsersController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('users', [UsersController::class, 'index'])->name('users.index');
    Route::get('users/create', [UsersController::class, 'create'])->name('users.create');
    Route::get('/users/{id}', [UsersController::class, 'edit'])->name('users.edit');
    Route::post('users', [UsersController::class, 'store'])->name('users.store');
    Route::delete('users/{id}', [UsersController::class, 'destroy'])->name('users.destroy');
    Route::put('users/{id}', [UsersController::class, 'update'])->name('users.update');
    Route::put('users/reset-password/{id}', [UsersController::class, 'resetPassword'])->name('users.reset_password');
});
