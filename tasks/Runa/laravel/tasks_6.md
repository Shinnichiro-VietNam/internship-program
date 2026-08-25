# Laravel Tasks 6 — Week 5: Automated Testing (PHPUnit)

**Duration:** ~16–20 hours · **Prerequisite:** `tasks_5.md` complete.

Same app in `task_1/`. Write `task_1/notes_week6.md`.
同じアプリ `task_1/` を使う。`task_1/notes_week6.md` を書く。

**Goal:** Replace the manual `curl` checklist you have repeated every week with an automated test suite that proves the API contract still holds.
**目標:** 毎週繰り返してきた手動の `curl` チェックリストを、API契約が保たれていることを証明する自動テストスイートに置き換える。

```text
php artisan test   →   green   →   safe to refactor
```

Your app already has everything worth testing: routes, FormRequests, Policies, API Resources, the `ResponseData` envelope, Actions, and Query classes.
アプリにはすでにテストすべきものが揃っている: routes、FormRequests、Policies、API Resources、`ResponseData` envelope、Actions、Query classes。

This week you write tests **around** them and change as little production code as possible.
今週はそれらの**周りに**テストを書き、本番コードはできるだけ変えない。

---

## Blocks overview

## ブロック概要

| Block | Exercises | Focus                                                                 | ~Hours |
| ----- | --------- | --------------------------------------------------------------------- | ------ |
| A     | 1–2       | Test database + factories / テストDB + ファクトリ                     | 4      |
| B     | 3–5       | Feature tests — Books / Feature（本の読み書き・エラー）               | 6      |
| C     | 6–7       | Feature tests — Auth, Orders, Reports / Auth・注文・レポート          | 4      |
| D     | 8         | Unit tests — Actions, Queries, Policy / Unit（Action・Query・Policy） | 3      |
| E     | 9         | Full run, checklist, reflection / 全体実行・チェックリスト・振り返り  | 2–3    |

---

## Rules (this week)

## 今週のルール

- **The HTTP contract does not change.** If a test fails, first ask "is the test wrong?" — only fix production code when you find a real bug (write it down in notes).
  **HTTP契約は変えない。** テストが落ちたらまず「テストが間違っていないか？」を確認する。本当のバグを見つけたときだけ本番コードを直し、notes に書く。
- Tests must be **independent**: no test may depend on another test's data or on your dev database (`internship_bookstore`) rows.
  テストは**独立**させる。他のテストのデータや開発用DB（`internship_bookstore`）の行に依存しない。
- Every test rebuilds its own data with `RefreshDatabase` + factories (or a seeder call). Never assume `seed.sql` data is there.
  各テストは `RefreshDatabase` + factories（または seeder）で自分のデータを作る。`seed.sql` のデータがある前提にしない。
- One behaviour per test method, named so the failure message explains itself: `test_reader_cannot_delete_a_book`.
  1メソッド1振る舞い。失敗メッセージで内容が分かる名前にする（例: `test_reader_cannot_delete_a_book`）。
- Arrange → Act → Assert. Keep the three parts visually separated.
  Arrange → Act → Assert。3つの部分が目で分かるように分ける。
- Do **not** install Pest this week — the project already uses PHPUnit (`phpunit/phpunit ^12.5`) and `tests/` is written in PHPUnit class style.
  今週は Pest を**入れない**。すでに PHPUnit（`phpunit/phpunit ^12.5`）を使い、`tests/` は PHPUnit のクラス形式。

---

## Target layout

## 目標のディレクトリ構成

```text
tests/
├── TestCase.php                 # shared helpers (see Exercise 3)
├── Feature/
│   ├── Auth/
│   │   ├── RegisterTest.php
│   │   ├── LoginTest.php
│   │   └── LogoutTest.php
│   ├── Book/
│   │   ├── BookIndexTest.php
│   │   ├── BookShowTest.php
│   │   ├── BookStoreTest.php
│   │   ├── BookUpdateTest.php
│   │   ├── BookDeleteTest.php
│   │   └── BookOrderItemsTest.php
│   ├── Order/
│   │   └── OrderAccessTest.php
│   └── Report/
│       └── ReportTest.php
└── Unit/
    ├── Actions/Book/ListBooksTest.php
    ├── Queries/Report/BookSalesTest.php
    └── Policies/BookPolicyTest.php
```

