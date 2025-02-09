<?php

namespace App\Http\Controllers\ReviewCycles;

use App\Enums\UserRoles;
use App\Http\Controllers\Controller;
use App\Models\Questions;
use App\Models\ReviewCycle;
use App\Models\Reviews;
use App\Models\User;
use App\Models\UserRatings;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class ReviewCycleController extends Controller
{
    #region Get Views
    public function index(): \Inertia\Response
    {
        $reviewCycles = ReviewCycle::where('is_complete', false)->paginate(10);

        return Inertia::render('ReviewCycles/Index', [
            'reviewCycles' => $reviewCycles
        ]);
    }

    public function create(): \Inertia\Response
    {
        return Inertia::render('ReviewCycles/Show');
    }


    public function edit($id): \Inertia\Response
    {
        $reviewCycle = ReviewCycle::findOrFail($id);
        return Inertia::render('ReviewCycles/Show', [
            'reviewCycle' => $reviewCycle,
        ]);
    }

    public function finalise($id): \Inertia\Response
    {
        $reviewCycle = ReviewCycle::findOrFail($id);
        $questions = Questions::where('review_cycle_id', $reviewCycle->id)
            ->with('category')
            ->get()
            ->groupBy('category.title');

        return Inertia::render('ReviewCycles/Finalise', [
            'reviewCycle' => $reviewCycle,
            'groupedQuestions' => $questions
        ]);
    }
#endregion

#region Save Data
    /**
     * @throws ValidationException
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'is_peer_review' => 'boolean',
            'is_self_review' => 'boolean',
            'is_manager_review' => 'boolean',
            'is_active' => 'boolean',
        ]);

        // Check if all review types are false then throw error
        if (!($validated['is_peer_review'] || $validated['is_self_review'] || $validated['is_manager_review'])) {
            throw ValidationException::withMessages([
                'review_type' => 'At least one review type must be selected.',
            ]);
        }

        $review = ReviewCycle::create($validated);

        if ($review) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->success('Review Cycle created successfully.');
        } else {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->error('Failed to create Review Cycle.');
        }

        return redirect()->route('questions.index', $review->id);
    }

    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'is_peer_review' => 'boolean',
            'is_self_review' => 'boolean',
            'is_manager_review' => 'boolean',
            'is_active' => 'boolean',
        ]);
        $reviewCycle = ReviewCycle::findOrFail($id);

        $success = $reviewCycle->update($validated);

        if ($success) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->success('Review Cycle updated successfully.');
        } else {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->error('Something went wrong.');
        }

        return redirect()->route('review_cycles.index');
    }

    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $user = ReviewCycle::findOrFail($id);
        $success = $user->delete();

        if ($success) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->success('Review Cycle deleted successfully.');
        } else {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->error('Something went wrong.');
        }

        return redirect()->route('review_cycles.index');
    }

    public function startReviewCycle($id): \Illuminate\Http\RedirectResponse
    {
        $reviewCycle = ReviewCycle::findOrFail($id);

        $success = $reviewCycle->update(['is_active' => true, 'is_complete' => false]);

        if ($success) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->success('Review Cycle started successfully.');

            $this->generateReviews($reviewCycle);
        } else {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->error('Something went wrong.');
        }

        return redirect()->route('review_cycles.index');
    }

    public function endReviewCycle($id): \Illuminate\Http\RedirectResponse
    {
        $reviewCycle = ReviewCycle::findOrFail($id);

        $success = $reviewCycle->update(['is_complete' => true, 'is_active' => false]);

        if ($success) {
            // get reviews for person
            $users = Reviews::where('review_cycle_id', $id)
                ->distinct()
                ->pluck('reviewee_id');

            foreach ($users as $userId) {
                // Get all reviews for this user in this cycle
                $reviews = Reviews::where('review_cycle_id', $id)
                    ->where('reviewee_id', $userId)
                    ->pluck('average_rating');

                // Calculate the average score
                $averageScore = $reviews->avg();

                // Store the calculated rating in `user_ratings`
                UserRatings::updateOrCreate(
                    [
                        'user_id' => $userId,
                        'review_cycle_id' => $id,
                        'average_rating' => $averageScore
                    ]
                );
            }

        } else {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->error('Something went wrong.');
        }

        return redirect()->route('review_cycles.index');
    }

    private function generateReviews(ReviewCycle $reviewCycle): void
    {
        // Assign empty reviews
        $reviews = [];
        // Get developer users only
        $developers = User::where('role', UserRoles::DEVELOPER)->get();
        $managers = User::where('role', UserRoles::MANAGER)->get();

        // Check the type of reviews
        if ($reviewCycle->is_self_review) {
            foreach ($developers as $developer) {
                if (!$developer || !isset($developer->id)) {
                    continue; // Skip if user is invalid
                }

                $reviews[] = [
                    'review_cycle_id' => $reviewCycle->id,
                    'reviewer_id' => $developer->id,
                    'reviewee_id' => $developer->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if ($reviewCycle->is_peer_review) {
            // loop through all developers
            foreach ($developers as $developer) {
                if (!$developer || !isset($developer->id)) {
                    continue; // Skip if user is invalid
                }

                // get all other developers
                $usersToReview = User::where('role', UserRoles::DEVELOPER)->where('id', '!=', $developer->id)->get();

                // loop through all other developers
                foreach ($usersToReview as $userToReview) {
                    if (!$userToReview || !isset($userToReview->id)) {
                        continue; // Skip if user is invalid
                    }

                    $reviews[] = [
                        'review_cycle_id' => $reviewCycle->id,
                        'reviewer_id' => $developer->id,
                        'reviewee_id' => $userToReview->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        if ($reviewCycle->is_manager_review) {
            foreach ($managers as $manager) {
                if (!$manager || !isset($manager->id)) {
                    continue; // Skip if user is invalid
                }

                // get all other developers
                $usersToReview = User::where('role', UserRoles::DEVELOPER)->get();

                // loop through all other developers
                foreach ($usersToReview as $userToReview) {
                    if (!$userToReview || !isset($userToReview->id)) {
                        continue; // Skip if user is invalid
                    }

                    $reviews[] = [
                        'review_cycle_id' => $reviewCycle->id,
                        'reviewer_id' => $manager->id,
                        'reviewee_id' => $userToReview->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        $success = Reviews::insert($reviews);

        if ($success) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->success('Review Cycle completed successfully and reviews created successfully.');
        } else {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->error('Failed to create Reviews.');
        }
    }
#endregion
}
