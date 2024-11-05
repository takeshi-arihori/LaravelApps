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

## データ

### データの更新
例: `id`が90のFoodオブジェクトを取得しデータを変更  
1. `update()`を使用

```zsh
$food = App\Models\Food::find(90);
$food->update([
    'name' => 'Orange',
    'grams' => 100,
    'protein' => 1,
    'carbs' => 12,
    'fat' => 0.2
]);
```

2. `save()`を使用
```
$food = App\Models\Food::find(80);
$food->name = 'Shrimp';
$food->grams = 100;
$food->protein = 24;
$food->carbs = 0;
$food->fat = 0.3;
$food->save();
```

#### Eloquent ORMのマジックメソッドについて
`__get()` `__set()`というマジックメソッドを使用して、クラス定義内で明示的に指定せずにインスタンス変数を割り当てたり取得したりする。  
例: `$food->name` => nameというデータベースのカラムを探し、その値を取得する。


#### Modelクラスの拡張
以下のような独自のメソッドを追加することも可能  

```zsh
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $guarded = [];

    // カロリー計算メソッドの追加
    public function getTotalCalories(): float
    {
        return ($this->protein * 4) + ($this->carbs * 4) + ($this->fat * 9);
    }
}
```

Tinkerで実行  

```zsh
$orange = App\Models\Food::find(90);
$orange->getTotalCalories();
```


### データの削除

#### データベースから行全体を完全に削除  

```zsh
$food = App\Models\Food::find(70);
$food->delete();
```


#### ソフトデリート
行を削除する代わりに、deleted_atというカラムに削除された日時を記録。行が削除されたことを示すが、DBには残る。

1. Modelsクラスに `use SoftDeletes;` を追記
2. マイグレーションを作成 `php artisan make:migration update_food_table_soft_delete --table=food`
3. マイグレーションファイルを編集

```zsh
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * マイグレーションを実行します。
     */
    public function up(): void
    {
        Schema::table('food', function (Blueprint $table) {
            $table->softDeletes();  // `deleted_at`カラムを追加
        });
    }

    /**
     * マイグレーションを元に戻します。
     */
    public function down(): void
    {
        Schema::table('food', function (Blueprint $table) {
            $table->dropSoftDeletes();  // `deleted_at`カラムを削除
        });
    }
};

```

4. `php artisan migrate` を実行し、deleted_atカラムをデータベースに追加

**id が 60 の Food 項目をソフトデリート**  
```zsh
$food = App\Models\Food::find(60);
$food->delete();
```

**ソフトデリートされた行を取得**  

```zsh
$food = App\Models\Food::withTrashed()->where('id', 60)->first();
$food->trashed(); // trueが返される
$food->restore(); // データを復元
$food->trashed(); // falseが返される

$food = App\Models\Food::find(60);
```

## クエリ


### 練習問題

1. たんぱく質含有量が 20 グラム以上の食品をすべて取得  

```zsh
$foodList = App\Models\Food::where('protein', '>', 20)->get();
```
2. 繊維含有量が 3 グラムから 8 グラムの範囲にある食品を3件取得  

```zsh
$foodList = App\Models\Food::where('protein', '>', 20)->get();
```
3. 炭水化物含有量が少ない順に並べたトップ 5 の食品を取得  
4. グラム数が 50 未満でたんぱく質含有量が 10 グラム以上の食品を created_at のタイムスタンプで並べ替えて取得  
5. 炭水化物、たんぱく質、脂肪の合計が 30 グラムから 50 グラムの範囲にある食品を、updated_at のタイムスタンプで降順に並べ替えて取得  

## 一対多の関係

### FoodモデルとFoodTypeモデルの関係

```zsh
php artisan make:model FoodType --all
```
主キーは`name`に設定、マイグレーションファイルは`primary()`関数を使って設定。  
クラスに `$primaryKey` `$incrementing` `$keyType` 変数を更新  

#### FoodType
```zsh 
# FoodTypeクラスに追加
    use HasFactory;

    // 主キーを`name`に設定
    protected $primaryKey = 'name';
    public $incrementing = false;  // 自動インクリメントを無効化
    protected $keyType = 'string'; // キーのデータ型を`string`に設定
    protected $guarded = [];  // 全カラムのマスアサインメントを許可
```

#### database/migrations/{DATE}_created_food_type_table.php
```zsh
# マイグレーションに追加
    $table->string('name')->primary();  // `name`を主キーとして設定
    $table->string('description');  // `description`カラムを追加
```

#### database/seeder/FoodTypeSeeder.php
```zsh
    $seedConfig = config('models.seeding.food-types');
    $foodTypes = $seedConfig['default_list'];

    foreach($foodTypes as $foodType) {
        FoodType::updateOrCreate(
            [
                'name' => $foodType['name'],
                'description' => $foodType['description'],
            ],
        );
    }
```

#### config/models/seeding/food-types.php
defaultのリストを作成

#### FoodTypeテーブルにデータをシード
```zsh
php artisan migrate
php artisan db:seed --class=FoodTypeSeeder
```

#### tinkerで確認
```zsh
$vegetableType = App\Models\FoodType::find('Vegetables');
$foodTypes = App\Models\FoodType::all();
```

