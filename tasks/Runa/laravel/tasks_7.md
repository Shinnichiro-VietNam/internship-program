# Laravel Tasks 7 — Week 6: Place Order, Events, Jobs, Provider

**Duration:** ~16–20 hours · **Prerequisite:** `tasks_6.md` complete and `php artisan test` is green.

Continue in `task_1/`. Write `task_1/notes_week7.md`.

**Goal:** Add `POST /api/orders`. Reserve stock in one database transaction. Move logging and the low-stock warning out of the request with an Event and a queued Job. Bind a `Notifier` in a custom Provider so the Job does not construct a concrete class.

```text
Route → Controller (HTTP only) → CreateOrder (transaction)
                                      ↓
                                 OrderPlaced event
                                      ↓
                    Listener (log) + queued WarnLowStock Job
                                      ↓
                              Notifier (bound in Provider)
```

This week adds a write path. Existing Book, Auth, Report, and order-read routes must keep the same HTTP contract. The week-6 test suite must stay green.

---

## Blocks overview

| Block | Exercises | Focus                                              | ~Hours |
| ----- | --------- | -------------------------------------------------- | ------ |
| A     | 1–2       | `POST /api/orders` + `CreateOrder` + transaction   | 6      |
| B     | 3         | `OrderPlaced` event + listener                     | 3      |
| C     | 4–5       | Database queue + `WarnLowStock` Job                | 5      |
| D     | 6         | `Notifier` contract + custom Provider              | 3      |
| E     | 7–8       | Tests, checklist, reflection                       | 3      |

---

## Rules (this week)

- Existing routes do not change. If a week-6 test fails, the new code is the first suspect.
- Controllers stay thin: authorize, then Action, then Resource. Do not write Eloquent in `OrderController`.
- `CreateOrder::handle` is the only new Action. Do not add `OrderService` or `OrderRepository`.
- Logging and notifications do not live in `CreateOrder`. They run from a listener or Job after the transaction commits.
- `OrderPolicy::create` is already admin only. Keep that: a reader gets 403, a guest gets 401, an admin gets 201.
- Do not take `unit_price` from the client. Copy it from `books.price` at order time.
- Mail and SMTP are out of scope. Logging is enough. Mail is a stretch at the end.
- Tests keep `QUEUE_CONNECTION=sync` in `phpunit.xml` (already set). Manual queue practice uses `database` in `.env`.

---

## Target layout (new files)

```text
app/
├── Actions/Order/CreateOrder.php
├── Contracts/Notifier.php
├── Events/OrderPlaced.php
├── Jobs/WarnLowStock.php
├── Listeners/HandleOrderPlaced.php
├── Notifiers/LogNotifier.php
├── Providers/NotifierServiceProvider.php
└── Http/
    ├── Controllers/OrderController.php   # store() added
    └── Requests/StoreOrderRequest.php

tests/
├── Feature/Order/OrderStoreTest.php
├── Unit/Actions/Order/CreateOrderTest.php
└── Unit/Jobs/WarnLowStockTest.php
```

```bash
php artisan make:request StoreOrderRequest
php artisan make:class Actions/Order/CreateOrder
php artisan make:event OrderPlaced
php artisan make:listener HandleOrderPlaced --event=OrderPlaced
php artisan make:job WarnLowStock
php artisan make:provider NotifierServiceProvider
php artisan make:test Feature/Order/OrderStoreTest
php artisan make:test Unit/Actions/Order/CreateOrderTest --unit
php artisan make:test Unit/Jobs/WarnLowStockTest --unit
```

---

## Exercise 1: Contract — `POST /api/orders`

Add the route inside the `auth:sanctum` group, next to the existing order reads. Name the show route so `store` can send `Location` (same pattern as books):

```php
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::post('/orders', [OrderController::class, 'store']);
```

Request body (admin Bearer token):

```json
{
  "customer_id": 1,
  "items": [
    { "book_id": 3, "quantity": 2 },
    { "book_id": 5, "quantity": 1 }
  ]
}
```

`StoreOrderRequest` rules:

| Field                 | Rule                                                      |
| --------------------- | --------------------------------------------------------- |
| `customer_id`         | required, integer, `exists:customers,customer_id`         |
| `items`               | required, array, `min:1`                                  |
| `items.*.book_id`     | required, integer, `exists:books,book_id`, `distinct`     |
| `items.*.quantity`    | required, integer, `min:1`                                |

