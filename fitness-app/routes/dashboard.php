<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [DashboardController::class, 'home'])->name('dashboard');

Route::get('/dashboard/food', [DashboardController::class, 'food'])->name('dashboard.food');
