<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\FoodType;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function home(Request $request): View
    {
        return view('dashboard.home');
    }

    public function food(Request $request): View
    {
        $queryParams = $request->toArray();
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
                $query->whereHas('tags', function ($q) use ($tag) {
                    $q->where('name', $tag);
                });
            }
        }

        $foodItems = $query->orderByDesc('created_at')->paginate(10);

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
