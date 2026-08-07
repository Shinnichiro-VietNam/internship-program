# Week 4 Notes

## Migration order (FK-safe)

1. `users` / `cache` / `jobs` / `personal_access_tokens` / `add_role_to_users` (auth stack)
2. `departments` — no FK
3. `employees` — FK → departments
4. `customers` — no FK
5. `books` — no FK
6. `orders` — FK → customers
7. `order_items` — FK → orders, books

親テーブルは、それを参照する子テーブルより先に作る必要がある。
Parent tables must exist before child tables that reference them.

## Intentional differences vs `setup.sql`

- Laravel は API 用に `users`, `password_reset_tokens`, `sessions`, `cache`, `jobs`, `personal_access_tokens` も作る。
- Laravel also creates `users`, `password_reset_tokens`, `sessions`, `cache`, `jobs`, `personal_access_tokens` for the API app.
- `users.role` は users マイグレーションに含めている（デフォルト `reader`）。`add_role_to_users_table` は古い DB 向けに冪等。
- `users.role` is included in the users migration (default `reader`); `add_role_to_users_table` is idempotent for older DBs.
- 書店テーブルのカラム名・型・インデックス・FK・CHECK はそれ以外 `setup.sql` に合わせている。
- Bookstore tables otherwise match column names, types, indexes, FKs, and CHECK constraints from `setup.sql`.

## Gate vs Policy

- **Gate:** 単純な権限チェック向け（例: 「admin だけ本を管理できる」のような1つの真偽値）。
- **Gate:** simple capability checks (e.g. one boolean like “admin can manage books”).
- **Policy:** ルールが **モデル** に紐づき、複数アクション（`view`, `create`, `update`, `delete`）があるときに向く。`$this->authorize()` でコントローラが読みやすくなり、ルールが増えても伸ばしやすい。
- **Policy:** better when rules are tied to a **model** and multiple actions (`view`, `create`, `update`, `delete`). Policies keep controller code readable with `$this->authorize()` and scale as rules grow.

レポート（`/api/reports/*`）は公開のままにする。読み取り専用の集計で、書き込み操作を公開していないため。
Reports (`/api/reports/*`) stay public: they are read-only analytics and do not expose write operations.

## Fresh workflow (zero → working API)

```bash
# create empty DB, set DB_DATABASE in .env, then:
php artisan migrate:fresh --seed
php artisan serve
```

ローカル用ログインユーザー（本物の秘密情報は git に載せない）:
Local login users (do not commit real secrets):

- `reader@example.com` / `password` (role: reader)
- `admin@example.com` / `password` (role: admin)

## Final test checklist

| #   | Step / request                              | Expect              | Result |
| --- | ------------------------------------------- | ------------------- | ------ |
| 1   | `migrate:fresh --seed`                      | no errors           | OK     |
| 2   | Row counts match schema README              | OK                  | OK     |
| 3   | GET /api/books                              | 200                 | OK     |
| 4   | GET /api/orders (no token)                  | 401                 | OK     |
| 5   | GET /api/orders (reader token)              | 200                 | OK     |
| 6   | DELETE /api/books/1 (reader)                | 403                 | OK     |
| 7   | DELETE /api/books/18 (admin)                | 204                 | OK     |
| 8   | GET /api/reports/books-never-sold           | 200, 3 rows         | OK     |

Note: `DELETE /api/books/1` は DB 層で失敗する（`order_items` の FK が `ON DELETE RESTRICT`）。Policy 上は許可されるが、204 を確認するには未販売の本（例: `18`）を使う。
Note: `DELETE /api/books/1` fails at the DB layer (`order_items` FK `ON DELETE RESTRICT`), even for admin. Policy allows the action; use an unsold book (e.g. `18`) to observe `204`.

## Reflection

以前はスキーマとシードが手書きの SQL（`setup.sql` / `seed.sql`）にあった。MySQL クライアントで見やすく実行しやすい一方、SQL ファイルと Laravel アプリのずれが起きやすい。マイグレーションとシーダーなら、Laravel が再現手順（`migrate:fresh --seed`）を持つので、メンバーが同じスキーマと認証テーブルを自動で揃えられる。トレードオフは PHP ファイルが増えることと、CHECK / FK を元の SQL に合わせて丁寧に書く必要があること。

Previously, schema and seed lived in hand-maintained SQL files (`setup.sql` / `seed.sql`). That is easy to inspect and run with the MySQL client, but drift between the SQL files and the Laravel app is easy. With migrations and seeders, Laravel owns the repeatable path (`migrate:fresh --seed`), so teammates get the same schema and auth tables automatically. The trade-off is more PHP files to maintain, and CHECK/FK details must be written carefully to match the original SQL.
