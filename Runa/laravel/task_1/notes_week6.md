# Week 6 Notes

## Exercise 1: Test database

Tests use `internship_bookstore_testing` because `RefreshDatabase` wipes the DB every run.
テストは `internship_bookstore_testing` を使う。`RefreshDatabase` が毎回 wipe するため、開発用 DB と分けている。

---

## Exercise 2: Factory vs seeder

Factories = small data per test. Seeders = full dev DB.
Factory はテスト用の小さなデータ。Seeder は開発用の全体データ。

Call `$this->seed(...)` only for large fixed fixtures that are hard to rebuild with factories.
大量の固定データが必要なときだけ `$this->seed(...)` を使う。

---

## Exercise 3: Pagination shape

`GET /api/books?page=1&per_page=2` returns a flat `data` array (no `links` / `meta`).
ページ指定時の `data` は本の配列のみ（`links` / `meta` なし）。

```json
{ "status": 200, "message": "OK", "data": [{ "id": 1, "title": "...", "author": "...", "price": 3300 }] }
```

---

## Production fix (Exercise 4)

Missing book returned Laravel debug JSON, not `NOT_FOUND`.
存在しない本で Laravel の debug JSON が返っていた。

Fixed in `bootstrap/app.php` by also handling `NotFoundHttpException`.
`bootstrap/app.php` で `NotFoundHttpException` もハンドルして修正。

---

## Exercise 5: 400 vs 422

Laravel default is 422; this API returns 400 via `HandleErrorException` in `bootstrap/app.php`.
Laravel 標準は 422。この API は `bootstrap/app.php` の `HandleErrorException` で 400。

Tests lock that contract for API clients.
テストでその契約を固定している。

---

## Exercise 7: Reports

Do not hardcode seed.sql counts; each test builds its own data with factories.
seed.sql の件数は使わない。各テストが Factory でデータを作る。

---

## Exercise 8: Unit vs Feature

Unit (`ListBooksTest`): filter SQL, return type, `per_page` cap — points at one file.
Unit: フィルタ・戻り値型・50件上限。失敗時に1ファイルに絞れる。

Feature (`BookIndexTest`): route, envelope, Resource keys.
Feature: ルート・envelope・Resource キー。

Stop unit tests when logic is thin or already covered by Feature.
ロジックが薄い／Feature で足りるなら Unit は増やさない。

---

## Coverage map

| Route | Test |
| ----- | ---- |
| `GET/POST /api/books`, show/update/delete, order-items | `Book*Test` |
| `POST /api/register`, login, logout, `GET /api/user` | Auth tests |
| `GET /api/orders`, `GET /api/orders/{id}` | `OrderAccessTest` |
| `GET /api/reports/*` | `ReportTest` |
| Unit: Policy / ListBooks / BookSales | Unit tests |

---

## Proof (Exercise 9)

Broke `BookPolicy::delete()` to always `true`.
`BookPolicy::delete()` を常に `true` にした。

```text
FAILED BookDeleteTest > reader cannot delete a book — Expected 403, got 204
FAILED BookPolicyTest > reader cannot delete a book — Failed asserting that true is false
```

Reverted; suite green again (52 passed).
元に戻して green（52 passed）。

---

## Checklist (Exercise 9)

| # | Check | Result |
| - | ----- | ------ |
| 1 | `php artisan test` (no seed.sql) | 52 passed |
| 2 | Run twice | green both (~1s) |
| 3 | Every route tested | yes |
| 4 | 401 / 403 / 404 / 400 asserted | yes |
| 5 | Write endpoints check DB | yes |
| 6 | `ExampleTest` removed | yes |
| 7 | Suite runtime | ~970ms |

---

## Reflection (Exercise 9)

1. The 404 envelope bug was easy to miss with curl if you only check status.
   ステータスだけ見る curl では 404 の形のバグを見逃しやすい。

2. Feature = HTTP contract. Unit = one class (faster, clearer failures).
   Feature は HTTP 契約。Unit は1クラス（速い・失敗箇所がはっきりする）。

3. If half must go, keep Feature tests (auth, writes + DB, main routes).
   半分削るなら Feature（認証・書き込み + DB・主要ルート）を残す。

4. Week 4–5 refactors (Policy, Actions) would be safer with this suite.
   Week 4–5 の Policy / Action 変更は、このスイートがあればもっと安全だった。
