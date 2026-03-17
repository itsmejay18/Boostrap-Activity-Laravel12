<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/process-login', [LoginController::class, 'processLogin'])->name('process_login');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/admin/dashboard', DashboardController::class)->name('admin.dashboard');
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UsersController::class)->except('show');
    });
});