Delete `tests/Unit/ExampleTest.php` and `tests/Feature/ExampleTest.php`. Keep `HealthCheckTest.php`.
`tests/Unit/ExampleTest.php` と `tests/Feature/ExampleTest.php` は削除する。`HealthCheckTest.php` は残す。

```bash
php artisan make:test Feature/Book/BookIndexTest
php artisan make:test Unit/Actions/Book/ListBooksTest --unit
```

---

## Exercise 1: Wire the MariaDB test database

## 演習1: MariaDB のテスト用DBを繋ぐ

Tests use a **separate** MariaDB database — never `internship_bookstore`.
テストは**別の** MariaDB データベースを使う。`internship_bookstore` は使わない。

`RefreshDatabase` migrates and wipes that database on every run.
`RefreshDatabase` は毎回そのDBを migrate して wipe する。

1. Create an empty database:
   空のデータベースを作る:

```sql
CREATE DATABASE internship_bookstore_testing;
```

1. Point `phpunit.xml` at it (keep host/user/password aligned with your `.env`):
   `phpunit.xml` をそのDBに向ける（host / user / password は `.env` に合わせる）:

```xml
<env name="DB_CONNECTION" value="mariadb"/>
<env name="DB_DATABASE" value="internship_bookstore_testing"/>
```

1. Confirm the suite can boot with no `seed.sql` data:
   `seed.sql` なしでスイートが起動できることを確認する:

```bash
php artisan test
```

(`ExampleTest` may fail — fine for now. `HealthCheckTest` should pass.)
（`ExampleTest` は落ちても今はよい。`HealthCheckTest` は通ること。）

In `notes_week6.md`: one sentence on why tests must not share `internship_bookstore` with local development.
`notes_week6.md` に、なぜテストが開発用の `internship_bookstore` を共有してはいけないかを1文で書く。

---

## Exercise 2: Factories

## 演習2: ファクトリ

Only `UserFactory` exists. Tests need data they own, so add factories for the bookstore tables:
いまあるのは `UserFactory` だけ。テストは自分用のデータが必要なので、書店テーブル用のファクトリを追加する:

```bash
php artisan make:factory BookFactory --model=Book
php artisan make:factory CustomerFactory --model=Customer
php artisan make:factory OrderFactory --model=Order
php artisan make:factory OrderItemFactory --model=OrderItem
```

Add `use HasFactory;` to `Book`, `Customer`, `Order`, and `OrderItem`.
`Book`、`Customer`、`Order`、`OrderItem` に `use HasFactory;` を追加する。

Watch out for the things that differ from a default Laravel model:
デフォルトの Laravel モデルと違う点に注意する:

- `Book` uses `book_id` as primary key and `public $timestamps = false;`
  `Book` の主キーは `book_id` で、`public $timestamps = false;`
- `price` must stay `> 0` and `stock_qty >= 0` (your CHECK constraints)
  `price` は `> 0`、`stock_qty` は `>= 0`（CHECK制約）
- `OrderFactory` / `OrderItemFactory` must produce valid foreign keys — use nested factories:
  `OrderFactory` / `OrderItemFactory` は有効な外部キーが必要 — ネストしたファクトリを使う:

```php
// OrderItemFactory
public function definition(): array
{
    return [
        'order_id'   => Order::factory(),
        'book_id'    => Book::factory(),
        'quantity'   => fake()->numberBetween(1, 5),
        'unit_price' => fake()->numberBetween(500, 5000),
    ];
}
```

Sanity check in tinker or a scratch test: `Book::factory()->count(3)->create()` inserts 3 rows.
tinker か簡単なテストで確認: `Book::factory()->count(3)->create()` で3行入ること。

