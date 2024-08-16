<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    protected CategoryService $categoryService;

    /**
     * Create a new controller instance.
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->middleware('auth');
        $this->categoryService = $categoryService;
    }

    /**
     * Show the application dashboard.
     */
    public function index(): View
    {
        $categories = $this->categoryService->getAllCategories();

        return view('home', compact('categories'));
    }
}
