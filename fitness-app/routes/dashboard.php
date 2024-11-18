<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FoodController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [DashboardController::class, 'home'])->name('dashboard');
Route::get('/dashboard/food', [DashboardController::class, 'food'])->name('dashboard.food');
Route::post('/api/food/search', [DashboardController::class, 'foodSearch'])->name('api.food.search');

// FoodControllerをリソースコントローラーとして登録
Route::resource('dashboard/entries/food', FoodController::class);
