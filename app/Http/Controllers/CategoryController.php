<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of all categories.
     */
    public function index(): JsonResponse
    {
        $categories = $this->categoryService->getAllCategories();

        return response()->json($categories);
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        try {
            $category = $this->categoryService->createCategory($request->validated());

            return response()->api(true, 'Category created successfully', $category);
        } catch (\Exception $e) {
            return response()->api(false, 'There was an error creating category');
        }
    }
}
