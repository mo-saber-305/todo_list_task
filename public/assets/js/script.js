let $csrfToken = $('meta[name="csrf-token"]').attr('content')
$(document).ready(function () {
    $('[data-bs-toggle="tooltip"]').tooltip();

    // Load tasks
    loadTasks();
    loadCategories();

    // Open add task modal
    $('#addTaskBtn').on('click', function () {
        $('#taskForm')[0].reset();
        $('#taskId').val('');
        $('.alert').addClass('d-none')
    });



    // Handle form submission
    $('#taskForm').on('submit', function (e) {
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
                    $('.todo-sec .top-box .alert-success').removeClass('d-none').find('strong').text(response.message)
                    loadTasks();
                } else {
                    $('#createTodoModal .alert').removeClass('d-none').find('strong').text(response.message)
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
                $('#createCategoryModal').modal('hide');
                loadCategories();
            }
        });
    });
});

function loadTasks() {
    $.get('/tasks', function (response) {
        if (response.status) {
            let tasks = response.data;
            let taskList = $('table tbody');
            taskList.empty();
            taskList.append(tasks)
            $('[data-bs-toggle="tooltip"]').tooltip();
        } else {
            $('.todo-sec .top-box .alert').addClass('d-none')
            $('.todo-sec .top-box .alert-danger').removeClass('d-none').find('strong').text(response.message)
        }

    });
}

function loadCategories() {
    $.get('/categories', function (categories) {
        let categoryList = $('#category');
        categoryList.empty();
        categoryList.append('<option value="">Select Category</option>');

        categories.forEach(function (category) {
            categoryList.append(`<option value="${category.id}">${category.name}</option>`);
        });
    });
}

function editTask(id) {
    $.get(`/tasks/${id}`, function (task) {
        $('#taskId').val(task.id);
        $('#title').val(task.title);
        $('#description').val(task.description);
        $('#category').val(task.category_id);
        $('#status').val(task.status);
        $('#createTodoModal').modal('show');
    });
}

function deleteTask(id) {
    if (confirm('Are you sure you want to delete this task?')) {
        $.ajax({
            url: `/tasks/${id}`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $csrfToken
            },
            success: function () {
                loadTasks();
            }
        });
    }
}
