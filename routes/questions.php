<?php


use App\Http\Controllers\Questions\QuestionsController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('questions/{review_cycle_id}', [QuestionsController::class, 'index'])->name('questions.index');
    Route::get('questions/{review_cycle_id}/create', [QuestionsController::class, 'create'])->name('questions.create');
    Route::get('/questions/{review_cycle_id}/{id}', [QuestionsController::class, 'edit'])->name('questions.edit');
    Route::post('questions', [QuestionsController::class, 'store'])->name('questions.store');
    Route::delete('questions/{id}', [QuestionsController::class, 'destroy'])->name('questions.destroy');
    Route::put('questions/{id}', [QuestionsController::class, 'update'])->name('questions.update');
});
