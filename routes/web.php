<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // fakerオブジェクトを生成
    $faker = fake();
    // 4から10のランダムな文を生成する
    $chatMessages = $faker->sentences($faker->numberBetween(4, 10));
    // 'welcome'ビューを表示し、生成したチャットメッセージをビューに渡す
    return view('welcome', ['chatMessages' => $chatMessages]);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