**Factory vs seeder — the rule for this week:** factories for tests (small, explicit, per-test data), seeders for a usable dev database.
**Factory と Seeder — 今週のルール:** テストには Factory（小さく明示的なデータ）。開発用の満杯DBには Seeder。

Write one sentence in notes about when you would still call `$this->seed(BookSeeder::class)` inside a test.
テスト内でそれでも `$this->seed(BookSeeder::class)` を呼ぶのはどんなときか、notes に1文書く。

---

## Exercise 3: First feature test — `GET /api/books`

## 演習3: 最初の Feature テスト — `GET /api/books`

Add helpers to `tests/TestCase.php` so every test does not repeat login code:
すべてのテストでログインコードを繰り返さないよう、`tests/TestCase.php` にヘルパーを追加する:

```php
namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    protected function actingAsReader(): User
    {
        $user = User::factory()->create(['role' => 'reader']);
        Sanctum::actingAs($user);

        return $user;
    }

    protected function actingAsAdmin(): User
    {
        $user = User::factory()->admin()->create();
        Sanctum::actingAs($user);

        return $user;
    }
}
```

Then:

```php
namespace Tests\Feature\Book;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_list_books(): void
    {
        Book::factory()->count(3)->create();

        $response = $this->getJson('/api/books');

        $response->assertStatus(200)
            ->assertJsonPath('status', 200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [['id', 'title', 'author', 'price']],
            ]);
    }
}
```

Note the envelope: your `ResponseData` returns `status` / `message` / `data`, so assertions live **under** `data`.
envelope に注意: `ResponseData` は `status` / `message` / `data` を返すので、アサーションは `**data` の下\*\* に書く。

If `BookResource` exposes different keys, assert the keys you actually return — do not change the Resource to fit the test.
`BookResource` のキーが違うなら、実際に返しているキーを assert する。テストに合わせて Resource を変えない。

Also cover in `BookIndexTest`:
`BookIndexTest` では次もカバーする:

| Case                                              | Expect                                            |
| ------------------------------------------------- | ------------------------------------------------- |
| `?author=…` matches partially / author の部分一致 | 200, only matching books / 一致する本だけ         |
| `?min_price=…&max_price=…`                        | 200, only books in range / 範囲内だけ             |
| `?page=1&per_page=2`                              | 200, 2 items, paginated shape / 2件・ページ形     |
| `?per_page=999`                                   | at most 50 items (`ListBooks` caps it) / 最大50件 |

For the paginated case, first `dd($response->json())` once to see the real shape your Resource + envelope produce, then assert it.
ページネーションのケースでは、まず一度 `dd($response->json())` で実際の形を見てから assert する。

Record that shape in `notes_week6.md`.
その形を `notes_week6.md` に記録する。

---

## Exercise 4: Book write endpoints

## 演習4: 本の書き込みエンドポイント

`BookStoreTest`:

| Case                                          | Expect                                                          |
| --------------------------------------------- | --------------------------------------------------------------- |
| guest POST / ゲスト POST                      | 401, `errors.code = UNAUTHORIZED`                               |
| reader POST valid body / reader の正しい body | 201, `Location` header, row exists in DB / Location・DBに行あり |
| response body / レスポンス本文                | matches the created title/author / 作成した title/author と一致 |

```php
public function test_authenticated_user_can_create_a_book(): void
{
    $this->actingAsReader();

    $response = $this->postJson('/api/books', [
        'title'  => 'Clean Code',
        'author' => 'Robert C. Martin',
        'price'  => 3800,
    ]);

    $response->assertStatus(201)
        ->assertHeader('Location');

    $this->assertDatabaseHas('books', ['title' => 'Clean Code']);
}
```

`BookUpdateTest`: reader can `PUT` and `PATCH` (200, DB row changed); guest gets 401; unknown id gets 404.
`BookUpdateTest`: reader は `PUT` / `PATCH` 可（200、DB更新）。ゲストは 401。未知の id は 404。

`BookDeleteTest`:

| Actor  | Expect                                                     |
| ------ | ---------------------------------------------------------- |
| guest  | 401                                                        |
| reader | 403, `errors.code = FORBIDDEN`, row still there / 行は残る |
| admin  | 204, `assertDatabaseMissing`                               |

