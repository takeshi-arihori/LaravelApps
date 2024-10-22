## DBのデータを直接操作したり確認

### IDが1のUserテーブルのユーザー情報を表示
```
php artisan tinker
$user = User::find(1)
$user->name
$user->email
```

## データベースマイグレーションのリセット手順
- database/migrations/{変更するマイグレーションファイル} を変更
- `php artisan migrate:fresh`を実行しデータベース内の全てのデータを削除し、全てのマイグレーションを再実行
- ``