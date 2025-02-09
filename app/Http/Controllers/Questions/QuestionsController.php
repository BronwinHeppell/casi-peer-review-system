<?php

namespace App\Http\Controllers\Questions;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Questions;
use App\Models\ReviewCycle;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuestionsController extends Controller
{
    #region Get Views
    public function index($review_cycle_id)
    {
        $review_cycle = ReviewCycle::findOrFail($review_cycle_id);
        $questions = Questions::with('category')->where('review_cycle_id', $review_cycle_id)->paginate(10);
        return Inertia::render('ReviewCycles/Questions/Index', ['questions' => $questions, 'reviewCycle' => $review_cycle]);
    }

    public function create($review_cycle_id)
    {
        $categories = Category::all();
        return Inertia::render('ReviewCycles/Questions/Show', ['categories' => $categories, 'reviewCycleId' => $review_cycle_id]);
    }

    public function edit($review_cycle_id, $id)
    {
        $categories = Category::all();
        $question = Questions::findOrFail($id);
        return Inertia::render('ReviewCycles/Questions/Show', ['categories' => $categories, 'question' => $question, 'reviewCycleId' => $review_cycle_id]);
    }
    #endregion

    #region Save Data
    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'review_cycle_id' => 'required|exists:review_cycles,id',
        ]);

        Questions::create($validated);

        flash()->options([
            'timeout' => 3000, // 3 seconds
            'position' => 'bottom-right',
        ])->success('Question created successfully.');

        return redirect()->route('questions.index', ['review_cycle_id' => $validated['review_cycle_id']]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'review_cycle_id' => 'required|exists:review_cycles,id',
        ]);

        $question = Questions::findOrFail($id);

        $question->update($validated);

        flash()->options([
            'timeout' => 3000, // 3 seconds
            'position' => 'bottom-right',
        ])->success('Question updated successfully.');

        return redirect()->route('questions.index', ['review_cycle_id' => $validated['review_cycle_id']]);
    }

    public function destroy($id)
    {
        $question = Questions::findOrFail($id);
        $question->delete();

        flash()->options([
            'timeout' => 3000, // 3 seconds
            'position' => 'bottom-right',
        ])->success('Question deleted successfully.');

        return redirect()->route('questions.index', ['review_cycle_id' => $question->id]);

    }
    #endregion

}
