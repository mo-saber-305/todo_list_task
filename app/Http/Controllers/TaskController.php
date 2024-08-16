<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Display a paginated listing of tasks with dynamic filtering.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $tasks = $this->taskService->getFilteredTasks($request->all(), 10);
            $html = view('partials._task_rows', compact('tasks'))->render();

            return response()->api(true, 'Tasks Data', $html, $tasks->hasMorePages());
        } catch (\Exception $e) {
            return response()->api(false, 'There was an error loading tasks');
        }
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        try {
            $task = $this->taskService->createTask($request->validated());

            return response()->api(true, 'Task has been created successfully', $task);
        } catch (\Exception $e) {
            return response()->api(false, 'There was an error creating the task');
        }
    }

    /**
     * Display the specified task details.
     */
    public function show(int|string|Task $id): JsonResponse
    {
        try {
            $task = $id instanceof Task ? $id : Task::findOrFail($id);

            return response()->api(true, 'Task data', $task);
        } catch (\Exception $e) {
            return response()->api(false, 'The requested task does not exist');
        }
    }

    /**
     * Update the specified task in storage.
     */
    public function update(UpdateTaskRequest $request, int|string|Task $id): JsonResponse
    {
        try {
            $task = $id instanceof Task ? $id : Task::findOrFail($id);
            $this->taskService->updateTask($task, $request->validated());

            return response()->api(true, 'Task has been updated successfully', $task);
        } catch (\Exception $e) {
            return response()->api(false, 'There was an error updating the task');
        }
    }

    /**
     * Remove the specified task from storage (Soft Delete).
     */
    public function destroy(int|string|Task $id): JsonResponse
    {
        try {
            $task = $id instanceof Task ? $id : Task::findOrFail($id);
            $this->taskService->deleteTask($task);

            return response()->api(true, 'Task has been moved to trash', $task);
        } catch (\Exception $e) {
            return response()->api(false, 'There was an error deleting the task');
        }
    }

    /**
     * Restore the specified soft-deleted task from trash.
     */
    public function restore(int|string $id): JsonResponse
    {
        try {
            $task = $this->taskService->restoreTask($id);

            return response()->api(true, 'Task has been restored successfully', $task);
        } catch (\Exception $e) {
            return response()->api(false, 'There was an error restoring the task');
        }
    }

    /**
     * Toggle the status of the specified task (Pending <-> Completed).
     */
    public function complete(Request $request, int|string|Task $id): JsonResponse
    {
        try {
            $task = $id instanceof Task ? $id : Task::findOrFail($id);
            $this->taskService->toggleTaskStatus($task);

            return response()->api(true, 'Task status updated successfully', $task);
        } catch (\Exception $e) {
            return response()->api(false, 'There was an error updating task status');
        }
    }

    /**
     * Reorder task positions (Drag & Drop).
     */
    public function reorder(Request $request): JsonResponse
    {
        $request->validate([
            'ordered_ids' => ['required', 'array'],
            'ordered_ids.*' => ['required', 'integer'],
        ]);

        try {
            $this->taskService->reorderTasks($request->input('ordered_ids'));

            return response()->api(true, 'Tasks reordered successfully');
        } catch (\Exception $e) {
            return response()->api(false, 'Failed to update tasks order');
        }
    }
}
