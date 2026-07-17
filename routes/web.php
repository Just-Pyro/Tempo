<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [HomeController::class, 'index'])->name('login');
Route::get('/register', [HomeController::class, 'register'])->name('register');

Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
Route::post('/user/login', [HomeController::class, 'login'])->name('user.login');

Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard', [TaskController::class, 'index'])->name('dashboard');
    
    Route::post('/logout', [HomeController::class, 'logout'])->name('logout');

    Route::get('/tasks', [TaskController::class, 'tasks'])->name('tasks');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks/store', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/edit/{id}', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/update/{id}', [TaskController::class, 'update'])->name('tasks.update');

    Route::post('/tasks/archive', [TaskController::class, 'archiveTask'])->name('tasks.archive');
    Route::get('/tasks/archive/list', [TaskController::class, 'archiveTable'])->name('tasks.archive.list');

    Route::get('/getTasks', [TaskController::class, 'dataTable'])->name('tasks.datatable');
});