Do not accept `unit_price`, `status`, or `order_date` from the client.

`authorize()` on the FormRequest stays `true`. The controller still calls `$this->authorize('create', Order::class)`.

Add `store` on `OrderController`. Authorize, then return 501 until `CreateOrder` exists in Exercise 2. Do not call Eloquent from the controller.

```php
public function store(StoreOrderRequest $request)
{
    $this->authorize('create', Order::class);

    abort(501, 'CreateOrder not implemented yet');
}
```

Confirm a guest `POST` returns 401. Confirm a reader `POST` with a valid body returns 403. Confirm an admin `POST` currently returns 501.

In `notes_week7.md`: why `unit_price` is copied from the book instead of trusted from JSON.

---

## Exercise 2: `CreateOrder` + transaction

`app/Actions/Order/CreateOrder.php` has one public method, `handle(array $data): Order`.

Confirm `$fillable` on `Order` and `OrderItem`. Week 6 already added factories; keep `HasFactory`. `order_items` uses a composite primary key `(order_id, book_id)`. That is why `book_id` must be `distinct` in the request. Recheck the `$primaryKey` / `$incrementing` settings from `tasks_2.md` before you insert rows, or `CreateOrder` will fail in a confusing way.

Inside one `DB::transaction`:

1. Create the `orders` row: `customer_id` from input, `order_date` = today, `status` = `pending`.
2. For each item, load the book with `lockForUpdate()` so two concurrent orders cannot oversell.
3. If `stock_qty < quantity`, fail the whole request. There must be no order row and no stock change.
4. Decrement stock, then insert `order_items` with `unit_price` equal to the book's current `price`.
5. Return the order with relations loaded.

Suggested failure for short stock. Reuse the existing 400 envelope:

```php
throw ValidationException::withMessages([
    'items' => 'Insufficient stock for book '.$book->book_id,
]);
```

`HandleErrorException` already turns that into `400` with `errors.code = BAD_REQUEST`. Do not invent a new error shape.

```php
public function handle(array $data): Order
{
    $order = DB::transaction(function () use ($data) {
        // create order, lock books, check stock, decrement, create items
    });

    // dispatch event here in Exercise 3, after the transaction returns

    return $order;
}
```

Wire the controller. Load `customer` and `orderItems.book` before the Resource so the 201 body matches `GET /api/orders/{id}`:

```php
public function store(StoreOrderRequest $request, CreateOrder $createOrder)
{
    $this->authorize('create', Order::class);

    $order = $createOrder->handle($request->validated());

    return $this->httpCreated(new OrderResource($order))
        ->toResponse($request)
        ->header('Location', route('orders.show', $order));
}
```

If you dispatch the event inside the transaction closure and then throw, a listener or job might run for an order that was rolled back. Write two sentences in notes on that.

Verify by hand:

| Setup | Expect |
| ----- | ------ |
| Admin, valid items, stock enough | 201, `orders` + `order_items` rows, stock decreased by the quantities |
| Admin, `quantity` > `stock_qty` | 400, no new `orders` row, stock unchanged |
| Admin, two items, second book short | 400, first book's stock unchanged |
| Reader | 403, no row |
| Guest | 401 |

Use `php artisan tinker` or a SQL `SELECT` to confirm stock. Do not trust the status code alone.

Guest check:

```bash
curl -s -o /dev/null -w "%{http_code}" -X POST http://127.0.0.1:8000/api/orders \
  -H "Content-Type: application/json" \
  -d '{"customer_id":1,"items":[{"book_id":1,"quantity":1}]}'
```

Then repeat with a reader token (expect 403) and an admin token plus a valid body (expect 201 and a `Location` header).

---

## Exercise 3: `OrderPlaced` + listener

```bash
php artisan make:event OrderPlaced
php artisan make:listener HandleOrderPlaced --event=OrderPlaced
```

Laravel auto-discovers listeners under `app/Listeners`. Do not also call `Event::listen` in a provider, or `order.placed` will log twice.

`OrderPlaced` carries the `Order` (or `order_id`). Pick one and stay consistent.

`HandleOrderPlaced` only logs for now:

```php
Log::info('order.placed', ['order_id' => $event->order->order_id]);
```

Dispatch from `CreateOrder` after the transaction returns:

```php
OrderPlaced::dispatch($order);
```

Do not log from the Action or the controller.

Place a valid order, then check `storage/logs/laravel.log` for `order.placed`.

