let $csrfToken = $('meta[name="csrf-token"]').attr('content')
let currentPage = 1;
$(document).ready(function () {
    $('[data-bs-toggle="tooltip"]').tooltip();

    const debouncedLoadTasks = debounce(function() {
        currentPage = 1;
        let $type = $('input[name=btnradio]:checked').val();
        loadTasks($type, $('#filterSearch').val(), $('#filterCategory').val(), $('#filterStatus').val(), currentPage);
    }, 500); // Adjust the delay as needed (500 milliseconds in this case)

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
    // Load tasks
    loadTasks('index', $('#filterSearch').val(), $('#filterCategory').val(), $('#filterStatus').val());
    loadCategories();

    // Open add task modal
    $('#addTaskBtn').on('click', function () {
        $('#taskForm')[0].reset();
        $('#taskId').val('');
        $('.alert').addClass('d-none')
    });


    // Handle form submission
    $('#taskForm').on('submit', function (e) {
        $('.card-loader-sec').css('display', 'flex')
        e.preventDefault();
        let id = $('#taskId').val();
        let url = id ? `/tasks/${id}` : '/tasks';
        let method = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            method: method,
            headers: {
                'X-CSRF-TOKEN': $csrfToken
            },
            data: {
                title: $('#title').val(),
                description: $('#description').val(),
                category_id: $('#category').val(),
            },
            success: function (response) {
                if (response.status) {
                    $('#createTodoModal').modal('hide');
                    $('.todo-sec .top-box .alert').addClass('d-none')
                    currentPage = 1;
                    let $type = $('input[name=btnradio]:checked').val();
                    loadTasks($type, $('#filterSearch').val(), $('#filterCategory').val(), $('#filterStatus').val(), currentPage);
                    $('.todo-sec .top-box .alert-success').removeClass('d-none').find('strong').text(response.message)
                } else {
                    $('#createTodoModal .alert').removeClass('d-none').find('strong').text(response.message)
                    $('.card-loader-sec').css('display', 'none')
                }
            }
        });

    });

    // Open add category modal
    $('#addCategoryBtn').on('click', function () {
        $('#categoryForm')[0].reset();
    });

    // Handle form submission
    $('#categoryForm').submit(function (e) {
        $('.card-loader-sec').css('display', 'flex')
        e.preventDefault();
        let url = '/categories';
        let method = 'POST';

        $.ajax({
            url: url,
            method: method,
            headers: {
                'X-CSRF-TOKEN': $csrfToken
            },
            data: {
                name: $('#categoryName').val()
            },
            success: function (response) {
                if (response.status) {
                    $('.todo-sec .top-box .alert').addClass('d-none')
                    $('.todo-sec .top-box .alert-success').removeClass('d-none').find('strong').text('Category has been added successfully')
                    $('#createCategoryModal').modal('hide');
                    loadCategories();
                    $('.card-loader-sec').css('display', 'none')
                } else {
                    $('#createCategoryModal .alert').removeClass('d-none').find('strong').text(response.message)
                    $('.card-loader-sec').css('display', 'none')
                }
            }
        });
    });

    $(document).on('click', '.task-delete-btn', function (e) {
        e.preventDefault();
        let $taskId = $(this).data('id');
        let $onClick = 'deleteTask(' + $taskId + ')';
        $('#deleteModal').modal('show').find('#deleteSubmitBtn').attr('onclick', $onClick);
    })

    $(document).on('click', '.task-restore-btn', function (e) {
        e.preventDefault();
        let $taskId = $(this).data('id');
        let $onClick = 'restoreTask(' + $taskId + ')';
        $('#restoreModal').modal('show').find('#restoreSubmitBtn').attr('onclick', $onClick);
    })

    // Load more tasks on "Load More" button click
    $('#loadMore').on('click', function() {
        currentPage++;
        let $type = $('input[name=btnradio]:checked').val();
        loadTasks($type, $('#filterSearch').val(), $('#filterCategory').val(), $('#filterStatus').val(), currentPage);
    });

    $('input.btn-check').on('click', function() {
        currentPage = 1;
        let $type = $(this).val();
        loadTasks($type, $('#filterSearch').val(), $('#filterCategory').val(), $('#filterStatus').val(), currentPage);
    });
});

