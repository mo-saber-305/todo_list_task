<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-confirm-dialog">
        <div class="modal-content modal-content-custom text-center">
            <div class="modal-body modal-body-custom py-4 px-4">
                <div class="modal-confirm-icon modal-confirm-icon-danger">
                    <i class="bi bi-trash3"></i>
                </div>
                <h4 class="fw-bold text-dark mb-2">Delete Task?</h4>
                <p class="text-muted mb-0 modal-confirm-text">This task will be moved to the trash. You can easily restore it at any time.</p>
            </div>
            <div class="modal-footer modal-footer-custom justify-content-center gap-2 py-3">
                <button type="button" class="btn btn-secondary-custom px-4 py-2" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger px-4 py-2 rounded-3 fw-semibold shadow-sm" id="deleteSubmitBtn">Delete Task</button>
            </div>
        </div>
    </div>
</div>
