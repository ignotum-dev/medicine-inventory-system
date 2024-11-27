<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryCollection;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->authorizeResource(Category::class, 'category');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new CategoryCollection(Category::paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = app(StoreCategoryRequest::class)->validated();

        DB::transaction(function () use ($validatedData) {
            Category::create([
                'name' => $validatedData['name'],
            ]);
        });

        return response()->json(['message' => 'Category added successfully!'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        Category::findOrFail($category->id);

        $validatedData = app(UpdateCategoryRequest::class)->validated();

        DB::transaction(function () use ($validatedData, $category) {         
            $category->update([
                'name' => $validatedData['name'],
            ]);
        });

        return response()->json(['message' => 'Category updated successfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();

            return response()->json([
                'message' => 'Category deleted successfully',
                'status' => 'success'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete the category',
                'status' => 'error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