In notes, write one sentence on what belongs in the Action versus the listener.

---

## Exercise 4: Database queue

The `jobs` and `failed_jobs` tables already exist from the default Laravel migration. You are wiring the driver, not inventing tables.

1. In `.env` (local only, not git):

```env
QUEUE_CONNECTION=database
```

2. Confirm `config/queue.php` reads that env (it does by default).
3. Leave `phpunit.xml` on `QUEUE_CONNECTION=sync`. Tests must not depend on `queue:work`.

Do not run `queue:work` yet. An empty `jobs` table makes `queue:work --once` wait until the worker timeout. Exercise 5 gives you a real job.

In notes: what is the difference between `sync` and `database`? When would `sync` hide a bug that `database` would show?

---

## Exercise 5: `WarnLowStock` Job

Threshold: `stock_qty < 5` after the order. Document the number in notes. A class constant is fine.

`WarnLowStock` implements `ShouldQueue`. It receives a `book_id` (or the `Book`). In `handle`:

- Reload the book.
- If stock is not below the threshold, do nothing. The job still succeeds.
- If it is below, call the notifier (Exercise 6). Until the Provider exists, `Log::warning('low_stock', …)` is an acceptable temporary body. Replace it in Exercise 6.

Dispatch from `HandleOrderPlaced`, one job per book on the order. The job itself decides whether to warn:

```php
foreach ($event->order->orderItems as $item) {
    WarnLowStock::dispatch($item->book_id);
}
```

Load `orderItems` on the event payload if they are not already loaded.

Manual queue practice:

1. Create or pick a book with `stock_qty` of 4 (or order enough to drop it below 5).
2. `POST /api/orders` as admin.
3. Confirm a row in `jobs`.
4. `php artisan queue:work --once --stop-when-empty`. The row leaves `jobs` and a log line appears.

Planted failure, then revert:

1. Temporarily `throw new \RuntimeException('planted failure');` at the top of `handle`.
2. Place an order, then run `queue:work --once --stop-when-empty`.
3. Confirm a row in `failed_jobs`.
4. Revert the throw. Optionally `php artisan queue:retry all`.
5. Paste the `failed_jobs` exception snippet into `notes_week7.md`.

---

## Exercise 6: `Notifier` + `NotifierServiceProvider`

The Job must not hard-code `Log::`. Bind an interface so the implementation can change later without editing the Job.

`app/Contracts/Notifier.php`:

```php
namespace App\Contracts;

use App\Models\Book;

interface Notifier
{
    public function notifyLowStock(Book $book): void;
}
```

`app/Notifiers/LogNotifier.php`. Do not create a `*Service` class:

```php
public function notifyLowStock(Book $book): void
{
    Log::warning('low_stock', [
        'book_id' => $book->book_id,
        'stock_qty' => $book->stock_qty,
    ]);
}
```

`NotifierServiceProvider` only binds the contract. Leave listener registration to auto-discovery.

| Method       | What goes here                                               |
| ------------ | ------------------------------------------------------------ |
| `register()` | `$this->app->bind(Notifier::class, LogNotifier::class);`     |
| `boot()`     | leave empty                                                  |

List the provider in `bootstrap/providers.php`.

`WarnLowStock::handle` type-hints `Notifier`. Laravel resolves it from the container. Do not write `new LogNotifier`.

In notes:

1. `register()` versus `boot()`: one sentence each, in your own words.
2. Why the Job type-hints `Notifier` instead of `LogNotifier`.

---

## Exercise 7: Tests

Add tests. Do not delete the week-6 tests.

`Feature/Order/OrderStoreTest` (`RefreshDatabase` + factories):

| Case | Expect |
| ---- | ------ |
| guest POST | 401, `errors.code = UNAUTHORIZED` |
| reader POST valid body | 403, `errors.code = FORBIDDEN`, no `orders` row |
| admin, valid items | 201, `Location` header, order + items in DB, stock decreased |
| admin, `quantity` > stock | 400, no order row, stock unchanged |
| admin, two items, second short | 400, both stocks unchanged |
| admin, missing `items` | 400, `fields[]` contains `items` |
| admin, unknown `customer_id` | 400 |
| admin, duplicate `book_id` in `items` | 400 |

Assert database state, not only the status. Use `book_id` / `order_id` (not `id`) in `assertDatabaseHas`.

Fake the event in the HTTP tests so a down queue cannot flake later:

