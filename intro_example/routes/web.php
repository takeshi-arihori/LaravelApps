<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', function () {
    $faker = fake();
    return view('dashboard', [
        'welcomeMessages' => $faker->paragraphs(5),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get("/about", function () {
    return view('about-us/about-us');
});

// このルートは、/users/profile/{user}のURLパターンに一致するGETリクエストを処理します。
// 例えば、/users/profile/1というURLがアクセスされた場合、このルートが呼び出されます。
// {user}はURLのプレースホルダーです。この部分にはユーザーIDが入ります。
// 例えば、/users/profile/1の場合、{user}には"1"が入ります。

// LaravelはURLの{user}部分を解析し、それを使って対応するUserモデルのインスタンスをデータベースから取得します。
// 例えば、URLが/users/profile/1の場合、データベースからidが1のユーザーを探し出し、そのユーザーの情報を持つUserインスタンスを作成します。

// Userクラスのタイプヒント（User $user）を使うことで、Laravelは適切なUserインスタンスを関数に注入します。
// タイプヒントとは、関数の引数の前にクラス名を書くことで、そのクラスのインスタンスを要求することです。
Route::get('/users/profile/{user}', function (User $user) {
    return view('user-profile', [
        'userInfo' => [
            'username' => $user->username,
            'profileImageLink' => Storage::url($user->profile_path),
            'description' => $user->description,
        ]
    ]);
});
