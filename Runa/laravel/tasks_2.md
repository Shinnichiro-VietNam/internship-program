# Laravel Tasks 2 — Week 1: Form Request, Relationships, API Resources, Pagination

**Estimated Duration:** ~20 hours · **Prerequisite:** `tasks_1.md` complete (working Books API in `task_1/`).

Continue in the **same Laravel app** (`task_1/`). Refactor and extend the Books API — do not start a new project.

Read `README.md` and `../database/schema/README.md`. Write `task_1/notes_week2.md` as you go (reflection mostly at the end).

---

## Blocks overview

| Block | Exercises | Focus                              | ~Hours |
| ----- | --------- | ---------------------------------- | ------ |
| A     | 1–2       | Form Request                       | 4      |
| B     | 3–5       | Eloquent relationships + endpoints | 6      |
| C     | 6–7       | API Resources                      | 5      |
| D     | 8         | Pagination + verify                | 5      |

---

## Rules (this week)

- Keep all **task_1** book endpoints working — same paths, status codes, and error JSON.
- New list shape for paginated responses (Exercise 8) applies only when `?page={page number}&per_page={number of items per page}` is used; without it, `GET /api/books` still returns a plain array (backward compatible).
- Use existing tables in `internship_bookstore` — **no migrations yet** (week 3).
- API only — `routes/api.php`.

---

## Exercise 1: `StoreBookRequest`

Move **create** validation out of `BookController`.

1. `php artisan make:request StoreBookRequest`
2. `authorize()` → `true` (auth comes in `tasks_3.md`).
3. `rules()` — same rules as task_1 POST:
   - `title`, `author` — required
   - `price` — numeric, `> 0` when present
   - `stock_qty` — integer, `>= 0`
   - `published_year` — nullable integer
4. Type-hint `StoreBookRequest` on `store()`.
5. On failure Laravel returns `422` by default — **override** or use a custom failed-validation response so the API still returns `400` + `{"error":{"code":"BAD_REQUEST","message":"..."}}` (match task_1).

Test:

```bash
curl -s -X POST http://127.0.0.1:8000/api/books \
  -H "Content-Type: application/json" \
  -d '{"author":"テスト著者"}'
```

---

## Exercise 2: `UpdateBookRequest`

1. `php artisan make:request UpdateBookRequest`
2. Rules for **PUT** (all fields required, same as create) and **PATCH** (fields optional).
   - Hint: check `$this->isMethod('put')` or use separate Form Requests if clearer.
3. Wire into `update()` for PUT and PATCH.
4. Empty PATCH body → `400` + `BAD_REQUEST` (same as task_1).

Confirm POST/PUT/PATCH still pass your task_1 checklist.

---

## Exercise 3: Models for related tables

Add Eloquent models for tables that already exist in `internship_bookstore`:

| Model       | Table         | Primary key   |
| ----------- | ------------- | ------------- |
| `Customer`  | `customers`   | `customer_id` |
| `Order`     | `orders`      | `order_id`    |
| `OrderItem` | `order_items` | composite PK  |

For `OrderItem`, set `$primaryKey` / `$incrementing` appropriately, or use a string/composite key strategy documented in `notes_week2.md`.

Define **relationships**:

```
Customer  hasMany  Order
Order     belongsTo Customer
Order     hasMany  OrderItem
OrderItem belongsTo Order
OrderItem belongsTo Book
Book      hasMany  OrderItem
```

Verify in tinker:

```php
Book::with('orderItems')->first();
Order::with(['customer', 'orderItems.book'])->first();
```

---

## Exercise 4: `GET /api/orders`

New read-only endpoints (no auth yet).

| Method | Path                  | Success       | Notes                                |
| ------ | --------------------- | ------------- | ------------------------------------ |
| GET    | `/api/orders`         | `200`         | List orders, newest `order_id` first |
| GET    | `/api/orders/{order}` | `200` / `404` | Single order + nested items          |

**JSON shape (order detail):**

```json
{
  "id": 1,
  "order_date": "2024-03-15",
  "status": "paid",
  "customer": {
    "id": 2,
    "full_name": "田中 太郎",
    "city": "東京"
  },
  "items": [
    {
      "book_id": 3,
      "title": "…",
      "quantity": 1,
      "unit_price": 2800
    }
  ]
}
```

