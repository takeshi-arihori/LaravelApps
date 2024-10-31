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


## `php artisan make:model Food --all`実行後のtree

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