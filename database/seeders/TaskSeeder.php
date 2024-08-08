<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('data/tasks.json');

        if (! File::exists($jsonPath)) {
            return;
        }

        $tasksData = json_decode(File::get($jsonPath), true);

        // Clear existing tasks
        Task::withTrashed()->forceDelete();

        foreach ($tasksData as $index => $data) {
            $createdAt = Carbon::now()->subDays($data['days_ago'] ?? 0);

            $task = Task::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'category_id' => $data['category_id'],
                'status' => $data['status'],
                'order' => $index + 1,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            if (! empty($data['is_deleted'])) {
                $task->delete();
            }
        }
    }
}
