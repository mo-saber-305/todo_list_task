@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
@endpush

@section('content')

    <div class="container">
        <section class="vh-100">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-md-12 col-xl-10">
                        <div class="card mask-custom todo-sec">
                            <div class="card-body p-4 text-white gradient-custom-2">

                                <div class="text-center pt-3 pb-2 top-box">
                                    <img src="{{ asset('assets/img/check.webp') }}"
                                         alt="Check" width="60">
                                    <h2 class="my-4">Task List</h2>
                                    <div class="alert alert-success alert-dismissible fade show my-3 d-none" role="alert">
                                        <strong></strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    <div class="alert alert-danger alert-dismissible fade show my-3 d-none" role="alert">
                                        <strong></strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <button class="btn btn-primary" id="addCategoryBtn" data-bs-toggle="modal" data-bs-target="#createCategoryModal">Add Category</button>
                                    <button class="btn btn-primary ms-2" id="addTaskBtn" data-bs-toggle="modal" data-bs-target="#createTodoModal">Add Task</button>
                                </div>

                                <table class="table text-white mb-0 text-center">
                                    <thead>
                                    <tr>
                                        <th scope="col" width="20%">Title</th>
                                        <th scope="col" width="30%">Description</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- create Task Modal -->
    @include('partials._create_task_modal')

    <!-- create Category Modal -->
    @include('partials._create_task_modal')

@endsection

@push('script')
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
@endpush
