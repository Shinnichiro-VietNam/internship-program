# Laravel Tasks 6 — Week 5: Automated Testing (PHPUnit)

**Duration:** ~16–20 hours · **Prerequisite:** `tasks_5.md` complete.

Same app in `task_1/`. Write `task_1/notes_week6.md`.

**Goal:** Replace the manual `curl` checklist you have repeated every week with an automated test suite that proves the API contract still holds.

```text
php artisan test   →   green   →   safe to refactor
```

Your app already has everything worth testing: routes, FormRequests, Policies, API Resources, the `ResponseData` envelope, Actions, and Query classes. This week you write tests **around** them and change as little production code as possible.

---

## Blocks overview

| Block | Exercises | Focus                                            | ~Hours |
| ----- | --------- | ------------------------------------------------ | ------ |
| A     | 1–2       | Test database + factories                        | 4      |
| B     | 3–5       | Feature tests — Books (read, write, errors)      | 6      |
| C     | 6–7       | Feature tests — Auth, Orders, Reports            | 4      |
| D     | 8         | Unit tests — Actions, Queries, Policy            | 3      |
| E     | 9         | Full run, checklist, reflection                  | 2–3    |

---

## Rules (this week)

- **The HTTP contract does not change.** If a test fails, first ask "is the test wrong?" — only fix production code when you find a real bug (write it down in notes).
- Tests must be **independent**: no test may depend on another test's data or on your dev database (`internship_bookstore`) rows.
- Every test rebuilds its own data with `RefreshDatabase` + factories (or a seeder call). Never assume `seed.sql` data is there.
- One behaviour per test method, named so the failure message explains itself: `test_reader_cannot_delete_a_book`.
- Arrange → Act → Assert. Keep the three parts visually separated.
- Do **not** install Pest this week — the project already uses PHPUnit (`phpunit/phpunit ^12.5`) and `tests/` is written in PHPUnit class style.

---

## Target layout

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

```bash
php artisan make:test Feature/Book/BookIndexTest
php artisan make:test Unit/Actions/Book/ListBooksTest --unit
```

---

## Exercise 1: Wire the MariaDB test database

Tests use a **separate** MariaDB database — never `internship_bookstore`. `RefreshDatabase` migrates and wipes that database on every run.

1. Create an empty database:

```sql
CREATE DATABASE internship_bookstore_testing;
```

2. Point `phpunit.xml` at it (keep host/user/password aligned with your `.env`):

```xml
<env name="DB_CONNECTION" value="mariadb"/>
<env name="DB_DATABASE" value="internship_bookstore_testing"/>
```

3. Confirm the suite can boot with no `seed.sql` data:

```bash
php artisan test
```

(`ExampleTest` may fail — fine for now. `HealthCheckTest` should pass.)

In `notes_week6.md`: one sentence on why tests must not share `internship_bookstore` with local development.

---

## Exercise 2: Factories

Only `UserFactory` exists. Tests need data they own, so add factories for the bookstore tables:

```bash
php artisan make:factory BookFactory --model=Book
php artisan make:factory CustomerFactory --model=Customer
php artisan make:factory OrderFactory --model=Order
php artisan make:factory OrderItemFactory --model=OrderItem
```

Add `use HasFactory;` to `Book`, `Customer`, `Order`, and `OrderItem`.

Watch out for the things that differ from a default Laravel model:

- `Book` uses `book_id` as primary key and `public $timestamps = false;`
- `price` must stay `> 0` and `stock_qty >= 0` (your CHECK constraints)
- `OrderFactory` / `OrderItemFactory` must produce valid foreign keys — use nested factories:

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

**Factory vs seeder — the rule for this week:** factories for tests (small, explicit, per-test data), seeders for a usable dev database. Write one sentence in notes about when you would still call `$this->seed(BookSeeder::class)` inside a test.

---

## Exercise 3: First feature test — `GET /api/books`

Add helpers to `tests/TestCase.php` so every test does not repeat login code:

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

