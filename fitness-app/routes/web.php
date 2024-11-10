<?php

use App\Http\Controllers\ProfileController;
use App\Models\Food;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('front.home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get("/food", function () {
    return view('front.food', [
        // 'foodItems' => Food::query()->orderByDesc('created_at')->limit(10)->get()
        'foodItems' => Food::query()->orderByDesc('created_at')->paginate(10)
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
