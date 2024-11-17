<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\FoodType;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller implements HasMiddleware
{
    public function home(Request $request): View
    {
        return view('dashboard.home');
    }

    public function food(Request $request): View
    {
        $tagValidation = function ($attribute, $value, $fail) {
            $tags = array_map('trim', explode(',', $value));
            if (!is_array($tags) || count($tags) === 0 || in_array('', $tags, true)) {
                $fail('The ' . $attribute . ' must be a comma-separated list of valid tags.');
            }
        };

        // リクエストのバリデーション
        $queryParams = $request->validate([
            // nullは不可、文字列であり、最大255文字
            'name' => 'nullable|string|max:255',
            // 省略可能 + string 型であること、existsルールを使ってfood_typesテーブルのnameカラムに存在する値であることを確認
            'food_type' => 'nullable|string|exists:food_types,name',
            // 省略可能 + カンマ区切りのタグとして文字列を受け付ける
            'tags' => [$tagValidation],
        ]);

        $query = Food::query();


        // 名前検索
        if (!empty($queryParams['name'])) {
            $query->where('name', 'like', '%' . $queryParams['name'] . '%');
        }

        // 食べ物の種類でフィルタリング
        if (!empty($queryParams['food_type'])) {
            $query->whereHas('foodType', function ($q) use ($queryParams) {
                $q->where('name', $queryParams['food_type']);
            });
        }

        // タグ検索
        if (!empty($queryParams['tags'])) {
            $tags = array_map('trim', explode(',', $queryParams['tags']));
            foreach ($tags as $tag) {
                $query->whereHas('Foodtags', function ($q) use ($tag) {
                    $q->where('name', $tag);
                });
            }
        }

        $foodItems = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

        return view('dashboard.food', [
            'foodTypes' => FoodType::all(),
            'food' => $foodItems,
        ]);
    }

    public static function middleware(): array
    {
        return [
            'auth',
            'verified'
        ];
    }
}