Note the envelope: your `ResponseData` returns `status` / `message` / `data`, so assertions live **under `data`**. If `BookResource` exposes different keys, assert the keys you actually return — do not change the Resource to fit the test.

Also cover in `BookIndexTest`:

| Case                                      | Expect                                    |
| ----------------------------------------- | ----------------------------------------- |
| `?author=…` matches partially             | 200, only matching books                  |
| `?min_price=…&max_price=…`                | 200, only books in range                  |
| `?page=1&per_page=2`                      | 200, 2 items, paginated shape             |
| `?per_page=999`                           | at most 50 items (`ListBooks` caps it)    |

For the paginated case, first `dd($response->json())` once to see the real shape your Resource + envelope produce, then assert it. Record that shape in `notes_week6.md`.

---

## Exercise 4: Book write endpoints

`BookStoreTest`:

| Case                        | Expect                                          |
| --------------------------- | ----------------------------------------------- |
| guest POST                  | 401, `errors.code = UNAUTHORIZED`               |
| reader POST valid body      | 201, `Location` header, row exists in DB        |
| response body               | matches the created title/author                |

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

`BookDeleteTest`:

| Actor  | Expect                                        |
| ------ | --------------------------------------------- |
| guest  | 401                                           |
| reader | 403, `errors.code = FORBIDDEN`, row still there |
| admin  | 204, `assertDatabaseMissing`                  |

Always assert the **database effect**, not only the status code — that is what catches a policy that returns 403 but deleted the row anyway. For delete, use `book_id` (not `id`):

```php
$this->assertDatabaseMissing('books', ['book_id' => $book->book_id]);
```

`BookOrderItemsTest` — `GET /api/books/{book}/order-items`:

| Case | Setup | Expect |
| --- | --- | --- |
| book with order items | `Book` + `Order`/`Customer` + `OrderItem` | 200, items present |
| book with no order items | book only | 200, empty list (not 404) |
| unknown book id | — | 404 |

Build the graph with factories; assert against your real `OrderItemResource` / envelope shape.

---

## Exercise 5: Validation and not-found

Your error shape comes from `HandleErrorException`, so assert it precisely:

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

| Request                             | Expect                                     |
| ----------------------------------- | ------------------------------------------ |
| POST without `title`                | 400, `fields[]` contains `title`            |
| POST with `price = 0`               | 400 (`gt:0`)                                |
| POST with `stock_qty = -1`          | 400                                         |
| GET `/api/books/999999`             | 404, `errors.code = NOT_FOUND`              |
| DELETE `/api/books/999999` (admin)  | 404                                         |

Note in `notes_week6.md`: Laravel's default validation status is **422**, but this API returns **400**. Where in the code is that decided, and why does a test protect that decision?

---

## Exercise 6: Auth and Orders

`Feature/Auth/`:

| Test                                    | Expect                                     |
| --------------------------------------- | ------------------------------------------ |
| register with valid body                | 201, `data.token` present, user row created |
| register with duplicate email           | 400                                         |
| register with `password` under 8 chars  | 400                                         |
| login with correct credentials          | 200, token returned                         |
| login with wrong password               | 400, `Invalid credentials.`                 |
| logout with token                       | 204, token row deleted                      |
| `GET /api/user` as guest                | 401                                         |

For login tests, create the user with a known password: `User::factory()->create(['password' => 'password123'])` (the model casts `password` to `hashed`).

For logout, create a **real** Sanctum token — `Sanctum::actingAs()` does not insert into `personal_access_tokens`, so it cannot prove logout:

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

`Feature/Report/ReportTest` — build the data yourself so the expected numbers are obvious:

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

- `GET /api/reports/book-sales` — two order items for one book → `total_quantity_sold` and `total_revenue_jpy` are the sums you computed by hand.
- `GET /api/reports/customers-by-city` — with and without the `?city=` filter.
- Reports are public: all three return 200 for a guest.

