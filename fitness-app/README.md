# Fitness App

## ER図

<p align="center">
  <img src="https://github.com/user-attachments/assets/c19b056a-64b8-40d9-b694-06a4aa7e55b9" width="600" height="600" alt="FitnessApplication ER Diagram">
</p>

## 要件定義

ユーザーが自分の体重やカロリー摂取を記録できるフィットネストラッカーアプリケーション。ユーザーが体重に関するフィットネス目標を達成できるようにサポートすることを目的としています。

### 食品管理機能

- 新しい食品項目の作成
  - 名前、カロリー、マクロ栄養素情報の登録
- 既存の食品項目の更新
- 食品項目の検索機能
- 食品記録の削除

### 日誌管理機能

- 日誌記録の取得（全件・日付指定）
- 日誌内の食品項目の更新
- 日誌内の食品項目の削除
- 日々のカロリー摂取量の追跡

### APIエンドポイント
**ユーザー関連**  

```
GET /users/profile : ログイン中のユーザーのプロフィール情報取得
PUT /users/profile : ログイン中のユーザーのプロフィール詳細更新
```

**食品関連**  

```
GET /food/create : 新規食品項目作成フォーム表示
POST /food/create : 新規食品項目の作成
GET /food/update : 既存食品項目更新フォーム表示
PUT /food/update : 既存食品項目の更新
GET /food/search : 食品項目検索（ページ表示）
POST /api/food/search : 食品項目検索（JSON応答）
DELETE /food/{food} : 特定食品記録の削除
```

**日誌関連**  

```
GET /diary : 日誌記録の取得
PUT /diary/{diaryEntry}/food-item/update/{diaryFoodItem} : 日誌内食品項目の更新
DELETE /diary/{diaryEntry}/food-item/delete/{diaryFoodItem} : 日誌内食品項目の削除
```

### データベース要件

MySQLの使用
文字コード：utf8mb4
照合順序：utf8mb4_unicode_ci

### モデル
データベースモデル構成
```
User（ユーザー）
WeightEntry（体重記録）
DiaryEntry（日誌記録）
DiaryFoodItem（日誌内の食品項目）
Food（食品）
FoodType（食品タイプ）
FoodTag（食品タグ）
```

## 開発環境セットアップ(mac, zsh)

**Composerインストール**  
```zsh
brew install composer
```

**LaravelインストーラーをComposerでグローバルインストール**  
```zsh
composer global require laravel/installer
```

**Composerのパスを`.zshrc`に書き込む**
```zsh
echo 'export PATH="$PATH:$HOME/.composer/vendor/bin"' >> ~/.zshrc
source ~/.zshrc
```

**`Composer`の`bin`ディレクトリのパスを確認**
```zsh
composer global config bin-dir --absolute
```

**プロジェクト作成**  

```zsh
laravel new fitness-app
```

**プロジェクト設定**  

- Starter Kit: Laravel Breeze
- Breeze Stack: Blade with Alpine
- Dark Mode Support: No
- Testing Framework: PHPUnit
- Database: MySQL


**データベース作成**  

```sql
CREATE DATABASE fitness_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**環境設定（`.env`）**  

```zsh
APP_NAME=MyFitnessTracker
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fitness_app
DB_USERNAME=laravel
DB_PASSWORD="password"
```

**マイグレーション実行**  

```zsh
php artisan migrate
```

