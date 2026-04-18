# FashionablyLate

お問い合わせフォームアプリです。
  
ユーザーはお問い合わせを送信でき、管理者はログイン後に管理画面で一覧の確認・検索・削除・CSVエクスポートができます。

---

## 環境構築

1. リポジトリのクローン

```
git clone https://github.com/mayuniwata/contactform.git
cd contactform
```

2. Docker起動

```
docker-compose up -d --build
```

### Laravel環境構築

1. PHPコンテナに入る

```
docker compose exec php bash
```

2. Composerインストール

```
composer install
```

3. .envファイル作成

```
cp .env.example .env
```

4. アプリケーションキー作成

```
php artisan key:generate
```

---

### データベース設定

.envファイルを以下のように編集

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass

APP_LOCALE=ja
```
設定後、以下を実行してください。
```
php artisan config:clear
```
---

### マイグレーション

```
php artisan migrate
```

---

### ダミーデータ作成

```
php artisan migrate:fresh --seed
```

---

## 使用技術
Laravel 8.x
PHP 8.1
MySQL 8.0
nginx 1.21.1
Laravel Fortify
Docker / Docker Compose

---

## URL
トップページ
http://localhost/
管理画面
http://localhost/admin
ログイン
http://localhost/login
会員登録
http://localhost/register
phpMyAdmin
http://localhost:8080/

---

## 認証機能
Laravel Fortifyを使用
ログインユーザーのみ管理画面へアクセス可能
パスワードはハッシュ化して保存#

---

## ダミーデータ
categoriesテーブル

Seederを使用して以下5件を登録しています。

1.商品のお届けについて
2.商品の交換について
3.商品トラブル
4.ショップへのお問い合わせ
5.その他

contactsテーブル

Factoryを使用して35件のダミーデータを作成しています。
```
php artisan tinker
```
```
\App\Models\Contact::factory()->count(35)->create();
```
---

## 主な機能
お問い合わせ機能
入力 → 確認 → 送信
バリデーション（日本語対応）
修正時の入力内容保持

---

## 管理画面
一覧表示
・7件ごとにページネーション

検索機能
・名前（姓・名・フルネーム）
・メールアドレス
・性別
・お問い合わせの種類
・日付

詳細機能
・モーダルで表示

削除機能
・モーダルから削除可能

エクスポート機能
・CSV出力（検索条件反映）

---

## テーブル構成
users
・name
・email
・password
categories
・id
・content
contacts
・id
・category_id
・last_name
・first_name
・gender
・email
・tel
・address
・building
・detail
・created_at
・updated_at

---

## ER図

ER図は以下ファイルを参照してください。

ER.png

---

## 注意事項
・Apple Silicon（M1/M2）環境ではMySQLの警告が出る場合がありますが動作に問題はありません
・.env 設定を正しく行わないとDB接続エラーが発生します