**Do not** hardcode "3 rows" from `seed.sql` like the manual checklist did. Explain in notes why that mattered.

---

## Exercise 8: Unit tests — Actions, Queries, Policy

Feature tests go through HTTP. Unit tests hit one class directly, so failures point at one file.

**`Unit/Policies/BookPolicyTest`** — no database needed if you build users in memory:

```php
public function test_reader_cannot_delete_a_book(): void
{
    $reader = new User(['role' => 'reader']);

    $this->assertFalse((new BookPolicy)->delete($reader, new Book));
}
```

Cover `viewAny`, `view`, `create`, `update`, `delete` for reader and admin.

**`Unit/Actions/Book/ListBooksTest`** (needs `RefreshDatabase`): the `author` filter matches partially, the price range excludes out-of-range books, `page` returns a `LengthAwarePaginator` while no `page` returns a `Collection`, and `per_page=999` is capped at 50.

**`Unit/Queries/Report/BookSalesTest`**: create one book with two order items and assert the aggregate row.

In `notes_week6.md`: for `ListBooks`, which bugs does the unit test catch that `BookIndexTest` does not, and vice versa? Where would you stop writing unit tests for this app?

---

## Exercise 9: Full run, checklist, reflection

```bash
php artisan test
php artisan test --testsuite=Feature
php artisan test --filter=BookDeleteTest
```

**Checklist** (paste with results into `notes_week6.md`):

| #   | Check                                                     | Expect              |
| --- | --------------------------------------------------------- | ------------------- |
| 1   | `php artisan test` on a fresh clone (no `seed.sql` run)    | all green           |
| 2   | Run the suite twice in a row                               | green both times    |
| 3   | Every route in `routes/api.php` has at least one test      | yes                 |
| 4   | 401 / 403 / 404 / 400 each asserted at least once          | yes                 |
| 5   | Write endpoints assert DB state, not just status           | yes                 |
| 6   | `ExampleTest` files removed                                | yes                 |
| 7   | Suite runtime                                              | note the seconds    |

**Coverage map** — a table in notes: route → test file(s), so gaps are visible.

**Proof the tests work:** temporarily break something small (e.g. make `BookPolicy::delete` return `true`), run the suite, paste the failing output, then revert. A test that never fails proves nothing.

**Reflection** (short paragraphs):

1. Which bug — real or planted — did the suite catch that your manual `curl` checklist would have missed?
2. Feature test vs unit test: how did you decide where each behaviour belongs?
3. If you had to delete half of these tests, which half would you keep, and why?
4. Going back to weeks 3–5 (policies, migrations, Actions): which refactor would have been easier with this suite already in place?

---

## Docs (Laravel 13.x)

- [Testing: Getting Started](https://laravel.com/docs/13.x/testing)
- [HTTP Tests](https://laravel.com/docs/13.x/http-tests)
- [Database Testing](https://laravel.com/docs/13.x/database-testing)
- [Eloquent Factories](https://laravel.com/docs/13.x/eloquent-factories)
- [Sanctum — testing](https://laravel.com/docs/13.x/sanctum#testing)
- [Mocking](https://laravel.com/docs/13.x/mocking)

---

## Submission

- [ ] `phpunit.xml` uses `internship_bookstore_testing` (not `internship_bookstore`)
- [ ] Factories for `Book`, `Customer`, `Order`, `OrderItem`
- [ ] Feature tests for every route in `routes/api.php` (including `order-items`)
- [ ] Unit tests for `BookPolicy`, `ListBooks`, `BookSales`
- [ ] `php artisan test` green, twice in a row, with no manual DB setup / `seed.sql`
- [ ] `ExampleTest` files deleted
- [ ] `notes_week6.md` — test DB note, pagination shape, coverage map, planted-failure output, checklist, reflection
- [ ] No change to the HTTP contract (any production fix explained in notes)

---

## Later (not this file)

Place an order + events / jobs / provider — `tasks_7.md`.
