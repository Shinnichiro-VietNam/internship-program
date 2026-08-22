# Week 6 Notes

## Exercise 1: Test database

- Use a separate DB (`internship_bookstore_testing`). `RefreshDatabase` wipes data every run — do not share the dev DB.
- テスト専用 DB を使う。毎回 wipe されるので、開発用 DB と共有しない。

| Item          | Result                         |
| ------------- | ------------------------------ |
| DB            | `internship_bookstore_testing` |
| `phpunit.xml` | `mariadb` + testing DB name    |

---

## Exercise 2: Factory vs seeder

- **Factory:** small data per test. **Seeder:** full dev DB.
- Use `$this->seed(...)` only when you need a large fixed dataset that is hard to build with factories.
- **Factory:** テストごとの小さなデータ。**Seeder:** 開発用の全体データ。
- 大量の固定データが必要なときだけ `$this->seed(...)` を使う。

| Factory            | Note                                     |
| ------------------ | ---------------------------------------- |
| `BookFactory`      | `price > 0`, `book_id` PK, no timestamps |
| `CustomerFactory`  | unique email, `city`, `created_at`       |
| `OrderFactory`     | nested `Customer`                        |
| `OrderItemFactory` | nested `Order` + `Book`                  |

---

## Exercise 3: Pagination shape

With `?page=1&per_page=2`, `data` is a **flat array** of books — no `links` / `meta`.

`ResponseData` + `BookResource::collection` のため、`data` は本の配列のみ（`links` / `meta` なし）。

```json
{
    "status": 200,
    "message": "OK",
    "data": [
        {
            "id": 1,
            "title": "...",
            "author": "...",
            "price": 3300,
            "stock_qty": 98,
            "published_year": 2005
        }
    ]
}
```

---

## Production fix (Exercise 4)

- **Bug:** missing book id returned Laravel debug JSON, not `NOT_FOUND` envelope.
- **Fix:** handle `NotFoundHttpException` in `bootstrap/app.php` (not only `ModelNotFoundException`).
- **バグ:** 404 が Laravel の debug JSON だった。
- **修正:** `bootstrap/app.php` で `NotFoundHttpException` もハンドル。

---

## Exercise 5: 400 vs Laravel 422

- Laravel default: **422**. This API: **400** + `errors.code = BAD_REQUEST`.
- Set in `bootstrap/app.php` → `HandleErrorException::renderApiValidationResponse()`.
- Tests lock this contract for API clients.
- Laravel 標準は **422**。この API は **400**。
- `bootstrap/app.php` と `HandleErrorException` で決まる。テストで契約を固定。

| Request                | Test                 |
| ---------------------- | -------------------- |
| POST no `title`        | `BookValidationTest` |
| POST `price = 0`       | `BookValidationTest` |
| POST `stock_qty = -1`  | `BookValidationTest` |
| GET unknown book       | `BookShowTest`       |
| DELETE unknown (admin) | `BookDeleteTest`     |

---

## Exercise 6: Auth and Orders

| File              | Cases                                                           |
| ----------------- | --------------------------------------------------------------- |
| `RegisterTest`    | 201 + token; duplicate email 400; short password 400            |
| `LoginTest`       | 200 + token; wrong password 400                                 |
| `LogoutTest`      | 204; token row deleted (`createToken`, not `Sanctum::actingAs`) |
| `MeTest`          | guest 401; auth 200                                             |
| `OrderAccessTest` | guest 401; reader 200; unknown 404                              |

---

## Exercise 7: Reports

| Test                | What it checks                                                           |
| ------------------- | ------------------------------------------------------------------------ |
| `books-never-sold`  | only unsold books in `data`                                              |
| `book-sales`        | `total_quantity_sold` and `total_revenue_jpy` match hand-calculated sums |
| `customers-by-city` | all cities; `?city=` filter                                              |
| guest access        | all three reports return 200                                             |

Do **not** hardcode seed.sql row counts. Each test builds its own data with factories.
seed.sql の件数を固定値で書かない。Factory でテストごとにデータを作る。

DB aggregates may return strings — cast in assertions (e.g. `(int) $row['total_quantity_sold']`).

---

## Exercise 8: Unit tests

| File | Cases |
| ---- | ----- |
| `BookPolicyTest` | viewAny/view (guest OK); create/update (reader/admin); delete (admin only) — no DB |
| `ListBooksTest` | author filter; price range; Collection vs Paginator; `per_page` cap 50 |
| `BookSalesTest` | one book, two order items → quantity + revenue sums |

