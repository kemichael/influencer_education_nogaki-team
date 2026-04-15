# 詳細設計書ベース実装計画

## 対象設計書

- `/Users/inamurakaito/Downloads/詳細設計書_ユーザー_進捗_稲村.pdf`
- `/Users/inamurakaito/Downloads/詳細設計書_ユーザー_お知らせ_稲村.pdf`
- `/Users/inamurakaito/Downloads/詳細設計書_ユーザー_プロフィール設定_稲村.pdf`
- `/Users/inamurakaito/Downloads/詳細設計書_管理_お知らせ一覧_稲村.pdf`
- `/Users/inamurakaito/Downloads/詳細設計書_管理_お知らせ変更_稲村.pdf`

## 1. 設計書から見えた実装対象

### ユーザー側

| 画面 | 主な要件 | 関連テーブル |
| --- | --- | --- |
| ユーザー進捗 | ログインユーザーの学年ごとの授業一覧を表示し、受講済みには `受講済み` を表示する | `users`, `classes`, `curriculums`, `curriculum_progress` |
| ユーザーお知らせ詳細 | 投稿日時、タイトル、本文を表示し、戻るでユーザーTOPへ戻る | `articles` |
| プロフィール設定 | 画像、ユーザー名、カナ、メールアドレス変更。別導線でパスワード変更 | `users` |
| パスワード変更 | 旧パスワード確認、新パスワード更新、確認入力 | `users` |

### 管理側

| 画面 | 主な要件 | 関連テーブル |
| --- | --- | --- |
| お知らせ一覧 | 投稿日時とタイトルの一覧表示、新規登録、変更、削除 | `articles` |
| お知らせ変更 | 既存お知らせの編集、入力チェック、更新後に一覧へ戻る | `articles` |
| お知らせ新規登録 | 投稿日、タイトル、本文の登録、登録後に一覧へ戻る | `articles` |

## 2. 現在のコードベースとの差分

### 実装済みに近いもの

- Laravel の認証基盤は存在する
- `classes`, `curriculums`, `articles`, `users` 拡張マイグレーションは一部存在する
- `/progress` ルートと `ProgressController` は存在する

### これから実装が必要なもの

- ユーザーお知らせ詳細のルート、Controller、View
- プロフィール設定画面、更新処理、画像アップロード
- パスワード変更画面、更新処理
- 管理側のお知らせ一覧、作成、編集、削除
- ユーザーTOP と管理TOP の画面導線
- 各画面のバリデーションメッセージ
- Feature test

### 先に直したい技術的な不足

| 対象 | 現状 | 設計書ベースで必要な状態 |
| --- | --- | --- |
| `curriculum_progress` | `id`, `timestamps` のみ | 少なくとも `user_id`, `curriculum_id`, `clear_flg` が必要 |
| `App\Models\User` | `fillable` が最小構成 | `name_kana`, `profile_image`, `grade_id` を扱える状態にする |
| `App\Models\CurriculumProgress` | `belongsTo(User::class, '&user_id')` になっている | `user_id` に修正する |
| `resources/views/user/progress.blade.php` | 仮実装かつ `<php>` タグで壊れている | Blade として描画可能な進捗画面へ置き換える |
| ルーティング | `/progress` のみ | ユーザー系、管理系で画面遷移を整理する |

## 3. チーム開発の分担案

### A. 基盤・DB担当

- マイグレーション不足の補完
- モデルのリレーション修正
- Seeder / Factory の整備
- 共通レイアウト、共通ヘッダー、フラッシュメッセージ

### B. ユーザー画面担当

- ユーザー進捗
- ユーザーお知らせ詳細
- プロフィール設定
- パスワード変更

### C. 管理画面担当

- お知らせ一覧
- お知らせ新規登録
- お知らせ変更
- お知らせ削除

### D. テスト・レビュー担当

- Feature test の追加
- バリデーション文言確認
- 画面遷移確認
- 受講済み表示、登録/更新/削除の回帰確認

## 4. 並行開発しやすい着手順

1. `A. 基盤・DB担当` が先行してデータ構造を設計書に合わせる
2. `C. 管理画面担当` が `articles` CRUD を先に実装する
3. `B. ユーザー画面担当` が進捗画面とお知らせ詳細を実装する
4. 同じく `B. ユーザー画面担当` がプロフィール設定とパスワード変更を実装する
5. `D. テスト・レビュー担当` が結合確認と Feature test を整える

`articles` を管理側が先に完成させると、ユーザー側のお知らせ表示も同じデータを使って確認しやすくなります。

## 5. ブランチの切り方

| 担当 | 推奨ブランチ |
| --- | --- |
| 基盤・DB | `codex/feature/foundation-data` |
| ユーザー進捗・お知らせ | `codex/feature/user-progress-notice` |
| プロフィール設定 | `codex/feature/user-profile-settings` |
| 管理お知らせCRUD | `codex/feature/admin-article-crud` |
| テスト | `codex/feature/feature-tests` |

## 6. 実装時の合意事項

### ルート例

- ユーザー側
  - `GET /progress`
  - `GET /articles/{article}`
  - `GET /profile`
  - `PATCH /profile`
  - `GET /profile/password`
  - `PATCH /profile/password`

- 管理側
  - `GET /admin/articles`
  - `GET /admin/articles/create`
  - `POST /admin/articles`
  - `GET /admin/articles/{article}/edit`
  - `PUT /admin/articles/{article}`
  - `DELETE /admin/articles/{article}`

### Controller 単位

- `App\Http\Controllers\User\ProgressController`
- `App\Http\Controllers\User\ArticleController`
- `App\Http\Controllers\User\ProfileController`
- `App\Http\Controllers\Admin\ArticleController`

### View 単位

- `resources/views/user/progress.blade.php`
- `resources/views/user/articles/show.blade.php`
- `resources/views/user/profile/edit.blade.php`
- `resources/views/user/profile/password.blade.php`
- `resources/views/admin/articles/index.blade.php`
- `resources/views/admin/articles/create.blade.php`
- `resources/views/admin/articles/edit.blade.php`

## 7. 設計書ベースで先に確認したい点

### 仕様確認が必要

- プロフィール設計書では `user_name` と `name` の表記ゆれがあるため、DB は `users.name` に統一するか確認する
- 管理画面の設計書では「新規作成」と「変更」の成功メッセージや登録/更新の説明が逆転している箇所があるため、実装前に文言と処理内容を確定する
- 進捗画面にある「時間割」導線先の設計書は今回未共有なので、リンク先が未実装なら一旦ダミーにするか確認する
- 管理者認証方式の設計が未共有のため、当面は `auth` のみで仮実装するか、`admins` テーブル前提で分離するか決める

### 実装判断の提案

- `articles` はユーザー側表示と管理側管理で共通モデルを使う
- バリデーションは Form Request に切り出す
- 画像アップロード先は `storage/app/public/profile_images` を第一候補にする
- 進捗画面は Eloquent の eager loading で `user -> schoolClass`, `classes -> curriculums`, `curriculum_progress` をまとめて取得する

## 8. Definition of Done

- 設計書にある画面遷移が一通り再現されている
- 主要バリデーションが画面上で確認できる
- お知らせの作成、更新、削除、詳細表示が通る
- 進捗画面で学年別授業一覧と `受講済み` 表示が通る
- プロフィール更新とパスワード変更が通る
- 最低限の Feature test が通る
