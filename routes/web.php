<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Authentication (Guest Only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Protected Routes (Requires Login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::redirect('/', '/dashboard');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Repairs Management
    Route::resource('repairs', RepairController::class);

    // Customers Management
    Route::resource('customers', CustomerController::class);

    // Reports & Analytics
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // Admin Only: Users & Technicians Management
    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class);
    });
});
