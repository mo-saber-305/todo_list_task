<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('data/categories.json');

        if (! File::exists($jsonPath)) {
            return;
        }

        $categories = json_decode(File::get($jsonPath), true);

        foreach ($categories as $category) {
            Category::updateOrCreate(['id' => $category['id']], [
                'name' => $category['name'],
            ]);
        }
    }
}
