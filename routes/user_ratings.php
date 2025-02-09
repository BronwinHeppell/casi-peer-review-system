<?php

use App\Http\Controllers\UserRatings\UserRatingsController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('user_ratings', [UserRatingsController::class, 'index'])->name('user_ratings.index');
    Route::get('user_ratings/show/{userId}', [UserRatingsController::class, 'show'])->name('user_ratings.show');
    Route::get('user_ratings/my_history', [UserRatingsController::class, 'myHistory'])->name('user_ratings.my_history');
    Route::get('user_ratings/history/{ratingId}', [UserRatingsController::class, 'history'])->name('user_ratings.history');
    Route::put('user_ratings/history/{id}', [UserRatingsController::class, 'update'])->name('user_ratings.update');
});
