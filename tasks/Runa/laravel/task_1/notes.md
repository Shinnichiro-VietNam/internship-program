# Test Checklist

| #   | Request                      | Expect         | OK? |
| --- | ---------------------------- | -------------- | --- |
| 1   | GET /api/health              | 200            | OK  |
| 2   | GET /api/books               | 200            | OK  |
| 3   | GET /api/books/1             | 200            | OK  |
| 4   | GET /api/books/9999          | 404            | OK  |
| 5   | GET /api/books?author=ミック | 200, filtered  | OK  |
| 6   | POST /api/books (valid)      | 201 + Location | OK  |
| 7   | PUT /api/books/1             | 200            | OK  |
| 8   | PATCH /api/books/1           | 200            | OK  |
| 9   | DELETE /api/books/{id}       | 204            | OK  |
| 10  | POST /api/books/1            | 405            | OK  |

## Reflection

1. プレーンなPHPとLaravelの違い
   普通のPHPでは、URLの分析、データの絞り込み、SQLでのデータベース操作、JSONの作成などをすべて1つのファイルに詰め込んでいましたがLaravelに移行したことで、それぞれの役割が綺麗に分担されました。

- ルート ：URLとHTTPメソッドの判別を担当

- BookController：具体的な処理とレスポンスの返却を担当

- モデル ：データベースとの通信を担当

1. Differences between Plain PHP and Laravel

In standard PHP, URL analysis, data filtering, SQL database operations, and JSON creation were all crammed into a single file. However, migrating to Laravel resulted in a clear division of labor.

- Route: Responsible for determining the URL and HTTP method.

- BookController: Responsible for specific processing and returning responses.

- Model: Responsible for communication with the database.

2. GET /api/books/1 のライフサイクル

- 入り口：リクエストが最初に public/index.php に届く。
- 準備：アプリの初期設定やセキュリティチェックなどの前処理を通過する。
- 道案内：URLを見て、どのルートの処理を動かすかを決定する。
- 自動検索:LaravelがURLの /1 を見て、自動的に裏側でデータベースからID: 1の本を検索してくれる。
- 実行と返却：見つかった本のデータをそのままコントローラーの show メソッドに引き渡し、最終的に綺麗なJSONデータとして画面に返される。

2. Lifecycle of GET /api/books/1

- Entry Point: The request first arrives at public/index.php.

- Preparation: The application goes through pre-processing such as initial setup and security checks.

- Navigation: The URL is examined to determine which route to execute.

- Automatic Search: Laravel examines the /1 in the URL and automatically searches the database for the book with ID: 1 in the background.

- Execution and Return: The data of the found book is passed directly to the controller's show method, and finally returned to the screen as clean JSON data.
