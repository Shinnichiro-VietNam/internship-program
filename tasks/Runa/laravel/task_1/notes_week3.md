# Week 3 Notes

## 1. Test Checklist

| #   | Request                            | Expect      | Result |
| --- | ---------------------------------- | ----------- | ------ |
| 1   | GET /api/reports/books-never-sold  | 200, 3 rows | OK     |
| 2   | GET /api/reports/book-sales        | 200, sorted | OK     |
| 3   | POST /api/books (no token)         | 401         | OK     |
| 4   | POST /api/books (reader token)     | 201         | OK     |
| 5   | DELETE /api/books/1 (reader token) | 403         | OK     |
| 6   | DELETE /api/books/1 (admin token)  | 204         | OK     |
| 7   | GET /api/books (no token)          | 200         | OK     |

---

## 2. Questions & Notes

### book-sales: zero sales

Exclude books with zero sales (`INNER JOIN` on `order_items`). Only books that appear in at least one order line are returned.

### When to choose Query Builder over Eloquent?

- **複雑な集計クエリや大規模なレポート:** `GROUP BY`, `SUM`, `COUNT(DISTINCT)` などの集計や多段 `JOIN` を行う場合、Eloquent モデルインスタンスの生成オーバーヘッドを回避し、直感的かつ高速に実行できる Query Builder（`DB::table`）が適している。
- **読み取り専用の処理:** モデルの機能（リレーション、イベント、ミューテタなど）が不要な純粋なデータ取得レスポンス。

### When to choose Query Builder over Eloquent?

- **Complex aggregate queries and large reports:** When performing aggregates such as `GROUP BY`, `SUM`, and `COUNT(DISTINCT)`, or multi-level `JOINs`, the Query Builder (`DB::table`) is suitable because it avoids the overhead of creating Eloquent model instances and allows for intuitive and fast execution.
- **Read-only operations:** Pure data retrieval responses that do not require model functionality (relationships, events, mutators, etc.).

### Difference between Authentication and Authorization

- **Authentication（認証）:** 「**あなたが誰であるか**」を確認すること。（例:ログイン処理、トークン検証によってユーザーの身元を証明する）
- **Authorization（認可）:** 「**あなたにその操作を行う権限があるか**」を決定すること。（例: 一般ユーザーには削除権限を与えず、管理者のみに `DELETE` を許可する）

### Difference between Authentication and Authorization

- **Authentication:** Verifying "who you are." (Example: Login process, token verification to prove user identity)
- **Authorization:** Determining "whether you have the authority to perform that operation." (Example: General users are not given delete privileges, and only administrators are allowed to use `DELETE`)
