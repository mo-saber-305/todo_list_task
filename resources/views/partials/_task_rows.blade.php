@forelse ($tasks as $task)
    <tr data-id="{{ $task->id }}" class="task-row">
        <td class="align-middle">
            <div class="d-flex align-items-center">
                @if(request()->type != 'trash')
                    <span class="drag-handle me-2" title="Drag to reorder">
                        <i class="bi bi-grip-vertical fs-5"></i>
                    </span>
                @endif
                <div class="fw-bold text-dark">{{ $task->title }}</div>
            </div>
        </td>
        <td class="align-middle text-muted">
            <span class="text-truncate d-inline-block desc-truncate" title="{{ $task->description }}">
                {{ $task->description ?: '—' }}
            </span>
        </td>
        <td class="align-middle">
            @if($task->category)
                <span class="badge-category">{{ $task->category->name }}</span>
            @else
                <span class="text-muted small">—</span>
            @endif
        </td>
        <td class="align-middle">
            @if($task->status == 'completed')
                <span class="badge-status completed">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>Completed</span>
                </span>
            @else
                <span class="badge-status pending">
                    <i class="bi bi-clock-fill"></i>
                    <span>Pending</span>
                </span>
            @endif
        </td>
        <td class="align-middle text-muted small fw-medium">
            {{ $task->created_at->diffForHumans() }}
        </td>
        <td class="align-middle text-center">
            <div class="d-flex align-items-center justify-content-center">
                @if(request()->type == 'trash')
                    <button class="btn-action btn-action-restore task-restore-btn" data-id="{{ $task->id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Restore Task">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </button>
                @else
                    @if($task->status == 'completed')
                        <button class="btn-action btn-action-complete" onclick="completeTask({{ $task->id }}, '{{ $task->status }}')" data-bs-toggle="tooltip" data-bs-placement="top" title="Mark as Pending">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </button>
                    @else
                        <button class="btn-action btn-action-complete" onclick="completeTask({{ $task->id }}, '{{ $task->status }}')" data-bs-toggle="tooltip" data-bs-placement="top" title="Mark as Completed">
                            <i class="bi bi-check2-circle"></i>
                        </button>
                    @endif
                    <button class="btn-action btn-action-edit" onclick="editTask({{ $task->id }})" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Task">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <button class="btn-action btn-action-delete task-delete-btn" data-id="{{ $task->id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Move to Trash">
                        <i class="bi bi-trash3"></i>
                    </button>
                @endif
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center py-5">
            <div class="py-4">
                <i class="bi bi-clipboard2-x text-muted empty-state-icon"></i>
                <div class="text-muted fw-semibold mt-2">No tasks found</div>
                <div class="text-muted small">Create a new task or adjust your filters</div>
            </div>
        </td>
    </tr>
@endforelse
