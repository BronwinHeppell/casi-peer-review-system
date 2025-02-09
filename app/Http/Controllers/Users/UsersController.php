<?php

namespace App\Http\Controllers\Users;

use App\Enums\UserRoles;
use App\Http\Controllers\Controller;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Inertia\Inertia;


class UsersController extends Controller
{

#region Get Views
    public function index()
    {
        $users = User::paginate(10);

        return Inertia::render('Users/Index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        return Inertia::render('Users/Show', ['roles' => UserRoles::cases()]);
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);

        return Inertia::render('Users/Show', [
            'user' => $user,
            'roles' => UserRoles::cases()
        ]);
    }
#endregion

#region Save Data
    public function store(Request $request)
    {
        $request->merge(['email_verified_at' => now()]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string',
            'is_admin' => 'boolean',
            'email_verified_at' => 'required|date',
        ]);

        $validated['email_verified_at'] = now();

        User::create($validated);

        flash()->options([
            'timeout' => 3000, // 3 seconds
            'position' => 'bottom-right',
        ])->success('User created successfully.');

        return redirect()->route('users.index');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email',
            'role' => 'required|string',
            'is_admin' => 'boolean',
            'view_rating_history' => 'boolean',
        ]);

        $user = User::findOrFail($id);

        $user->update($validated);

        flash()->options([
            'timeout' => 3000, // 3 seconds
            'position' => 'bottom-right',
        ])->success('User updated successfully.');

        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        flash()->options([
            'timeout' => 3000, // 3 seconds
            'position' => 'bottom-right',
        ])->success('User deleted successfully.');

        return redirect()->route('users.index');
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'password' => 'password',
            'password_reset' => true
        ]);

        flash()->options([
            'timeout' => 3000, // 3 seconds
            'position' => 'bottom-right',
        ])->success('User reset password updated successfully.');

        return redirect()->route('users.index');
    }
#endregion
}