Use route model binding on `Order` (`order_id`). Return task_1-style `NOT_FOUND` JSON on missing order.

```bash
curl -s http://127.0.0.1:8000/api/orders
curl -s http://127.0.0.1:8000/api/orders/1
curl -s -o /dev/null -w "%{http_code}" http://127.0.0.1:8000/api/orders/9999
```

---

## Exercise 5: `GET /api/books/{book}/order-items`

Nested route — line items for one book (sales history).

| Method | Path                            | Success       |
| ------ | ------------------------------- | ------------- |
| GET    | `/api/books/{book}/order-items` | `200` / `404` |

Response: array of `{ "order_id", "quantity", "unit_price", "order_date", "status" }`.

Use eager loading — no N+1 when listing many items.

```bash
curl -s http://127.0.0.1:8000/api/books/1/order-items
```

In `notes_week2.md`, write one sentence each: `hasMany`, `belongsTo`, and when you used `with()`.

---

## Exercise 6: `BookResource`

1. `php artisan make:resource BookResource`
2. Move JSON field mapping from the controller into the resource:
   - `book_id` → `id`
   - `title`, `author`, `price` (integer JPY), `stock_qty`, `published_year`
3. Use `BookResource` in `show()` and when returning a single book from create/update.

```bash
curl -s http://127.0.0.1:8000/api/books/1
```

---

## Exercise 7: `BookCollection`, `OrderResource`

1. `BookCollection` — wraps an array of books (used when **not** paginating).
2. `OrderResource` — format for order list + detail (customer + items).
3. Refactor `OrderController` to use resources.
4. Optional: `OrderItemResource` if it keeps `OrderResource` readable.

Keep error responses **outside** resources (unchanged task_1 format).

---

## Exercise 8: Pagination + verify

**Paginated list** — when `GET /api/books?page=1` (and optional `&per_page=5`, max 50):

```json
{
  "data": [
    /* BookResource objects */
  ],
  "meta": {
    "current_page": 1,
    "per_page": 15,
    "total": 20,
    "last_page": 2
  }
}
```

- Default `per_page` = `15` when `page` is present.
- `GET /api/books` **without** `page` — plain array (task_1 contract).
- Filters (`author`, `min_price`, `max_price`) still work with pagination.

```bash
curl -s "http://127.0.0.1:8000/api/books?page=1&per_page=5"
curl -s "http://127.0.0.1:8000/api/books?author=ミック&page=1"
curl -s http://127.0.0.1:8000/api/books
```

### Test checklist (`notes_week2.md`)

| #   | Request                          | Expect                |
| --- | -------------------------------- | --------------------- |
| 1   | POST /api/books (missing title)  | 400, BAD_REQUEST      |
| 2   | GET /api/books                   | 200, plain array      |
| 3   | GET /api/books?page=1&per_page=5 | 200, data + meta      |
| 4   | GET /api/orders/1                | 200, customer + items |
| 5   | GET /api/books/1/order-items     | 200                   |
| 6   | GET /api/books/9999/order-items  | 404                   |

### Reflection (short paragraph)

- What moved from controller → Form Request → Resource?
- Compare `with()` and `load()` and `loadMissing()` for `GET /api/orders/1`.

---

## Docs (Laravel 13.x)

- [Form Request Validation](https://laravel.com/docs/13.x/validation#form-request-validation)
- [Eloquent Relationships](https://laravel.com/docs/13.x/eloquent-relationships)
- [API Resources](https://laravel.com/docs/13.x/eloquent-resources)
- [Pagination](https://laravel.com/docs/13.x/pagination)

---

## Submission

- [ ] Form Requests for store/update
- [ ] `Customer`, `Order`, `OrderItem` models + relationships
- [ ] Order + order-items routes with API Resources
- [ ] Paginated `GET /api/books?page=1`
- [ ] `notes_week2.md` — checklist + reflection
- [ ] `.env` not committed

---

## Next

`tasks_3.md` — Query Builder, Authentication, Authorization (intro).
