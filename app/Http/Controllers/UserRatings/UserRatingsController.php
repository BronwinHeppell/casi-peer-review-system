<?php

namespace App\Http\Controllers\UserRatings;

use App\Enums\UserRoles;
use App\Http\Controllers\Controller;
use App\Models\ReviewCycle;
use App\Models\Reviews;
use App\Models\User;
use App\Models\UserRatings;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserRatingsController extends Controller
{
    #region Get Views
    public function index(): \Inertia\Response
    {
        $users = User::paginate(10);

        return Inertia::render('UserRatings/Index', [
            'users' => $users
        ]);
    }

    public function show($id): \Inertia\Response
    {
        $user = User::findOrFail($id);
        $averageRating = round(UserRatings::where('user_id', $id)->avg('average_rating'), 0);
        $userRatings = UserRatings::where('user_id', $id)->with('reviewCycle')->paginate(10);

        return Inertia::render('UserRatings/Show', [
            'user' => $user,
            'userRatings' => $userRatings,
            'averageRating' => $averageRating
        ]);
    }

    public function myHistory(): \Inertia\Response
    {
        $id =auth()->id();
        $user = User::findOrFail($id);
        $averageRating = round(UserRatings::where('user_id', $id)->avg('average_rating'), 0);
        $userRatings = UserRatings::where('user_id', $id)->with('reviewCycle')->paginate(10);

        return Inertia::render('UserRatings/MyHistory', [
            'user' => $user,
            'userRatings' => $userRatings,
            'averageRating' => $averageRating
        ]);
    }

    public function history($id): \Inertia\Response
    {
        $userRating = UserRatings::with('user')->with('reviewCycle')->findOrFail($id);

        $selfReviewRatings = round(Reviews::where('review_cycle_id', $userRating->reviewCycle->id)
            ->where('reviewer_id', $userRating->user->id)
            ->where('reviewee_id', $userRating->user->id)
            ->avg('average_rating'));

        $peerReviewRatings = round(Reviews::where('review_cycle_id', $userRating->reviewCycle->id)
            ->where('reviewer_id', '!=', $userRating->user->id)
            ->where('reviewee_id', $userRating->user->id)
            ->avg('average_rating'));

        $managerReviewRatings = round(Reviews::where('review_cycle_id', $userRating->reviewCycle->id)
            ->with('reviewer')
            ->where('reviewer_id', '!=', $userRating->user->id)
            ->whereHas('reviewer', function ($query) {
                $query->where('role', UserRoles::MANAGER);
            })
            ->where('reviewee_id', $userRating->user->id)
            ->avg('average_rating'));

        return Inertia::render('UserRatings/History', [
            'userRating' => $userRating,
            'selfRating' => $selfReviewRatings,
            'peerRating' => $peerReviewRatings,
            'managerRating' => $managerReviewRatings,
        ]);
    }
    #endregion

    #region Save Data
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'manager_comment' => 'nullable|string|max:255',
            'comment' => 'nullable|string|max:1000',
        ]);

        $userRating = UserRatings::with('user')->findOrFail($id);

        $userRating->update($validated);

        flash()->options([
            'timeout' => 3000, // 3 seconds
            'position' => 'bottom-right',
        ])->success('Comments added successfully.');

        return redirect()->route('user_ratings.show', $userRating->user->id);
    }
    #endregion
}
