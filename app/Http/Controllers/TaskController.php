<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        try {
            $data = '';
            $tasks = Task::latest()->paginate(10);
            if (count($tasks)) {
                foreach ($tasks as $task) {
                    $categoryName = $task->category ? $task->category->name : '-------';
                    $data .= '<tr class="fw-normal">
                                <th class="align-middle text-secondary fw-normal">' . $task->title . '</th>
                                <td class="align-middle text-secondary">' . $task->description . '</td>
                                <td class="align-middle text-secondary">' . $categoryName . '</td>
                                <td class="align-middle">
                                    <h6 class="mb-0"><span class="badge bg-danger">' . $task->status . '</span></h6>
                                </td>
                                 <td class="align-middle text-secondary">' . $task->created_at->diffForHumans() . '</td>
                                <td class="align-middle">
                                    <button class="btn px-1" onclick="editTask(' . $task->id . ')" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Task">
                                        <img src="'.asset('assets/img/edit_icon.png').'" width="20" alt="edit icon">
                                    </button>
                                    <button class="btn px-1" onclick="deleteTask(' . $task->id . ')">
                                        <img src="'.asset('assets/img/trash_icon.png').'" width="20" alt="trash icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Task">
                                    </button>
                                </td>
                            </tr>';
                }
            } else {
                $data .= '<tr class="fw-normal" >
                                <th class="align-middle text-secondary" colspan="5">There are no tasks currently available</th>
                          </tr>';
            }


            return response()->api(true, 'Tasks Data', $data);
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
        $task = Task::findOrFail($id);
        return response()->json($task);
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
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->noContent();
    }

    public function restore($id)
    {
        $task = Task::withTrashed()->findOrFail($id);
        $task->restore();
        return response()->json($task);
    }
}