### Unit vs Feature (`ListBooks`)

- **Unit catches:** wrong filter SQL, wrong return type, `per_page` cap bug — points at `ListBooks.php` only.
- **Feature catches:** wrong route, wrong envelope, wrong Resource keys — HTTP layer bugs unit tests miss.
- **Stop unit tests when:** logic is thin or already covered by feature tests (e.g. simple Policy one-liners).
- **Unit が見つける:** フィルタ SQL・Paginator 型・50件 cap のバグ（`ListBooks.php` だけ）。
- **Feature が見つける:** ルート・envelope・Resource キーのバグ。
- **Unit をやめる目安:** ロジックが薄い、Feature で十分なとき。

---

## Coverage map

| Route                               | Test                                  |
| ----------------------------------- | ------------------------------------- |
| `GET /api/books`                    | `BookIndexTest`                       |
| `POST /api/books`                   | `BookStoreTest`, `BookValidationTest` |
| `GET /api/books/{book}`             | `BookShowTest`                        |
| `PUT/PATCH /api/books/{book}`       | `BookUpdateTest`                      |
| `DELETE /api/books/{book}`          | `BookDeleteTest`                      |
| `GET /api/books/{book}/order-items` | `BookOrderItemsTest`                  |
| `POST /api/register`                | `RegisterTest`                        |
| `POST /api/login`                   | `LoginTest`                           |
| `POST /api/logout`                  | `LogoutTest`                          |
| `GET /api/user`                     | `MeTest`                              |
| `GET /api/orders`                   | `OrderAccessTest`                     |
| `GET /api/orders/{order}`           | `OrderAccessTest`                     |
| `GET /api/reports/*`                | `ReportTest`                          |

---

## Proof the tests work (Exercise 9)

1. **Planted break:** `BookPolicy::delete()` → always `true`.
2. **Failing output:**

```text
FAILED  Tests\Feature\Book\BookDeleteTest > reader cannot delete a book
Expected response status code [403] but received 204.

FAILED  Tests\Unit\Policies\BookPolicyTest > reader cannot delete a book
Failed asserting that true is false.
```

3. **Reverted:** yes — suite green again (52 passed).

意図的に `BookPolicy::delete()` を壊すと Feature と Unit の両方が落ちた。元に戻して green を確認。

---

## Final checklist (Exercise 9)

| #   | Check                             | Expect     | Result        |
| --- | --------------------------------- | ---------- | ------------- |
| 1   | `php artisan test` (no seed.sql)  | green      | 52 passed     |
| 2   | Run twice in a row                | green both | OK (~1.0s ×2) |
| 3   | Every route tested                | yes        | OK            |
| 4   | 401 / 403 / 404 / 400 each ≥ once | yes        | OK            |
| 5   | Write endpoints check DB          | yes        | OK            |
| 6   | `ExampleTest` removed             | yes        | OK            |
| 7   | Suite runtime                     | ~1s        | ~970ms        |

---

## Reflection (Exercise 9)

### 1. Bug curl would have missed

- **404 envelope bug:** missing book id returned Laravel debug JSON, not `NOT_FOUND`. Easy to miss with curl if you only check status 404.
- **404 の envelope バグ:** ステータスだけ見る curl では見逃しやすかった。

### 2. Feature vs unit

- **Feature:** HTTP contract — status, envelope, auth, DB side effects.
- **Unit:** one class — filter SQL, Policy rules, query aggregates. Faster, clearer file on failure.
- **Feature:** HTTP 契約。**Unit:** 1クラスのロジック。失敗時にファイルが特定しやすい。

### 3. Which half to keep?

- Keep **Feature tests** (auth, write + DB, validation shape, main routes). Drop redundant unit tests for thin Policies if time is short.
- 時間がなければ **Feature を優先**。薄い Policy の Unit は削ってもよい。

### 4. Easier refactor with this suite?

- **Actions / Queries split (Week 5):** Feature tests prove HTTP unchanged; unit tests pin filter/aggregate logic.
- **Policy migration (Week 4):** delete 403/204 tests catch wrong roles immediately.
- **Week 5 の Action 分離:** Feature で HTTP 不変を確認。**Week 4 の Policy:** delete 権限をすぐ検証。
