@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
@endpush

@section('content')

    <div class="container">
        <section class="main-sec">
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

                                <div class="mb-4 row justify-content-between align-items-center">
                                    <div class="left-box col-lg-8 d-flex align-items-center">
                                        <input type="text" class="form-control me-2 w-100" name="filter_search" id="filterSearch" placeholder="Search.....">
                                        <select name="filter_category" id="filterCategory" class="form-control me-2">
                                            <option value="" selected>Select Category</option>
                                            @foreach(\App\Models\Category::all() as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <select name="filter_status" id="filterStatus" class="form-control">
                                            <option value="" selected>Select Status</option>
                                            <option value="pending">Pending</option>
                                            <option value="completed">Completed</option>
                                        </select>
                                    </div>
                                    <div class="right-box col-lg-4 text-end">
                                        <button class="btn btn-primary custom-btn" id="addCategoryBtn" data-bs-toggle="modal" data-bs-target="#createCategoryModal">Add Category</button>
                                        <button class="btn btn-primary custom-btn ms-2" id="addTaskBtn" data-bs-toggle="modal" data-bs-target="#createTodoModal">Add Task</button>
                                    </div>
                                </div>

                                <div class="text-center mb-4">
                                    <div class="btn-group text-center" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check" name="btnradio" value="index" id="btnradio1" autocomplete="off" checked>
                                        <label class="btn btn-outline-dark" for="btnradio1">All Task</label>

                                        <input type="radio" class="btn-check" name="btnradio" value="trash" id="btnradio2" autocomplete="off">
                                        <label class="btn btn-outline-dark" for="btnradio2">Deleted Task</label>
                                    </div>
                                </div>

                                <table class="table text-white mb-0 text-center">
                                    <thead>
                                    <tr>
                                        <th class="align-middle" scope="col" width="20%">Title</th>
                                        <th class="align-middle" scope="col" width="30%">Description</th>
                                        <th class="align-middle" scope="col">Category</th>
                                        <th class="align-middle" scope="col">Status</th>
                                        <th class="align-middle" scope="col">Date</th>
                                        <th class="align-middle" scope="col">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>

                                <!-- Load More Button -->
                                <div class="text-center mt-3">
                                    <button id="loadMore" class="btn btn-primary custom-btn" style="display: none;">Load More</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
        </section>
    </div>

    <!-- Create Task Modal -->
    @include('partials._create_task_modal')

    <!-- Create Category Modal -->
    @include('partials._create_category_modal')

    <!-- Delete Modal -->
    @include('partials._delete_modal')

    <!-- Restore Modal -->
    @include('partials._restore_modal')
@endsection

@push('script')
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
@endpush
