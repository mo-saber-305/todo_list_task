<div class="modal fade" id="createTodoModal" tabindex="-1" aria-labelledby="createTodoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title modal-title-custom" id="createTodoModalLabel">
                    <i class="bi bi-pencil-square text-primary"></i>
                    <span>Task Details</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="taskForm">
                <div class="modal-body modal-body-custom">
                    <div class="alert alert-danger alert-dismissible fade show my-2 d-none rounded-3 border-0 shadow-sm" role="alert">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-exclamation-circle-fill"></i>
                            <strong></strong>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <input type="hidden" id="taskId">
                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold text-dark small">Task Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-custom" id="title" placeholder="e.g. Complete quarterly financial review" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold text-dark small">Description</label>
                        <textarea class="form-control form-control-custom" id="description" rows="3" placeholder="Add more context or details about this task..."></textarea>
                    </div>
                    <div class="mb-2">
                        <label for="category" class="form-label fw-semibold text-dark small">Category</label>
                        <select class="form-select form-select-custom" id="category"></select>
                    </div>
                </div>
                <div class="modal-footer modal-footer-custom">
                    <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-custom" id="createTodoSubmitBtn">
                        <i class="bi bi-check2"></i>
                        <span>Save Task</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
