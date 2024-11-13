<?php

use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard.home');
})->middleware(['auth', 'verified'])->name('dashboard');
