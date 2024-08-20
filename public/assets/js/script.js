/**
 * TaskFlow Pro — Frontend Interaction & AJAX Handler
 * 
 * Features:
 * - Dynamic Task Filtering & Live Search (Debounced)
 * - Drag & Drop Task Reordering (SortableJS)
 * - AJAX CRUD Operations (Task & Category)
 * - Soft-Delete & Trash Management
 */

let $csrfToken = $('meta[name="csrf-token"]').attr('content');
let currentPage = 1;
let sortableInstance = null;

$(document).ready(function () {
    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();

    // --------------------------------------------------------------------------
    // Filter & Search Event Listeners
    // --------------------------------------------------------------------------
    const debouncedLoadTasks = debounce(function() {
        currentPage = 1;
        let $type = $('input[name=btnradio]:checked').val();
        loadTasks($type, $('#filterSearch').val(), $('#filterCategory').val(), $('#filterStatus').val(), currentPage);
    }, 400);

    $('#filterSearch').on('input', debouncedLoadTasks);

    $('#filterCategory').on('change', function() {
        currentPage = 1;
        let $type = $('input[name=btnradio]:checked').val();
        loadTasks($type, $('#filterSearch').val(), $('#filterCategory').val(), $('#filterStatus').val(), currentPage);
    });

    $('#filterStatus').on('change', function() {
        currentPage = 1;
        let $type = $('input[name=btnradio]:checked').val();
        loadTasks($type, $('#filterSearch').val(), $('#filterCategory').val(), $('#filterStatus').val(), currentPage);
    });

    // View Switcher (All / Trash)
    $('input.btn-check, input[name=btnradio]').on('change', function() {
        currentPage = 1;
        let $type = $(this).val();
        loadTasks($type, $('#filterSearch').val(), $('#filterCategory').val(), $('#filterStatus').val(), currentPage);
    });

    // --------------------------------------------------------------------------
    // Initial Data Loading
    // --------------------------------------------------------------------------
    loadTasks('index', $('#filterSearch').val(), $('#filterCategory').val(), $('#filterStatus').val());
    loadCategories();

    // --------------------------------------------------------------------------
    // Task Modal & Submission
    // --------------------------------------------------------------------------
    $('#addTaskBtn').on('click', function () {
        $('#taskForm')[0].reset();
        $('#taskId').val('');
        $('#createTodoModalLabel span').text('Add New Task');
        $('.alert').addClass('d-none');
    });

    $('#taskForm').on('submit', function (e) {
        e.preventDefault();
        $('.card-loader-sec').css('display', 'flex');

        let id = $('#taskId').val();
        let url = id ? `/tasks/${id}` : '/tasks';
        let method = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            method: method,
            headers: { 'X-CSRF-TOKEN': $csrfToken },
            data: {
                title: $('#title').val(),
                description: $('#description').val(),
                category_id: $('#category').val(),
            },
            success: function (response) {
                if (response.status) {
                    $('#createTodoModal').modal('hide');
                    $('.alert').addClass('d-none');
                    currentPage = 1;
                    let $type = $('input[name=btnradio]:checked').val();
                    loadTasks($type, $('#filterSearch').val(), $('#filterCategory').val(), $('#filterStatus').val(), currentPage);
                    showAlert('success', response.message || 'Task saved successfully');
                } else {
                    $('#createTodoModal .alert').removeClass('d-none').find('strong').text(response.message);
                }
                $('.card-loader-sec').css('display', 'none');
            },
            error: function () {
                $('#createTodoModal .alert').removeClass('d-none').find('strong').text('An unexpected error occurred.');
                $('.card-loader-sec').css('display', 'none');
            }
        });
    });

    // --------------------------------------------------------------------------
    // Category Modal & Submission
    // --------------------------------------------------------------------------
    $('#addCategoryBtn').on('click', function () {
        $('#categoryForm')[0].reset();
        $('.alert').addClass('d-none');
    });

    $('#categoryForm').submit(function (e) {
        e.preventDefault();
        $('.card-loader-sec').css('display', 'flex');

        $.ajax({
            url: '/categories',
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': $csrfToken },
            data: {
                name: $('#categoryName').val()
            },
            success: function (response) {
                if (response.status) {
                    $('.alert').addClass('d-none');
                    showAlert('success', 'Category has been added successfully');
                    $('#createCategoryModal').modal('hide');
                    loadCategories();
                } else {
                    $('#createCategoryModal .alert').removeClass('d-none').find('strong').text(response.message);
                }
                $('.card-loader-sec').css('display', 'none');
            },
            error: function () {
                $('#createCategoryModal .alert').removeClass('d-none').find('strong').text('An unexpected error occurred.');
                $('.card-loader-sec').css('display', 'none');
            }
        });
    });

    // --------------------------------------------------------------------------
    // Delete & Restore Modal Triggers
    // --------------------------------------------------------------------------
    $(document).on('click', '.task-delete-btn', function (e) {
        e.preventDefault();
        let $taskId = $(this).data('id');
        $('#deleteModal').modal('show').find('#deleteSubmitBtn').attr('onclick', 'deleteTask(' + $taskId + ')');
    });

    $(document).on('click', '.task-restore-btn', function (e) {
        e.preventDefault();
        let $taskId = $(this).data('id');
        $('#restoreModal').modal('show').find('#restoreSubmitBtn').attr('onclick', 'restoreTask(' + $taskId + ')');
    });

    // --------------------------------------------------------------------------
    // Pagination (Load More)
    // --------------------------------------------------------------------------
    $('#loadMore').on('click', function() {
        currentPage++;
        let $type = $('input[name=btnradio]:checked').val();
        loadTasks($type, $('#filterSearch').val(), $('#filterCategory').val(), $('#filterStatus').val(), currentPage);
    });
});

