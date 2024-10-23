# RecursionCSカリキュラム Laravelプロジェクト

## 開発環境
- VirtualBox 7.0
- Ubuntu 24.04
- Laravel11
- PHP 8.3
- MySQL 8.0

## Laravelをインストールするために必要な設定
- PHP(最低8.2以上)
- PHP拡張
- Composer
- Node.js
- npm
- MySQL

## Laravel の Install に必要なもの
### 全てのPHP拡張を一度にインストール
```
sudo apt update && sudo apt upgrade -y
sudo add-apt-repository ppa:ondrej/php
sudo apt update
sudo apt-get install -y php php-cli php-common php-fpm php-mysql php-zip php-gd php-mbstring php-curl php-xml php-bcmath openssl php-json php-tokenizer
```

#### 上記のコマンドでインストールされる
```
php：最新の PHP バージョン。
php-cli：PHP コマンドラインインターフェース。
php-common：PHP の共通ファイル。
php-fpm：PHP FastCGI プロセスマネージャー。サーバが効率的にリソースを使用するために使用されます。
php-mysql：PHP の MySQL データベースサポート。
php-zip：PHP の ZIP アーカイブサポート。
php-gd：PHP の画像処理拡張、GD ライブラリ。
php-mbstring：PHP のマルチバイト文字列サポート。
php-curl：PHP の cURL 拡張。
php-xml：PHP の XML サポート。
php-bcmath：PHP の任意精度の数学関数をサポート。
openssl：PHP で使用される多くの暗号化アルゴリズムを含む OpenSSL ライブラリ。
php-json：PHP の JSON サポート。
php-tokenizer：コードを解析するために使用される PHP のトークナイザーサポート。
```

#### インストールの確認
- `php -v`: PHPの最新バージョンをチェック
- `php -m`: PHPが読みこむ拡張機能のリストを表示 


### Composerのインストール
```
sudo apt-get intall composer
```

#### インストールの確認
- `composer --version`: composerのバージョンをチェック

### MySQLインストール
#### 手順
- **Step1: MySQL 8 をインストールし、サービスを開始**
```
sudo apt install mysql-server
sudo service mysql start
```

- **Step2: MySQL のルートユーザーにパスワードを設定し、認証方式を設定**
```
sudo mysql
mysql> ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'password';
mysql> exit
```

- **Step3: ルートユーザーで再度 MySQL にログインし、auth_socket 認証を設定**
```
sudo mysql -u root -p
mysql> ALTER USER 'root'@'localhost' IDENTIFIED WITH auth_socket;
mysql> exit
```

- **Step 4: MySQL をセキュリティで保護**
```
sudo mysql_secure_installation
```

#### Laravelプロジェクトのユーザー作成
- **Step1: MySQL にルートユーザーでログイン**
```
mysql -u root -p
```

- **Step 2: Laravel 用のユーザーを作成し、権限を付与**
```
mysql> CREATE USER 'laravel'@'localhost' IDENTIFIED WITH mysql_native_password BY 'password';
mysql> GRANT CREATE, ALTER, DROP, INSERT, UPDATE, INDEX, DELETE, SELECT, REFERENCES, RELOAD on *.* TO 'laravel'@'localhost' WITH GRANT OPTION;
mysql> FLUSH PRIVILEGES;
mysql> exit;
```

### Node.jsとnpm
Node Version Manager(NVM)を使用

- **Step1: cURL をインストール**
```
sudo apt install curl
```

- **Step2: NVMをインストールして、使用できるようにする**
```
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash
export NVM_DIR="$([ -z "${XDG_CONFIG_HOME-}" ] && printf %s "${HOME}/.nvm" || printf %s "${XDG_CONFIG_HOME}/nvm")" [ -s "$NVM_DIR/nvm.sh" ] && \\. "$NVM_DIR/nvm.sh"
```
※ Node.jsとnpmが最新の安定版でない場合、`sudo apt purge nodejs npm` を実行して削除しておく  
※ NVMのインストールチェック: `nvm -v`  
※ Node.jsのインストールチェック: `node -v`  
※ npmのインストールチェック: `npm -v`  

## Laravelプロジェクトの開始
- **Step1: Composerを使用してLaravelをグローバルにインストール**
```
composer global require laravel/installer
```

- **Step2: ComposerのbinディレクトリをシステムのPATHに追加**
Composerがインストールされているディレクトリを確認  
```
composer global config bin-dir --absolute
```

パスをシステムのPATHに追加  
```
echo 'export PATH="$PATH:$HOME/.config/composer/vendor/bin"' >> ~/.bashrc
exec bash
laravel --version
```

- **Step3: セットアップ**
```
laravel <Laravel Project名>
```
以下のプロンプトが表示されるので設定していく  
```
Starter Kit: Laravel Breeze
Breeze Stack: Blade with Alpine
Dark Mode Support: No
Testing Framework: PHPUnit
Initialize a git repo: No
Database application will use: MySQL
Default database updated, run default database migration?: No
```

- **Step4: セットアップ**
.envを設定  
```
DB_CONNECTION=mysql            # The database connection type
DB_HOST=127.0.0.1              # The database host
DB_PORT=3306                   # The database port
DB_DATABASE=<データベース名を設定>      # The database name
DB_USERNAME=<設定したUsername>            # The database username
DB_PASSWORD=<設定したPassword>         # The database password
```

MySQLでデータベースを作成  
```
sudo mysql -u root -p
CREATE DATABASE <上記の`.env`設定したDatabase名> CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### MySQLログイン情報

- username: laravel
- password: password123

### 開発時のコマンド
- `php artisan serve`: Laravelの開発サーバを起動
- `npm run dev`: フロントエンドのアセットをコンパイル

## コミットルール
- [僕が考える最強のコミットメッセージの書き方](https://qiita.com/konatsu_p/items/dfe199ebe3a7d2010b3e)
