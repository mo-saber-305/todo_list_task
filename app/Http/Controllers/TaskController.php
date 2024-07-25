<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Task::query();


            if ($request->type == 'trash') {
                $query = $query->onlyTrashed();
            }

            if ($request->category) {
                $query = $query->where('category_id', $request->category);
            }

            if ($request->status) {
                $query = $query->where('status', $request->status);
            }

            if ($request->search) {
                $query = $query->where(function ($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->search . '%')
                        ->orWhere('description', 'like', '%' . $request->search . '%');
                });
            }

            $tasks = $query->latest()->paginate(3);

            $data = '';

            if (count($tasks)) {
                foreach ($tasks as $task) {
                    $categoryName = $task->category ? $task->category->name : '-------';
                    $taskDescription = $task->description ? $task->description : '-------';
                    if ($task->status == 'completed') {
                        $icon = 'undo_icon.png';
                        $tooltipText = 'Make As Pending';
                    } else {
                        $icon = 'check_circle_icon.png';
                        $tooltipText = 'Make As Completed';
                    }

                    $data .= '<tr class="fw-normal">
                                <td class="align-middle text-secondary fw-bold">' . $task->title . '</td>
                                <td class="align-middle text-secondary fw-bold">' . $taskDescription . '</td>
                                <td class="align-middle text-secondary fw-bold">' . $categoryName . '</td>
                                <td class="align-middle">
                                    <h6 class="mb-0">
                                    <span class="badge ' . ($task->status == 'completed' ? 'bg-success' : 'bg-primary') . '">' . $task->status . '</span>
                                    </h6>
                                </td>
                                 <td class="align-middle text-secondary fw-bold">' . $task->created_at->diffForHumans() . '</td>
                                <td class="align-middle">';
                    if ($request->type == 'trash') {
                        $data .= '<button class="btn px-1 task-restore-btn" data-id="' . $task->id . '">
                                        <img src="' . asset('assets/img/restore_icon.png') . '" width="20" alt="restore icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Restore Task">
                                    </button>';
                    } else {
                        $data .= '<button class="btn px-1" onclick="completeTask(' . $task->id . ', ' . '\'' . $task->status .'\'' . ')" data-bs-toggle="tooltip" data-bs-placement="top" title="' . $tooltipText . '">
                                        <img src="' . asset('assets/img/' . $icon) . '" width="20" alt="edit icon">
                                    </button>
                                    <button class="btn px-1" onclick="editTask(' . $task->id . ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Task">
                                        <img src="' . asset('assets/img/edit_icon.png') . '" width="20" alt="edit icon">
                                    </button>
                                    <button class="btn px-1 task-delete-btn" data-id="' . $task->id . '">
                                        <img src="' . asset('assets/img/trash_icon.png') . '" width="20" alt="trash icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Task">
                                    </button>';
                    }

                    $data .= '</td>
                            </tr>';
                }
            } else {
                $data .= '<tr class="fw-normal" >
                                <th class="align-middle text-secondary" colspan="6">There are no tasks currently available</th>
                          </tr>';
            }


            return response()->api(true, 'Tasks Data', $data, $tasks->hasMorePages());

        } catch (\Exception $e) {
            return response()->api(false, 'There was an error, please try again later');
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'category_id' => 'nullable|exists:categories,id',
            ]);

            if ($validator->fails()) {
                return response()->api(false, $validator->getMessageBag()->first());
            }

            $task = Task::create([
                'title' => $request->title,
                'description' => $request->description,
                'category_id' => $request->category_id,
            ]);

            return response()->api(true, 'Task has been created successfully', $task);
        } catch (\Exception $e) {
            return response()->api(false, 'There was an error, please try again later');
        }
    }

    public function show($id)
    {
        try {
            $task = Task::find($id);
            if (!$task) {
                return response()->api(false, 'The task you want to edit does not exist');
            }

            return response()->api(true, 'Task data', $task);
        } catch (\Exception $e) {
            return response()->api(false, 'There was an error, please try again later');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'category_id' => 'nullable|exists:categories,id',
            ]);

            if ($validator->fails()) {
                return response()->api(false, $validator->getMessageBag()->first());
            }

            $task = Task::find($id);
            if (!$task) {
                return response()->api(false, 'The task you want to modify does not exist');
            }

            $task->update([
                'title' => $request->title,
                'description' => $request->description,
                'category_id' => $request->category_id,
            ]);

            return response()->api(true, 'Task has been updated successfully', $task);
        } catch (\Exception $e) {
            return response()->api(false, 'There was an error, please try again later');
        }
    }

    public function destroy($id)
    {
        try {
            $task = Task::find($id);
            if (!$task) {
                return response()->api(false, 'The task you want to delete does not exist');
            }

            $task->delete();

            return response()->api(true, 'Task has been deleted successfully', $task);
        } catch (\Exception $e) {
            return response()->api(false, 'There was an error, please try again later');
        }
    }

    public function restore($id)
    {
        try {
            $task = Task::withTrashed()->find($id);

            if (!$task) {
                return response()->api(false, 'The task you want to restore does not exist');
            }

            $task->restore();

            return response()->api(true, 'Task has been restored successfully', $task);
        } catch (\Exception $e) {
            return response()->api(false, 'There was an error, please try again later');
        }
    }

    public function complete($id, Request $request)
    {
        try {
            $task = Task::find($id);

            if (!$task) {
                return response()->api(false, 'The task you want to change status does not exist');
            }

            if ($request->status == 'completed') {
                $status = 'pending';
            } else {
                $status = 'completed';
            }

            $task->update(['status' => $status]);

            return response()->api(true, 'Task has been updated status successfully', $task);
        } catch (\Exception $e) {
            return response()->api(false, 'There was an error, please try again later');
        }
    }
}
