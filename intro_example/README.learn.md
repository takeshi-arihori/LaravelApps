## MVC

### モデル
ドメインロジックを含み、バックエンドで作成するデータ構造やカスタムクラス。  
Laravel は ORM（Eloquent Object Relational Mapping）を提供しており、これはデータベースと自動的にマッピングおよび同期するクラスを作成するために使用。  
モデルは、Laravel のコンテナシステムの重要な部分でもあり、依存性注入によってモデルを利用することができます。

### ビュー
UIロジックを含み、ルートはビューを返すことができます。  
サーバサイドレンダリングによって生成されたレスポンスで、すべてのビューはリソースフォルダ内にあり、Laravel は view() のようなヘルパー関数を提供してビューを処理します。


### コントローラ

ビジネスロジックを含むコントローラはアプリケーションの中心であり、コードへのエントリーポイント。  
ここでは、受信したリクエストデータを処理し、どのようなレスポンスを返すかに関するすべてのアプリケーションロジックを書く。  
コントローラは、リクエストを満たすために必要なモデルを Laravel システムから受け取り、データを検証し、処理または変換し、使用するビューを選択する。

コントローラはビューが使用するデータを準備し、ビューを呼び出して HTML を作成し、最終的にこの HTML コードを HTTP レスポンスを通じてブラウザに転送する。


## サービスコンテナ
### 制御の反転
フレームワークがアプリケーションの流れを管理し、コードを呼び出す。  
内部がどのように動作しているか開発者は知る必要がない。  
フレームワークのルールと提供される機能の入力と出力の関係を理解していれば良い。  

### Laravelのサービスコンテナ
大きな箱のようなもので、この箱の中にクラスを入れることができる。そして、Laravelが実行順序や依存関係を管理する関数(コントローラー関数など)を書くときに、必要なオブジェクトのクラスをタイプヒントするだけで、Laravelが自動的にそのオブジェクトを作成してくれる。  

**例**: `/users/profile/{user}` => `127.0.0.1:8000/users/profile`のようなURLリンクは、user_idが1のユーザーのプロフィールページを返す。

### サービスプロバイダ
カスタムクラスやインターフェースに対して依存性注入を利用する場合に必要。このクラスを使って、サービスコンテナにクラスやインターフェースをバインドする。  

- 常に同じオブジェクトを使用（シングルトン）
- 特定のコントローラのみにオブジェクトを作成
- キーと値のペアを指定してオブジェクトを作成

#### `register`メソッド
HTTPリクエストの最初の段階で呼び出され、全てのサービスプロバイダが一つずつ処理される。このメソッドでは、全てのクラスやインターフェースをサービスコンテナにバインドする。

#### `boot`メソッド
`register`メソッドの後に呼び出される。他のサービスプロバイダによって登録された何かが必要な場合に使用される。