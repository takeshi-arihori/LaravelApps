# コントローラー、リクエスト、認証、CRUD機能

## コントローラー

### tailwindCSSの設定にクラスを追加する
Tailwind CSS は Tree shaking(不要なコードの除去) を行うため、デフォルトで Blade 以外のクラスはビルドされない。  
追加したい場合は、以下のように `safelist` を設定する。

```zsh
    safelist: [
        {
            pattern: /^bg-/,
        },
        {
            pattern: /^text-/,
        },
    ],
```

### ミドルウェアの役割
`->middleware`関数: HTTPリクエストデータをエントリールートに渡す前に順次実行され、ルートがレスポンスを返した後に逆順で実行されるプロセス。  

### `web.php`ルートファイルでデフォルトで実行されるミドルウェア
```zsh
Illuminate\Cookie\Middleware\EncryptCookies // クッキーを暗号化します。
Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse // キューに追加されたクッキーをレスポンスに追加します。
Illuminate\Session\Middleware\StartSession // セッションを開始します。
Illuminate\View\Middleware\ShareErrorsFromSession // セッションからのエラーメッセージをビューと共有します。
Illuminate\Foundation\Http\Middleware\ValidateCsrfToken // CSRFトークンを検証します。
Illuminate\Routing\Middleware\SubstituteBindings // ルートモデルのバインディングを処理します。
```

### `api`ミドルウェアグループ
`Illuminate\Routing\Middleware\SubstituteBindings` ミドルウェアのみを実行  
`api` グループを使用するには、専用のルートファイルを作成し、これらのルートがシンプルな `api` グループのみを使用するように設定する必要がある。  

### Laravelアプリケーションの2種類のルート処理方法
- Web ルート：通常のウェブサイト用のルート処理で、クッキーやセッション管理が含まれる。
- API ルート：モバイルアプリや外部システムと通信するための「APIエンドポイント」を提供するための軽量なルート処理。

### ミドルウェアの用途
- セッション管理: セッションの開始や維持を行います。
- クッキー管理: クッキーの暗号化やレスポンスへの追加を処理します。
- CSRF トークンの検証: フォーム提出時の CSRF 攻撃を防止します。
- ビューへのデータの準備: ビューで使用するデータを準備します。
- リクエストの解析: 例えば、JSON リクエストの解析などを行います。  
  
**※ 認証と認可、ログ記録、データ変換、レート制限、ローカリゼーションなど、アプリケーションのさまざまな重要なタスクも実行**  

- `auth`ミドルウェア: ユーザーがログインしているかどうかを確認。ログインしていない場合はリクエストをルートに到達させず、ログインページにリダイレクト
- `verified`ミドルウェア: ユーザーがメールアドレスを確認していることを確認し、確認されていない場合はアクセスを制限する  
- `guest`ミドルウェア: ログインしていないユーザーのみがアクセスできるルートを定義する

#### routeにミドルウェアを設定する例:
```zsh
Route::get('/dashboard/food', [DashboardController::class, 'food'])->middleware(['auth', 'verified'])->name('dashboard.food');
```

#### コントローラーにミドルウェアを設定する例：
同じミドルウェアをコントローラ内の複数のメソッドに適用する場合、`middleware`メソッドを使用して、コントローラのクラスにミドルウェアを設定できる。  

```zsh
public static function middleware(): array {
    return [
        'auth',  // ログイン済みユーザーのみアクセス可能
        'verified',  // メール認証済みユーザーのみアクセス可能
    ];
}
```
**※ メソッドごとに適用するミドルウェアをカスタマイズ**
```zsh
public static function middleware(): array {
    return [
        'auth',
        new Middleware('log', only: ['index']),  // index メソッドにのみ適用
        new Middleware('subscribed', except: ['store']),  // store メソッド以外に適用
    ];
}
```

## バリデーション

