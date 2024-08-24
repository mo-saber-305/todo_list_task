<div class="filter-bar">
    <div class="row g-3 align-items-center">
        <div class="col-12 col-md-5">
            <div class="search-input-group">
                <i class="bi bi-search"></i>
                <input type="text" class="form-control form-control-custom" name="filter_search" id="filterSearch" placeholder="Search tasks by title or description...">
            </div>
        </div>
        <div class="col-6 col-md-3">
            <select name="filter_category" id="filterCategory" class="form-select form-select-custom">
                <option value="" selected>All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6 col-md-2">
            <select name="filter_status" id="filterStatus" class="form-select form-select-custom">
                <option value="" selected>All Statuses</option>
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
            </select>
        </div>
        <div class="col-12 col-md-2 text-md-end text-center">
            <div class="segmented-nav">
                <input type="radio" name="btnradio" value="index" id="btnradio1" autocomplete="off" checked>
                <label for="btnradio1">
                    <i class="bi bi-list-task"></i>
                    <span>All</span>
                </label>

                <input type="radio" name="btnradio" value="trash" id="btnradio2" autocomplete="off">
                <label for="btnradio2">
                    <i class="bi bi-trash3"></i>
                    <span>Trash</span>
                </label>
            </div>
        </div>
    </div>
</div>
