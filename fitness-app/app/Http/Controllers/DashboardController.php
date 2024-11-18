<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\FoodType;
use App\View\Components\Dashboard\FoodCards; // 新しいFoodCardsコンポーネントをインポート
use Illuminate\Database\Eloquent\Builder; // クエリビルダーの型指定を行うためにインポート
use Illuminate\Http\JsonResponse; // JSONレスポンスの型指定を行うためにインポート
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
        // リクエストのバリデーション
        $queryParams = $request->validate([
            // nullは不可、文字列であり、最大255文字
            'name' => 'nullable|string|max:255',
            // 省略可能 + string 型であること、existsルールを使ってfood_typesテーブルのnameカラムに存在する値であることを確認
            'food_type' => 'nullable|string|exists:food_types,name',
            // 省略可能 + カンマ区切りのタグとして文字列を受け付ける
            'tags' => 'nullable|string',
        ]);

        $query = $this->foodSearchQuery($queryParams);

        return view('dashboard.food', [
            'foodTypes' => FoodType::all(),
            'food' => $query->orderByDesc('created_at')->paginate(10)->withQueryString(),
        ]);
    }

    public function foodSearch(Request $request): JsonResponse
    {
        // リクエストデータを検証
        $queryParams = $request->validate([
            'name' => 'nullable|string|max:255',
            'food_type' => 'nullable|string|exists:food_types,name',
            'tags' => 'nullable|string',
        ]);

        // 検索クエリを実行
        $query = $this->foodSearchQuery($queryParams);

        // ページネーションとGETリンクを使用してデータを取得
        $foodPaginator = $query->orderByDesc('created_at')->paginate(perPage: 10)->withPath(route('dashboard.food'));

        // FoodCardsコンポーネントをインスタンス化し、ビューを生成
        $foodCardsComponent = new FoodCards($foodPaginator);
        $content = $foodCardsComponent->render()->with($foodCardsComponent->data())->render();

        return response()->json([
            'food' => $foodPaginator->items(), // 食品データをJSONとして返す
            'content' => $content, // ビューの内容もJSONとして返す
        ]);
    }

    private function foodSearchQuery(array $data): Builder
    {
        $query = Food::query();

        // 名前フィルタが指定されている場合
        if (!empty($data['name'])) {
            $query->where('name', 'like', '%' . $data['name'] . '%');
        }

        // フードタイプが指定されている場合
        if (!empty($data['food_type'])) {
            $query->whereHas('foodType', function ($q) use ($data) {
                $q->where('name', $data['food_type']);
            });
        }

        // タグが指定されている場合
        if (!empty($data['tags'])) {
            $tags = array_map('trim', explode(',', $data['tags'])); // タグを配列に変換
            foreach ($tags as $tag) {
                $query->whereHas('foodTags', function ($q) use ($tag) {
                    $q->where('name', $tag);
                });
            }
        }

        return $query; // フィルタリングされたクエリを返す
    }

    public static function middleware(): array
    {
        return [
            'auth',
            'verified'
        ];
    }
}