function loadTasks(type= 'index', search = '', category = '', status = '', page = 1) {
    $('.card-loader-sec').css('display', 'flex')
    $('.todo-sec .top-box .alert').addClass('d-none')
    $.get('/tasks', { type, search, category, status, page }, function (response) {
        if (response.status) {
            let tasks = response.data;
            let taskList = $('table tbody');
            if (page === 1) {
                taskList.empty(); // Clear existing tasks only if loading the first page
            }

            taskList.append(tasks)
            $('[data-bs-toggle="tooltip"]').tooltip();

            // Show or hide the "Load More" button based on response
            if (response.hasMorePages) {
                $('#loadMore').show();
            } else {
                $('#loadMore').hide();
            }
        } else {
            $('.todo-sec .top-box .alert').addClass('d-none')
            $('.todo-sec .top-box .alert-danger').removeClass('d-none').find('strong').text(response.message)
        }
        $('.card-loader-sec').css('display', 'none');
    });
}

function loadCategories() {
    $.get('/categories', function (categories) {
        let categoryList = $('#category');
        let categoryFilter = $('#filterCategory');
        let options = '<option value="">Select Category</option>';

        categories.forEach(function (category) {
            options += `<option value="${category.id}">${category.name}</option>`;
        });

        categoryList.empty().append(options);
        categoryFilter.empty().append(options);
    });
}

function editTask(id) {
    $('.alert').addClass('d-none')
    $.ajax({
        url: `/tasks/${id}`,
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': $csrfToken
        },
        success: function (response) {
            if (response.status) {
                $('#taskId').val(response.data.id);
                $('#title').val(response.data.title);
                $('#description').val(response.data.description);
                $('#category').val(response.data.category_id);
                $('#status').val(response.data.status);
                $('#createTodoModal').modal('show');
            } else {
                $('.todo-sec .top-box .alert-danger').removeClass('d-none').find('strong').text(response.message)
            }
        }
    });
}

function deleteTask(id) {
    $('#deleteModal').modal('hide')
    $('.card-loader-sec').css('display', 'flex')
    $.ajax({
        url: `/tasks/${id}`,
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $csrfToken
        },
        success: function (response)  {
            if (response.status) {
                $('.todo-sec .top-box .alert').addClass('d-none')
                $('.todo-sec .top-box .alert-success').removeClass('d-none').find('strong').text(response.message)
                currentPage = 1;
                loadTasks('index', $('#filterSearch').val(), $('#filterCategory').val(), $('#filterStatus').val(), currentPage);
            } else {
                $('#createTodoModal .alert').removeClass('d-none').find('strong').text(response.message)
                $('.card-loader-sec').css('display', 'none')
            }
        }
    });
}

function restoreTask(id) {
    $('#restoreModal').modal('hide')
    $('.card-loader-sec').css('display', 'flex')
    let $type = $('input[name=btnradio]:checked').val();
    $.ajax({
        url: `/tasks/${id}/restore`,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $csrfToken
        },
        success: function (response) {
            if (response.status) {
                $('.todo-sec .top-box .alert').addClass('d-none')
                $('.todo-sec .top-box .alert-success').removeClass('d-none').find('strong').text(response.message)
                currentPage = 1;
                loadTasks($type, $('#filterSearch').val(), $('#filterCategory').val(), $('#filterStatus').val(), currentPage);
            } else {
                $('.todo-sec .top-box .alert-danger').removeClass('d-none').find('strong').text(response.message)
                $('.card-loader-sec').css('display', 'none')
            }
        }
    });
}


function completeTask(id, status) {
    $('#restoreModal').modal('hide')
    $('.card-loader-sec').css('display', 'flex')
    $.ajax({
        url: `/tasks/${id}/complete`,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $csrfToken
        },
        data: {
            status: status
        },
        success: function (response) {
            if (response.status) {
                $('.todo-sec .top-box .alert').addClass('d-none')
                $('.todo-sec .top-box .alert-success').removeClass('d-none').find('strong').text(response.message)
                currentPage = 1;
                loadTasks('index', $('#filterSearch').val(), $('#filterCategory').val(), $('#filterStatus').val(), currentPage);
            } else {
                $('.todo-sec .top-box .alert-danger').removeClass('d-none').find('strong').text(response.message)
                $('.card-loader-sec').css('display', 'none')
            }
        }
    });
}

// Define the debounce function
function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}
