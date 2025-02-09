<?php

use App\Http\Controllers\Profile\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    if (Auth::check()) {

        $user = User::where('id', auth()->id())->firstOrFail();
        if ($user->password_reset) {
            return redirect()->route('password.reset');
        }

        return Inertia::render('Dashboard');
    }

    return redirect()->route('login');
})->name('home');

require __DIR__ . '/auth.php';
require __DIR__ . '/users.php';
require __DIR__ . '/categories.php';
require __DIR__ . '/review_cycles.php';
require __DIR__ . '/questions.php';
require __DIR__ . '/reviews.php';
require __DIR__ . '/user_ratings.php';