### Food に対して FoodType の関連付け
Foodクラスでは、関係を返す関数を定義することで、Laravel に対して Food クラスが他のモデルに属していることを知らせることができる。  
「一対多」の関係: `belongsTo({Model}::class)`  
Food モデルのクラスには、外部キーのカラム名として {method_name}_{foreign_column_name} という形式の名前が必要  


### 関連付け
- Food クラス内のメソッド名: `foodType()`
- FoodType の主キー: `name`  
- food テーブル: `food_type_name` という外部キーのカラム

#### 新しいマイグレーションを作成し、foodテーブルに `food_type_name` カラムを追加
```zsh
php artisan make:migration update_food_associate_food_type --table=food
```

#### マイグレーションファイルに追加
```zsh
    /**
     * マイグレーションを実行します。
     */
    public function up(): void
    {
        Schema::table('food', function (Blueprint $table) {
            // foodテーブルにfood_type_nameという名前の新しいカラムを追加します。
            // このカラムは文字列型（string）で、nullを許可しています。
            $table->string('food_type_name')->nullable();

            // 先ほど追加したfood_type_nameカラムを外部キーとして設定します。
            // 具体的には、このカラムはfood_typesテーブルのnameカラムを参照します。
            // food_typesテーブルで関連する行が削除されたときに、自動的にfoodテーブルの対応する行も削除されます。
            // たとえば、Fruitsという名前のFoodTypeが削除された場合、それに関連するすべての食品（例えばオレンジやバナナなど）も自動的に削除されます。
            $table->foreign('food_type_name')->references('name')->on('food_types')->onDelete('cascade');
        });
    }

    /**
     * マイグレーションを元に戻します。
     */
    public function down(): void
    {
        Schema::table('food', function (Blueprint $table) {
            $table->dropForeign(['food_type_name']);
            $table->dropColumn('food_type_name');
        });
    }
```

#### Foodモデルに関係を定義
FoodモデルがFoodTypeモデルに属していることを示すために、Foodモデル内で`foodType()`メソッドを定義  

```zsh
class Food extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    // FoodTypeとの関係を定義
    public function foodType(): BelongsTo{
        // このメソッドは、FoodモデルがFoodTypeモデルに属していることを示します。
        // 'food_type_name'は、Foodテーブル内でFoodTypeモデルの主キーを参照する外部キーです。
        // 'name'は、FoodTypeモデルの主キーのカラム名です。
        // 通常、主キーは'id'ですが、ここでは'name'を主キーとして使っています。
        return $this->belongsTo(FoodType::class, 'food_type_name', 'name');
    }

    public function getTotalCalories(): float
    {
        return ($this->protein * 4) + ($this->carbs * 4) + ($this->fat * 9);
    }
}
```

#### マイグレーションの実行

```zsh
php artisan migrate
```

#### tinkerで関連付けのテスト

データベースに実際に保存するためモデルインスタンス間の関係を設定した後、その変更をデータベースに保存する必要がある。  

```zsh
$orange = App\Models\Food::find(90); // idが90の食品を取得
$fruitType = App\Models\FoodType::find("Fruits"); // "Fruits"という名前のFoodTypeを取得
$orange->foodType()->associate($fruitType); // リレーションシップを設定
$orange->save(); // データベースに保存
```

### FoodTypeモデルからそのタイプに関連づけられている全てのFood項目を取得

`hasMany()`を使用  

#### tinkerでテスト
```zsh
$fruitType = App\Models\FoodType::find("Fruits");
$foods = $fruitType->food; // "Fruits"に属するすべてのFoodを取得
```

#### Modelに追加

```zsh
    // Foodとの関係を定義
    public function food(): HasMany
    {
        // このFoodTypeモデルに関連する複数のFoodモデルを取得する関係を定義します。
        // 'food_type_name'は、Foodモデル側の外部キーです。
        // 'name'は、FoodTypeモデル側の主キーです。
        return $this->hasMany(Food::class, 'food_type_name', 'name');
    }
```

#### tinkerで操作
```zsh
$banana = App\Models\Food::where('name','Banana')->first(); // "Banana"という名前の食品を取得
$fruitType = App\Models\FoodType::find("Fruits"); // "Fruits"という名前のFoodTypeを取得

$banana->foodType()->associate($fruitType); // "Banana"に"Fruits"を関連付け
$banana->save(); // 保存

$fruitType->food; // "Fruits"に関連付けられたすべての食品を取得
$caloriesList = $fruitType->food->reduce(fn(string $carry, App\Models\Food $food) => $carry . sprintf("%s: %d calories\n", $food->name, $food->getTotalCalories()), ''); // カロリーのリストを作成

$fruitType->food()->orderBy('carbs', 'desc')->limit(10)->get(); // 炭水化物が多い順に並べ替えたトップ10の食品を取得
```

#### 関係の解除
```zsh
$orange = App\Models\Food::find(90); // idが90の食品を取得
$orange->foodType()->disassociate(); // リレーションシップを解除
$orange->save(); // 保存
```

- 関係の所有者: `hasOne` `hasMany`
- 他のモデルに所有されている逆方向の関係: `belongsTo` `belongsToMany`

#### 特定のFoodTypeに属する新しいFoodを簡単に作成できる

```zsh
$foodType = App\Models\FoodType::find("Baked Goods");
$foodType->food()->updateOrCreate([
    'name' => 'Chocolate Chip Cookie'
], [
    'grams' => 50,
    'protein' => 2.5,
    'carbs' => 30.6,
    'fat' => 10.5
]);
```