```php
Event::fake([OrderPlaced::class]);

// POST …

Event::assertDispatched(OrderPlaced::class);
```

The Job unit tests below cover `WarnLowStock`. You do not need a separate listener test this week.

`Unit/Actions/Order/CreateOrderTest`:

- Enough stock: order persisted, stock decreased, `unit_price` equals the book's price (not a number you passed in).
- Short stock: `ValidationException`, no order row.
- Call `handle` directly. No HTTP.

`Unit/Jobs/WarnLowStockTest`:

```php
public function test_it_notifies_when_stock_is_below_threshold(): void
{
    $book = Book::factory()->create(['stock_qty' => 2]);
    $notifier = Mockery::mock(Notifier::class);
    $notifier->shouldReceive('notifyLowStock')->once();

    $this->app->instance(Notifier::class, $notifier);

    (new WarnLowStock($book->book_id))->handle($this->app->make(Notifier::class));
}
```

Also cover stock `10`: `notifyLowStock` is not called.

```bash
php artisan test
php artisan test --filter=OrderStoreTest
```

The full suite (week 6 plus these) must be green twice in a row.

---

## Exercise 8: Checklist + reflection

Checklist (paste results into `notes_week7.md`):

| #   | Check | Expect |
| --- | ----- | ------ |
| 1   | `php artisan test` | all green, including week 6 |
| 2   | Guest `POST /api/orders` | 401 |
| 3   | Reader `POST /api/orders` | 403 |
| 4   | Admin valid order | 201, `Location`, stock down |
| 5   | Admin oversell | 400, stock unchanged |
| 6   | Two-item partial oversell | 400, no stock change on either book |
| 7   | `storage/logs/laravel.log` after a valid order | `order.placed` |
| 8   | `QUEUE_CONNECTION=database` + `queue:work --once --stop-when-empty` | `jobs` row processed; low-stock log if stock `< 5` |
| 9   | Planted job exception | row in `failed_jobs`, then reverted |
| 10  | `Notifier` resolved from the container (not `new`) | yes |
| 11  | Week-6 Book / Auth / Report tests still pass | yes |

Reflection (short paragraphs):

1. Why did the oversell case have to be a transaction, not “create order then decrement in a second query”?
2. After this week, what is easier to change: the way you store an order, or the way you notify low stock? Why?
3. `register()` versus `boot()`: which bug would you put in which method on purpose, to watch it fail?
4. If you had shipped `POST /api/orders` in week 2 (before tests, policies, Actions), what would have been harder?

---

## Docs (Laravel 13.x)

- [Service Providers](https://laravel.com/docs/13.x/providers)
- [Service Container](https://laravel.com/docs/13.x/container)
- [Events](https://laravel.com/docs/13.x/events)
- [Queues](https://laravel.com/docs/13.x/queues)
- [Database Transactions](https://laravel.com/docs/13.x/database#database-transactions)
- [Pessimistic locking](https://laravel.com/docs/13.x/queries#pessimistic-locking) (`lockForUpdate`)
- [Mocking](https://laravel.com/docs/13.x/mocking) (`Event::fake`)

---

## Submission

- [ ] `POST /api/orders`: admin 201, reader 403, guest 401
- [ ] `CreateOrder` uses `DB::transaction` and `lockForUpdate`; oversell rolls back completely
- [ ] `unit_price` snapshotted from `books.price`
- [ ] `OrderPlaced` dispatched after commit; `HandleOrderPlaced` logs
- [ ] `WarnLowStock` is `ShouldQueue`; `QUEUE_CONNECTION=database` works locally
- [ ] `Notifier` + `LogNotifier` + `NotifierServiceProvider` listed in `bootstrap/providers.php`
- [ ] Feature and unit tests for store, Action, and Job; full `php artisan test` green twice
- [ ] `notes_week7.md`: unit_price note, transaction/dispatch note, sync vs database, register vs boot, planted `failed_jobs` snippet, checklist, reflection
- [ ] No `*Service` or `*Repository` classes; no SMTP required
- [ ] Existing HTTP contract unchanged

---

## Optional stretch

- `OrderConfirmation` Mailable + `Mail::fake()` in a test. Do not configure a real mailbox.
- `GET /api/reports/low-stock`: Query class, books with `stock_qty < 5`.
- `PATCH /api/orders/{order}/cancel`: admin only, restore stock in a second transaction, tests for the restore.
- GitHub Action: run `php artisan test` on pull requests.
