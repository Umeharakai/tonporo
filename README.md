# シンプルフォームアプリケーション

このプロジェクトは、ユーザーがフォームからテキストを送信し、MySQLデータベースに保存し、そのデータを表示するシンプルなWebアプリケーションです。PHPスクリプトがフォームの送信処理を行い、データベースと連携してデータの取得と表示を行います。基本的なセキュリティ対策としてCSRF保護も実装しています。

## ファイル

- **ファイル:** `home.php`
  - **説明:** フォーム送信を処理し、MySQLデータベースと連携してデータの保存と取得を行うPHPスクリプトです。HTMLもこのファイル内に含まれており、データの表示も行います。

- **ファイル:** `styles.css`
  - **説明:** フォームおよび表示される内容のスタイルを指定するCSSファイルです。

## 必要な環境

- PHP 7.4以上
- MySQL 5.7以上
- Webサーバー（例: Apache, Nginx）
- PHPが動作するWebサーバーまたはローカル開発環境（例: XAMPP, MAMP）

## セットアップ手順

1. **データベースの設定:**

   MySQLで `kyototech` という名前のデータベースを作成し、以下のSQLコマンドで `hogehoge` テーブルを作成します。

   ```sql
   CREATE TABLE hogehoge (
       id INT AUTO_INCREMENT PRIMARY KEY,
       text TEXT NOT NULL,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );
