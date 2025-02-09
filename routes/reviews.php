<?php

use App\Http\Controllers\Reviews\ReviewsController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('peer_reviews', [ReviewsController::class, 'peerReviews'])->name('reviews.peer');
    Route::get('self_reviews', [ReviewsController::class, 'selfReviews'])->name('reviews.self');
    Route::get('manager_reviews', [ReviewsController::class, 'managerReviews'])->name('reviews.manager');
    Route::get('peer_reviews/{id}/{review_cycle_id}', [ReviewsController::class, 'reviewDetails'])->name('reviews.peerDetails');
    Route::get('self_reviews/{id}/{review_cycle_id}', [ReviewsController::class, 'reviewDetails'])->name('reviews.selfDetails');
    Route::get('manager_reviews/{id}/{review_cycle_id}', [ReviewsController::class, 'reviewDetails'])->name('reviews.managerDetails');
    Route::post('reviews', [ReviewsController::class, 'store'])->name('reviews.store');
    Route::post('reviews/complete', [ReviewsController::class, 'complete'])->name('reviews.complete');
});
