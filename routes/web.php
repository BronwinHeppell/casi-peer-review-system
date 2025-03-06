<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    /// Check if the user is authenticated
    if (Auth::check()) {

        return Inertia::render('Dashboard');
    }

    return redirect()->route('intro');
})->name('home');



require __DIR__ . '/auth.php';
require __DIR__ . '/users.php';
require __DIR__ . '/categories.php';
require __DIR__ . '/review_cycles.php';
require __DIR__ . '/questions.php';
require __DIR__ . '/reviews.php';
require __DIR__ . '/user_ratings.php';
require __DIR__ . '/intro.php';
