<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    /**
     * Retrieve all categories.
     */
    public function getAllCategories(): Collection
    {
        return Category::all();
    }

    /**
     * Create a new category with validated data.
     */
    public function createCategory(array $data): Category
    {
        return Category::create($data);
    }
}
