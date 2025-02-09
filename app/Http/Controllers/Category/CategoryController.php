<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    #region Get Views
    public function index(): Response
    {
        $categories = Category::orderBy('created_at', 'desc')->paginate(10);

        return Inertia::render('Categories/Index', ['categories' => $categories]);

    }

    public function create(): Response
    {
        return Inertia::render('Categories/Show');
    }


    public function edit($id): Response
    {
        $category = Category::findOrFail($id);
        return Inertia::render('Categories/Show', ['category' => $category]);
    }
    #endregion

#region Save Data
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        Category::create($validated);

        flash()->options([
            'timeout' => 3000, // 3 seconds
            'position' => 'bottom-right',
        ])->success('Category created successfully.');

        return redirect()->route('categories.index');
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        $category = Category::findOrFail($id);

        $category->update($validated);

        flash()->options([
            'timeout' => 3000, // 3 seconds
            'position' => 'bottom-right',
        ])->success('Category updated successfully.');

        return redirect()->route('categories.index');
    }


    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        flash()->options([
            'timeout' => 3000, // 3 seconds
            'position' => 'bottom-right',
        ])->success('Category deleted successfully.');

        return redirect()->route('categories.index');
    }
#endregion

}

