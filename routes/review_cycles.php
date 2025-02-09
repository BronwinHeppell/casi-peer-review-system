<?php

use App\Http\Controllers\ReviewCycles\ReviewCycleController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('review_cycles' ,[ReviewCycleController::class, 'index'])->name('review_cycles.index');
    Route::get('review_cycles/create', [ReviewCycleController::class, 'create'])->name('review_cycles.create');
    Route::get('/review_cycles/{id}', [ReviewCycleController::class, 'edit'])->name('review_cycles.edit');
    Route::get('/review_cycles/{id}/finalise', [ReviewCycleController::class, 'finalise'])->name('review_cycles.finalise');
    Route::post('review_cycles', [ReviewCycleController::class, 'store'])->name('review_cycles.store');
    Route::delete('review_cycles/{id}', [ReviewCycleController::class, 'destroy'])->name('review_cycles.destroy');
    Route::put('review_cycles/{id}', [ReviewCycleController::class, 'update'])->name('review_cycles.update');
    Route::put('review_cycles/{id}/start', [ReviewCycleController::class, 'startReviewCycle'])->name('review_cycles.start');
    Route::put('review_cycles/{id}/complete', [ReviewCycleController::class, 'endReviewCycle'])->name('review_cycles.end');
});