// ==============================================================================
// Helper & API Functions
// ==============================================================================

/**
 * Display alert notifications
 */
function showAlert(type, message) {
    $('.alert').addClass('d-none');
    let $alert = type === 'success' ? $('.alert-success') : $('.alert-danger');
    $alert.removeClass('d-none').find('strong').text(message);
    setTimeout(() => {
        $alert.addClass('d-none');
    }, 5000);
}

/**
 * Initialize SortableJS for Drag & Drop row reordering
 */
function initSortable() {
    let tbody = document.querySelector('table tbody');
    if (!tbody) return;

    if (sortableInstance) {
        sortableInstance.destroy();
        sortableInstance = null;
    }

    let $type = $('input[name=btnradio]:checked').val();
    if ($type === 'trash') {
        return; // Disable reordering in trash view
    }

    if (typeof Sortable !== 'undefined') {
        sortableInstance = new Sortable(tbody, {
            handle: '.drag-handle',
            animation: 200,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            onEnd: function () {
                let orderedIds = [];
                $('table tbody tr.task-row').each(function () {
                    let id = $(this).data('id');
                    if (id) {
                        orderedIds.push(id);
                    }
                });

                if (orderedIds.length > 0) {
                    $.ajax({
                        url: '/tasks/reorder',
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': $csrfToken },
                        data: { ordered_ids: orderedIds },
                        success: function (response) {
                            if (response.status) {
                                showAlert('success', 'Tasks reordered successfully');
                            } else {
                                showAlert('danger', response.message || 'Failed to update order');
                            }
                        },
                        error: function () {
                            showAlert('danger', 'Failed to save tasks order.');
                        }
                    });
                }
            }
        });
    }
}

/**
 * Fetch and render paginated/filtered tasks
 */
function loadTasks(type = 'index', search = '', category = '', status = '', page = 1) {
    $('.card-loader-sec').css('display', 'flex');
    $('.alert').addClass('d-none');

    $.get('/tasks', { type, search, category, status, page }, function (response) {
        if (response.status) {
            let tasks = response.data;
            let taskList = $('table tbody');
            if (page === 1) {
                taskList.empty();
            }

            taskList.append(tasks);
            $('[data-bs-toggle="tooltip"]').tooltip();
            initSortable();

            if (response.hasMorePages) {
                $('#loadMoreContainer').removeClass('d-none');
            } else {
                $('#loadMoreContainer').addClass('d-none');
            }
        } else {
            showAlert('danger', response.message);
        }
        $('.card-loader-sec').css('display', 'none');
    }).fail(function() {
        showAlert('danger', 'Failed to load tasks.');
        $('.card-loader-sec').css('display', 'none');
    });
}

