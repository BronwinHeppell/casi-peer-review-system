<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(): Response
    {
        $user = User::where('id', auth()->id())->firstOrFail();

        return Inertia::render('Auth/ResetPassword', [
            'email' => $user->email,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::findOrFail(auth()->id());

        $success = $user->update([
            'password' => $validated['password'],
            'password_reset' => false
        ]);
        \Illuminate\Log\log($success);

        return redirect()->route($success ? 'home': 'password.reset');
    }
}