Always assert the **database effect**, not only the status code — that is what catches a policy that returns 403 but deleted the row anyway.
ステータスだけでなく **DBへの影響** も必ず assert する。403なのに行が消えていた、を捕まえるため。

For delete, use `book_id` (not `id`):
削除の確認では `book_id` を使う（`id` ではない）:

```php
$this->assertDatabaseMissing('books', ['book_id' => $book->book_id]);
```

`BookOrderItemsTest` — `GET /api/books/{book}/order-items`:

| Case                                | Setup                                     | Expect                                            |
| ----------------------------------- | ----------------------------------------- | ------------------------------------------------- |
| book with order items / 明細あり    | `Book` + `Order`/`Customer` + `OrderItem` | 200, items present / 明細あり                     |
| book with no order items / 明細なし | book only                                 | 200, empty list (not 404) / 空配列（404ではない） |
| unknown book id / 未知の本          | —                                         | 404                                               |

Build the graph with factories; assert against your real `OrderItemResource` / envelope shape.
Factory で関連データを組む。実際の `OrderItemResource` / envelope の形で assert する。

---

## Exercise 5: Validation and not-found

## 演習5: バリデーションと not-found

Your error shape comes from `HandleErrorException`, so assert it precisely:
エラーの形は `HandleErrorException` 由来なので、正確に assert する:

```php
public function test_create_book_requires_title(): void
{
    $this->actingAsReader();

    $response = $this->postJson('/api/books', ['author' => 'Someone']);

    $response->assertStatus(400)
        ->assertJsonPath('errors.code', 'BAD_REQUEST')
        ->assertJsonFragment(['field' => 'title']);
}
```

Cover:
次をカバーする:

| Request                            | Expect                           |
| ---------------------------------- | -------------------------------- |
| POST without `title` / title なし  | 400, `fields[]` contains `title` |
| POST with `price = 0`              | 400 (`gt:0`)                     |
| POST with `stock_qty = -1`         | 400                              |
| GET `/api/books/999999`            | 404, `errors.code = NOT_FOUND`   |
| DELETE `/api/books/999999` (admin) | 404                              |

Note in `notes_week6.md`: Laravel's default validation status is **422**, but this API returns **400**.
`notes_week6.md` に書く: Laravel 標準のバリデーションは **422** だが、この API は **400**。

Where in the code is that decided, and why does a test protect that decision?
どこで決まっているか、なぜテストでその決定を守るのか。

---

## Exercise 6: Auth and Orders

## 演習6: 認証と注文

`Feature/Auth/`:

| Test                                               | Expect                                                                |
| -------------------------------------------------- | --------------------------------------------------------------------- |
| register with valid body / 正しい登録              | 201, `data.token` present, user row created / tokenあり・ユーザー作成 |
| register with duplicate email / 重複email          | 400                                                                   |
| register with `password` under 8 chars / 8文字未満 | 400                                                                   |
| login with correct credentials / 正しいログイン    | 200, token returned                                                   |
| login with wrong password / 誤パスワード           | 400, `Invalid credentials.`                                           |
| logout with token / トークンでログアウト           | 204, token row deleted / トークン行削除                               |
| `GET /api/user` as guest / ゲスト                  | 401                                                                   |

For login tests, create the user with a known password: `User::factory()->create(['password' => 'password123'])` (the model casts `password` to `hashed`).
ログインテストでは既知のパスワードでユーザーを作る: `User::factory()->create(['password' => 'password123'])`（モデルが `password` を `hashed` にキャストする）。

For logout, create a **real** Sanctum token — `Sanctum::actingAs()` does not insert into `personal_access_tokens`, so it cannot prove logout:
ログアウトでは**本物の** Sanctum トークンを作る。`Sanctum::actingAs()` は `personal_access_tokens` に行を入れないので、ログアウトを証明できない:

```php
$user = User::factory()->create();
$token = $user->createToken('auth_token');

$this->withToken($token->plainTextToken)
    ->postJson('/api/logout')
    ->assertStatus(204);

$this->assertDatabaseMissing('personal_access_tokens', [
    'id' => $token->accessToken->id,
]);
```

