<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(): View
    {
        // fakerオブジェクトを生成
        $faker = fake();
        // 4から10のランダムな文を生成する
        $chatMessages = $faker->sentences($faker->numberBetween(4, 10));
        // 'welcome'ビューを表示し、生成したチャットメッセージをViewに渡す
        // DBから取得した10件のデータをViewに渡す
        $users = User::orderBy('created_at', 'desc')->take(10)->get();

        return view('welcome', [
            'chatMessages' => $chatMessages,
            'users' => $users
        ]);
    }
}