/**
 * Fetch categories for dropdown filters and modals
 */
function loadCategories() {
    $.get('/categories', function (categories) {
        let categoryList = $('#category');
        let categoryFilter = $('#filterCategory');
        let options = '<option value="">All Categories</option>';
        let modalOptions = '<option value="">Select Category (Optional)</option>';

        if (Array.isArray(categories)) {
            categories.forEach(function (category) {
                options += `<option value="${category.id}">${category.name}</option>`;
                modalOptions += `<option value="${category.id}">${category.name}</option>`;
            });
        }

        categoryFilter.empty().append(options);
        categoryList.empty().append(modalOptions);
    });
}

/**
 * Open task for editing
 */
function editTask(id) {
    $('.alert').addClass('d-none');
    $.ajax({
        url: `/tasks/${id}`,
        method: 'GET',
        headers: { 'X-CSRF-TOKEN': $csrfToken },
        success: function (response) {
            if (response.status) {
                $('#createTodoModalLabel span').text('Edit Task');
                $('#taskId').val(response.data.id);
                $('#title').val(response.data.title);
                $('#description').val(response.data.description);
                $('#category').val(response.data.category_id);
                $('#createTodoModal').modal('show');
            } else {
                showAlert('danger', response.message);
            }
        }
    });
}

/**
 * Move task to trash (Soft Delete)
 */
function deleteTask(id) {
    $('#deleteModal').modal('hide');
    $('.card-loader-sec').css('display', 'flex');
    let $type = $('input[name=btnradio]:checked').val();

    $.ajax({
        url: `/tasks/${id}`,
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': $csrfToken },
        success: function (response) {
            if (response.status) {
                showAlert('success', response.message);
                currentPage = 1;
                loadTasks($type, $('#filterSearch').val(), $('#filterCategory').val(), $('#filterStatus').val(), currentPage);
            } else {
                showAlert('danger', response.message);
                $('.card-loader-sec').css('display', 'none');
            }
        },
        error: function() {
            showAlert('danger', 'Failed to delete task.');
            $('.card-loader-sec').css('display', 'none');
        }
    });
}

/**
 * Restore task from trash
 */
function restoreTask(id) {
    $('#restoreModal').modal('hide');
    $('.card-loader-sec').css('display', 'flex');
    let $type = $('input[name=btnradio]:checked').val();

    $.ajax({
        url: `/tasks/${id}/restore`,
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': $csrfToken },
        success: function (response) {
            if (response.status) {
                showAlert('success', response.message);
                currentPage = 1;
                loadTasks($type, $('#filterSearch').val(), $('#filterCategory').val(), $('#filterStatus').val(), currentPage);
            } else {
                showAlert('danger', response.message);
                $('.card-loader-sec').css('display', 'none');
            }
        },
        error: function() {
            showAlert('danger', 'Failed to restore task.');
            $('.card-loader-sec').css('display', 'none');
        }
    });
}

/**
 * Toggle task status (Pending <-> Completed)
 */
function completeTask(id, status) {
    $('.card-loader-sec').css('display', 'flex');
    let $type = $('input[name=btnradio]:checked').val();

    $.ajax({
        url: `/tasks/${id}/complete`,
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': $csrfToken },
        data: { status: status },
        success: function (response) {
            if (response.status) {
                showAlert('success', response.message);
                currentPage = 1;
                loadTasks($type, $('#filterSearch').val(), $('#filterCategory').val(), $('#filterStatus').val(), currentPage);
            } else {
                showAlert('danger', response.message);
                $('.card-loader-sec').css('display', 'none');
            }
        },
        error: function() {
            showAlert('danger', 'Failed to update task status.');
            $('.card-loader-sec').css('display', 'none');
        }
    });
}

/**
 * Debounce utility function
 */
function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}