`Feature/Order/OrderAccessTest`:

| Request                        | Expect |
| ------------------------------ | ------ |
| `GET /api/orders` guest        | 401    |
| `GET /api/orders` reader       | 200    |
| `GET /api/orders/{id}` reader  | 200    |
| `GET /api/orders/{id}` unknown | 404    |

---

## Exercise 7: Reports

## 演習7: レポート

`Feature/Report/ReportTest` — build the data yourself so the expected numbers are obvious:
自分でデータを作り、期待する数値がはっきり分かるようにする:

```php
public function test_books_never_sold_lists_only_unsold_books(): void
{
    $sold   = Book::factory()->create(['title' => 'Sold Book']);
    $unsold = Book::factory()->create(['title' => 'Unsold Book']);
    OrderItem::factory()->create(['book_id' => $sold->book_id]);

    $response = $this->getJson('/api/reports/books-never-sold');

    $response->assertStatus(200)
        ->assertJsonCount(1, 'data')
        ->assertJsonFragment(['title' => 'Unsold Book']);
}
```

Also cover:
次もカバーする:

- `GET /api/reports/book-sales` — two order items for one book → `total_quantity_sold` and `total_revenue_jpy` are the sums you computed by hand.
  1冊に2明細 → `total_quantity_sold` と `total_revenue_jpy` が手計算の合計と一致。
- `GET /api/reports/customers-by-city` — with and without the `?city=` filter.
  `?city=` あり／なしの両方。
- Reports are public: all three return 200 for a guest.
  レポートは公開: 3つともゲストで 200。

**Do not** hardcode "3 rows" from `seed.sql` like the manual checklist did. Explain in notes why that mattered.
手動チェックリストのように `seed.sql` の「3行」を**固定で書かない**。なぜそれが重要だったかを notes に書く。

---

## Exercise 8: Unit tests — Actions, Queries, Policy

## 演習8: Unit テスト — Actions, Queries, Policy

Feature tests go through HTTP. Unit tests hit one class directly, so failures point at one file.
Feature は HTTP 経由。Unit は1クラスを直接叩くので、失敗箇所が1ファイルに絞れる。

`**Unit/Policies/BookPolicyTest**` — no database needed if you build users in memory:
ユーザーをメモリ上で作れば DB は不要:

```php
public function test_reader_cannot_delete_a_book(): void
{
    $reader = new User(['role' => 'reader']);

    $this->assertFalse((new BookPolicy)->delete($reader, new Book));
}
```

Cover `viewAny`, `view`, `create`, `update`, `delete` for reader and admin.
reader と admin について `viewAny` / `view` / `create` / `update` / `delete` をカバーする。

`**Unit/Actions/Book/ListBooksTest**` (needs `RefreshDatabase`): the `author` filter matches partially, the price range excludes out-of-range books, `page` returns a `LengthAwarePaginator` while no `page` returns a `Collection`, and `per_page=999` is capped at 50.
（`RefreshDatabase` 必要）: author の部分一致、価格範囲外の除外、`page` ありは `LengthAwarePaginator` / なしは `Collection`、`per_page=999` は最大50。

`**Unit/Queries/Report/BookSalesTest**`: create one book with two order items and assert the aggregate row.
1冊に2明細を作り、集計行を assert する。

In `notes_week6.md`: for `ListBooks`, which bugs does the unit test catch that `BookIndexTest` does not, and vice versa? Where would you stop writing unit tests for this app?
`notes_week6.md` に: `ListBooks` について、Unit が見つけて Feature が見逃すバグ／その逆は何か。このアプリではどこまで Unit を書くか。

---

## Exercise 9: Full run, checklist, reflection

## 演習9: 全体実行・チェックリスト・振り返り

```bash
php artisan test
php artisan test --testsuite=Feature
php artisan test --filter=BookDeleteTest
```

**Checklist** (paste with results into `notes_week6.md`):
**チェックリスト**（結果つきで `notes_week6.md` に貼る）:

