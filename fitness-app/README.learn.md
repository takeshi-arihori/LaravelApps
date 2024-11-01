## モデル

### Eloquent ORM
モデルの中心に位置するもので、データベースのテーブルの行を、アプリケーション内のOOPクラスのインスタンスにマッピングする。このオブジェクトのインスタンス変数は、それがマップされているテーブルの各列に対応している。  

### 作成方法
- `php artisan make:model{ModelName}`: 指定したモデル名で基本的なEloquentORMクラスが作成される
- `php artisan make:model{ModelName} --all`: モデルだけでなく、そのモデルに関連する他のファイル (コントローラ、ファクトリー、マイグレーション、ポリシー、シーダー) が全て一緒に作成される。  
`--model` `--seed` `--controller`などのオプションを個別に指定することも可能。   

## マイグレーション
データベースのテーブル作成。`{datetime}_create_{model}_table.php`という名前のマイグレーションファイルを自動的に作成してくれる。  
クラス名を自動的にデータベースのテーブル名にマッピングしてくれる。`php artisan make:model --migration`や`--all`オプションを使用してマイグレーションを作成すると、テーブル名は英語の文法ルールに従って、モデル名の複数形になる。　例: `Userモデル` => `usersテーブル`   


### `php artisan make:model Food --all`実行後のtree

```zsh
app
├── Http
│   ├── Controllers
│   │   └── FoodController.php          # Foodモデル用のコントローラ
│   └── Requests
│       ├── StoreFoodRequest.php        # 新しいFoodを保存するためのリクエストクラス
│       └── UpdateFoodRequest.php       # 既存のFoodを更新するためのリクエストクラス
├── Models
│   └── Food.php                        # Foodモデルを表すクラス
├── Policies
│   └── FoodPolicy.php                  # Foodモデルに関連するポリシークラス
database
├── factories
│   └── FoodFactory.php                 # Foodモデルのファクトリクラス
├── migrations
│   └── {datetime}_create_food_table.php  # Foodテーブルを作成するマイグレーション
└── seeders
    └── FoodSeeder.php                  # Foodテーブル用のシーダークラス
```

[利用可能な全ての関数](https://laravel.com/docs/master/migrations#columns)  

### マイグレーションを元に戻す

```zsh
php artisan migrate:rollback
```

### スキーマ作成後に後で変更を加えたい場合

```zsh
php artisan make:migration {migrationName}
```

### `--table`オプションでテーブル名を指定

```zsh
php artisan make:migration {migrationName} --table={table名}
```

## ファクトリ

### マスアサインメント
データベースのテーブルに対応するモデルに対して、一度に複数の属性(カラム)の値をまとめて設定する方法。  
配列やリクエストデータなどのキーと値のペアを使って、モデルの属性を一括で設定することを指す。  

スキーマに一致するキーと値のペアを持つ連想配列を渡すことで簡単にデータを挿入できる。  
`$fillable`変数で制御。(マスアサインメントを使用しないカラムを指定する場合は`$guarded`変数を使用)  
例えば全てのカラムをマスアサインメント可能にしたい場合は、`$guarded`をからの配列に設定する。  

### DBテスト

- 1. 作成するデータのモデルを編集

```zsh
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $guarded = []; // すべてのカラムがマスアサインメント可能
}
```

- 2. DBに反映されるかテスト

```zsh
$apple = App\Models\Food::create([
    'name' => 'Apple',
    'protein' => 0.3,
    'carbs' => 14,
    'grams' => 100,
    'fat' => 0.2,
]);
```
- 3. `php artisan tinker`でテスト

#### 簡単なテスト

```zsh
$randomFood = App\Models\Food::factory()->make();
```
`make()`関数はオブジェクトのインスタンスを作成するだけでデータベースには保存しない。

#### データベースに登録する

```zsh
$randomFood = App\Models\Food::factory()->create();
```

#### モデルコレクションを使用
モデルオブジェクトのリストで、`each()`、`filter()`、`map()`、`reduce()`、`pluck()` などの機能を使ってリストを操作する。

例: `$randomFoodCollection = App\Models\Food::factory()->count(4)->make();` => Foodモデルのファクトリーを使って、4つの食品データ(インスタンス)を作成(DBには保存されない)  
`$randomFoodCollection->map(function(App\Models\Food $food){ return $food->name; });` => map()関数を使って各食品データから`name`プロパティを取り出し、それをリストとして返す。  

- テストが終わったら `php artisan migrate:fresh` でデータベースをリセットして全てのマイグレーションを再実行する。(初期のプロジェクトなど)
- プロトタイピングフェーズを過ぎると、通常は migrate を使ってスキーマを前進させ、migrate:rollback を使ってスキーマを元に戻す。

## シーディング

シードクラスでは、`run()` メソッドを実装し、その中でモデルのテーブルにデータを投入するためのロジックを記述。  
例えば、ファクトリを使って一定数のデータを生成したり、設定ファイルを基にしてマスアサインメントと `create()` メソッドを使って動的にデータを作成することができる。  

`php artisan db:seed {Seeder}`: シードクラスの実行  
例: `php artisan db:seed --class=FoodSeeder`  


### Configファイルの作成
1. `config/models/seeding/food.php` に初期の食品名を設定するためのコンフィグファイルを作成  


2. 作成したコンフィグファイルが正しく設定されているかを `php artisan tinker` で確認  

```zsh
> $factoryCount = config('models.seeding.food.factory_count');
= 100

> sprintf("Factory count is %d", $factoryCount);
= "Factory count is 100"

>
```

**default_listに設定されている食品の名前を取得しリスト表示**  

```zsh
$foodItems = config('models.seeding.food.default_list');
implode('; ', array_map(function($food) { return $food['name']; }, $foodItems));
```

3. FoodSeederシーダを作成

`updateOrCreate()` 関数: 最初の引数に検索条件となるカラムを指定し、その条件に一致するレコードがあればそのレコードを更新し、一致しなければ新しいレコードを作成。  

