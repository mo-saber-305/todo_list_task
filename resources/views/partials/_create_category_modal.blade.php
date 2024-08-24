<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title modal-title-custom" id="createCategoryModalLabel">
                    <i class="bi bi-folder-plus text-primary"></i>
                    <span>New Category</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="categoryForm">
                <div class="modal-body modal-body-custom">
                    <div class="alert alert-danger alert-dismissible fade show my-2 d-none rounded-3 border-0 shadow-sm" role="alert">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-exclamation-circle-fill"></i>
                            <strong></strong>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <div class="mb-2">
                        <label for="categoryName" class="form-label fw-semibold text-dark small">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-custom" id="categoryName" placeholder="e.g. Work, Personal, Marketing" required>
                    </div>
                </div>
                <div class="modal-footer modal-footer-custom">
                    <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-custom" id="createCategorySubmitBtn">
                        <i class="bi bi-check2"></i>
                        <span>Save Category</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