| #   | Check                                                                     | Expect                        |
| --- | ------------------------------------------------------------------------- | ----------------------------- |
| 1   | `php artisan test` on a fresh clone (no `seed.sql`) / 新規clone・seedなし | all green                     |
| 2   | Run the suite twice in a row / 2回連続実行                                | green both times              |
| 3   | Every route in `routes/api.php` has at least one test / 全ルートにテスト  | yes                           |
| 4   | 401 / 403 / 404 / 400 each asserted at least once                         | yes                           |
| 5   | Write endpoints assert DB state, not just status / 書き込みはDBも確認     | yes                           |
| 6   | `ExampleTest` files removed / ExampleTest 削除                            | yes                           |
| 7   | Suite runtime / 実行時間                                                  | note the seconds / 秒数を記録 |

**Coverage map** — a table in notes: route → test file(s), so gaps are visible.
**カバレッジマップ** — notes に route → テストファイルの表。抜けが見えるようにする。

**Proof the tests work:** temporarily break something small (e.g. make `BookPolicy::delete` return `true`), run the suite, paste the failing output, then revert.
**テストが機能する証明:** 小さな壊しを入れる（例: `BookPolicy::delete` を常に `true`）、スイートを実行し、失敗出力を貼ってから元に戻す。

A test that never fails proves nothing.
一度も落ちないテストは何も証明しない。

**Reflection** (short paragraphs):
**振り返り**（短い段落）:

1. Which bug — real or planted — did the suite catch that your manual `curl` checklist would have missed?
   手動 curl では見逃していたバグ（本物でも意図的でも）を、スイートはどれを捕まえたか。
2. Feature test vs unit test: how did you decide where each behaviour belongs?
   Feature と Unit: 各振る舞いをどちらに置くか、どう決めたか。
3. If you had to delete half of these tests, which half would you keep, and why?
   半分削るならどちらを残すか、なぜか。
4. Going back to weeks 3–5 (policies, migrations, Actions): which refactor would have been easier with this suite already in place?
   Week 3〜5（Policy、マイグレーション、Actions）に戻ると、このスイートがあればどのリファクタが楽だったか。

---

## Docs (Laravel 13.x)

## ドキュメント（Laravel 13.x）

- [Testing: Getting Started](https://laravel.com/docs/13.x/testing)
- [HTTP Tests](https://laravel.com/docs/13.x/http-tests)
- [Database Testing](https://laravel.com/docs/13.x/database-testing)
- [Eloquent Factories](https://laravel.com/docs/13.x/eloquent-factories)
- [Sanctum — testing](https://laravel.com/docs/13.x/sanctum#testing)
- [Mocking](https://laravel.com/docs/13.x/mocking)

---

## Submission

## 提出チェック

- [ ] `phpunit.xml` uses `internship_bookstore_testing` (not `internship_bookstore`)
      `phpunit.xml` が `internship_bookstore_testing` を使う（開発用ではない）

- [ ] Factories for `Book`, `Customer`, `Order`, `OrderItem`
      上記4モデルの Factory がある

- [ ] Feature tests for every route in `routes/api.php` (including `order-items`)
      `routes/api.php` の全ルートに Feature テストがある（`order-items` 含む）

- [ ] Unit tests for `BookPolicy`, `ListBooks`, `BookSales`
      `BookPolicy` / `ListBooks` / `BookSales` の Unit テストがある

- [ ] `php artisan test` green, twice in a row, with no manual DB setup / `seed.sql`
      `php artisan test` が2回連続 green（手動DBセットアップ / `seed.sql` なし）

- [ ] `ExampleTest` files deleted
      `ExampleTest` を削除済み

- [ ] `notes_week6.md` — test DB note, pagination shape, coverage map, planted-failure output, checklist, reflection
      `notes_week6.md` — テストDBメモ、ページネーション形、カバレッジ、意図的失敗の出力、チェックリスト、振り返り

- [ ] No change to the HTTP contract (any production fix explained in notes)
      HTTP契約は変えない（本番修正があれば notes に説明）
