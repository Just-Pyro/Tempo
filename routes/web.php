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
});