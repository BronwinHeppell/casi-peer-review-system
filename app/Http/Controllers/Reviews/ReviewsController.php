<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use App\Models\QuestionResponse;
use App\Models\Questions;
use App\Models\ReviewCycle;
use App\Models\Reviews;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReviewsController extends Controller
{
    #region Get Views
    public function selfReviews(): \Inertia\Response
    {
        // get reviews where reviewer id is logged-in user
        $reviews = Reviews::with('reviewCycle')
            ->with('reviewer')
            ->with('reviewee')
            ->where('reviewer_id', auth()->id())
            ->where('reviewee_id', auth()->id())
            ->where('is_reviewed', false)
            ->paginate(10);

        return Inertia::render('Reviews/Index', [
            'reviews' => $reviews,
            'reviewType' => 'Self',
        ]);
    }

    public function peerReviews(): \Inertia\Response
    {
        // get reviews where reviewer id is logged in user and not reviewee id
        $reviews = Reviews::with('reviewCycle')
            ->where('reviewer_id', auth()->id())
            ->with('reviewer')
            ->with('reviewee')
            ->where('reviewee_id', '!=', auth()->id())
            ->where('is_reviewed', false)
            ->paginate(10);

        return Inertia::render('Reviews/Index', [
            'reviews' => $reviews,
            'reviewType' => 'Peer',
        ]);
    }

    public function managerReviews(): \Inertia\Response
    {
        $reviews = Reviews::with('reviewCycle')
            ->with('reviewer')
            ->with('reviewee')
            ->where('reviewer_id', auth()->id())
            ->where('reviewee_id', '!=', auth()->id())
            ->where('is_reviewed', false)
            ->paginate(10);

        return Inertia::render('Reviews/Index', [
            'reviews' => $reviews,
            'reviewType' => 'Manager',
        ]);
    }


    public function reviewDetails(Request $request, $id, $review_cycle_id)
    {
        $reviewType = $request->query('reviewType');
        \Illuminate\Log\log($request);
        $review = Reviews::with('reviewCycle')
            ->with('reviewee')
            ->findOrFail($id);

        $questions = Questions::with('category')
            ->where('review_cycle_id', $review_cycle_id)
            ->get()
            ->groupBy('category.title');

        return Inertia::render('Reviews/Show', [
            'review' => $review,
            'questions' => $questions,
            'reviewType' => $reviewType,
        ]);
    }
#endregion

#region Save Data
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $review = ReviewCycle::create($validated);

        flash()->options([
            'timeout' => 3000, // 3 seconds
            'position' => 'bottom-right',
        ])->success('Review Cycle created successfully.');

        return redirect()->route('questions.index', $review->id);
    }

    public function complete(Request $request)
    {
        \Log::info(json_encode($request->all()));  // Log the raw incoming request
        // update the review
        // calcualte avg
        // bulk insert reponses

        $validated = $request->validate([
            'ratings' => 'required|array',
            'ratings.*.question_id' => 'required|integer|exists:questions,id',
            'ratings.*.rating' => 'required|integer|min:1|max:5',
            'ratings.*.comment' => 'nullable|string',
        ]);

        // Process and store the ratings in the database
        foreach ($validated['ratings'] as $ratingData) {
            QuestionResponse::create([
                'review_id' => $request->review_id,
                'question_id' => $ratingData['question_id'],
                'reviewer_id' => auth()->id(),
                'rating' => $ratingData['rating'],
                'comment' => $ratingData['comment'] ?? '',
            ]);
        }

        $updatedReview = Reviews::findOrFail($request->review_id);

        $averageRating = QuestionResponse::where('review_id', $updatedReview->id)->avg('rating');

        $success = $updatedReview->update(['average_rating' => $averageRating, 'is_reviewed' => true]);

        if ($success) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->success('Review submitted successfully.');
        } else {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->error('Something went wrong.');
        }

        return redirect()->route('reviews.self');
    }
#endregion
}
