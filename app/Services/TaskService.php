<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class TaskService
{
    /**
     * Retrieve tasks with eager loading, dynamic filtering, and pagination.
     */
    public function getFilteredTasks(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Task::query()->with('category');

        // Filter by Trash (Soft Deleted)
        if (isset($filters['type']) && $filters['type'] === 'trash') {
            $query->onlyTrashed();
        }

        // Filter by Category
        if (! empty($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        // Filter by Status (Pending / Completed)
        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Search by Title or Description
        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function (Builder $q) use ($search) {
                $q->where('title', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%');
            });
        }

        // Order by manual position, then latest ID
        return $query->orderBy('order', 'asc')->orderBy('id', 'desc')->paginate($perPage);
    }

    /**
     * Create a new task with sequential order index.
     */
    public function createTask(array $data): Task
    {
        if (! isset($data['order'])) {
            $maxOrder = Task::max('order') ?? 0;
            $data['order'] = $maxOrder + 1;
        }

        return Task::create($data);
    }

    /**
     * Update an existing task.
     */
    public function updateTask(Task $task, array $data): bool
    {
        return $task->update($data);
    }

    /**
     * Soft delete a task (Move to Trash).
     */
    public function deleteTask(Task $task): ?bool
    {
        return $task->delete();
    }

    /**
     * Restore a soft-deleted task from trash.
     */
    public function restoreTask(int|string $id): Task
    {
        $task = Task::withTrashed()->findOrFail($id);
        $task->restore();

        return $task;
    }

    /**
     * Toggle the status of a task between Pending and Completed.
     */
    public function toggleTaskStatus(Task $task): bool
    {
        $newStatus = $task->status === 'completed' ? 'pending' : 'completed';

        return $task->update(['status' => $newStatus]);
    }

    /**
     * Reorder task positions inside a database transaction.
     */
    public function reorderTasks(array $orderedIds): bool
    {
        if (empty($orderedIds)) {
            return false;
        }

        return DB::transaction(function () use ($orderedIds) {
            foreach ($orderedIds as $index => $id) {
                Task::where('id', $id)->update(['order' => $index + 1]);
            }

            return true;
        });
    }
}
