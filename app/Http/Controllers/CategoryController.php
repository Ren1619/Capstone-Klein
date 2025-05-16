<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request, $type = null)
    {
        $categories = $type ? Category::where('category_type', $type)->get() : Category::all();

        return view('categories.index', compact('categories'));
    }

    /**
     * Get categories of type product (API route).
     */
    public function getProductCategories()
    {
        return response()->json(Category::where('category_type', 'product')->get());
    }

    /**
     * Get categories of type service (API route).
     */
    public function getServiceCategories()
    {
        return response()->json(Category::where('category_type', 'service')->get());
    }



    /**
     * Show the form for creating a new category.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = [
            Category::TYPE_PRODUCT => 'Product',
            Category::TYPE_SERVICE => 'Service'
        ];

        return view('categories.create', compact('types'));
    }

    /**
     * Store a newly created category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Explicitly define the valid category types
        $validTypes = ['product', 'service'];

        // Check if the provided type is valid
        if (!in_array($request->category_type, $validTypes)) {
            return back()->withInput()->with('error', 'Invalid category type: ' . $request->category_type);
        }

        // Validate other fields
        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Add the category_type to the validated data
        $validated['category_type'] = $request->category_type;

        // Debug what's being passed
        \Log::info('Creating category with data:', $validated);

        // Create the category
        $category = Category::create($validated);

        // Debug the created category
        \Log::info('Created category:', $category->toArray());

        // Redirect back with success message
        return back()->with('success', 'Category created successfully');
    }

    /**
     * Display the specified category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $types = [
            Category::TYPE_PRODUCT => 'Product',
            Category::TYPE_SERVICE => 'Service'
        ];

        return view('categories.edit', compact('category', 'types'));
    }

    /**
     * Update the specified category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'category_type' => 'required|in:' . Category::TYPE_PRODUCT . ',' . Category::TYPE_SERVICE,
            'description' => 'nullable|string',
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        // Check for related products or services before deletion
        if ($category->products()->count() > 0 || $category->services()->count() > 0) {
            return redirect()->route('categories.index')
                ->with('error', 'Cannot delete category. It has associated products or services.');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    /**
     * Get categories by type (API endpoint)
     *
     * @param  string  $type
     * @return \Illuminate\Http\Response
     */
}