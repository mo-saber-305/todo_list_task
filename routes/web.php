<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes (Login, Register, Password Reset)
Auth::routes();

/*
|--------------------------------------------------------------------------
| Authenticated Dashboard & API Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Dashboard View
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Tasks API Resource & Custom Actions
    Route::apiResource('tasks', TaskController::class);
    Route::post('tasks/reorder', [TaskController::class, 'reorder'])->name('tasks.reorder');
    Route::post('tasks/{id}/restore', [TaskController::class, 'restore'])->name('tasks.restore');
    Route::post('tasks/{id}/complete', [TaskController::class, 'complete'])->name('tasks.complete');

    // Categories API Resource
    Route::apiResource('categories', CategoryController::class);
});
