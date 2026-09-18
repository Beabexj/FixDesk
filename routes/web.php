<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Customers Management
Route::resource('customers', CustomerController::class);

// Repairs Management
Route::resource('repairs', RepairController::class);

// Users / Technicians Management
Route::resource('users', UserController::class);

// Reports & Analytics
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
