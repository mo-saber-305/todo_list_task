<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = [
            [
                'title' => 'Saepe vero impedit',
                'description' => 'Incididunt autem neq Incididunt autem neq',
                'category_id' => 1,
                'status' => 'pending',
            ],[
                'title' => 'In velit et vero dol',
                'description' => 'Sed quisquam veniam',
                'category_id' => 3,
                'status' => 'completed',
            ],[
                'title' => 'Voluptate quis sint',
                'description' => 'Sed quisquam veniam Sed quisquam veniam',
                'category_id' => null,
                'status' => 'completed',
            ],[
                'title' => 'Qui laudantium cons',
                'description' => null,
                'category_id' => 2,
                'status' => 'pending',
            ],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}
