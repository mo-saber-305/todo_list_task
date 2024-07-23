<div class="modal fade" id="createTodoModal" tabindex="-1" aria-labelledby="createTodoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="createTodoModalLabel">Add Task</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="taskForm">
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show my-3 d-none" role="alert">
                        <strong></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <input type="hidden" id="taskId">
                    <div class="form-group mb-3">
                        <label for="title"><strong>Title:</strong></label>
                        <input type="text" class="form-control" id="title">
                    </div>
                    <div class="form-group mb-3">
                        <label for="description"><strong>Description:</strong></label>
                        <textarea class="form-control" id="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="category"><strong>Category:</strong></label>
                        <select class="form-control" id="category"></select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="createTodoSubmitBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
