@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
@endpush

@section('content')
<div class="container-fluid px-3 px-md-4 px-lg-5 py-2">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="dashboard-card">
                @include('partials._header')
                @include('partials._alerts')
                @include('partials._filter_bar')
                @include('partials._task_table')
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
@include('partials._create_task_modal')
@include('partials._create_category_modal')
@include('partials._delete_modal')
@include('partials._restore_modal')
@endsection

@push('script')
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
@endpush
