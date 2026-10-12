# Laravel Tasks 3 — Week 2: Query Builder, Authentication, Authorization (intro)

**Duration:** ~20 hours · **Prerequisite:** `tasks_2.md` complete.

Same app in `task_1/`. Write `task_1/notes_week3.md`.

---

## Blocks overview

| Block | Exercises | Focus                    | ~Hours |
| ----- | --------- | ------------------------ | ------ |
| A     | 1–3       | Query Builder            | 8      |
| B     | 4–6       | Authentication (Sanctum) | 8      |
| C     | 7         | Authorization (intro)    | 4      |

---

## Rules (this week)

- Query/report endpoints are **read-only** and return JSON.
- Auth-related migrations (`users`, `personal_access_tokens`) may be run this week — **do not** migrate `books` or other bookstore tables yet (`tasks_4.md`).
- Protect write routes on books this week; full policies in `tasks_4.md`.

---

## Exercise 1: Query Builder basics

Use `DB::table()` (not Eloquent) in a new `ReportController` or dedicated query classes — your choice, but keep controllers thin.

**`GET /api/reports/books-never-sold`**

Reproduce the database module sanity check — books with no `order_items` rows:

```sql
SELECT b.book_id, b.title
FROM books b
LEFT JOIN order_items oi ON oi.book_id = b.book_id
WHERE oi.book_id IS NULL;
```

Response:

```json
{
  "data": [
    { "book_id": 18, "title": "…" }
  ]
}
```

Expected: **3 books** on a fresh seed (see `schema/README.md`).

```bash
curl -s http://127.0.0.1:8000/api/reports/books-never-sold
```

---

## Exercise 2: Aggregates and `GROUP BY`

**`GET /api/reports/book-sales`**

Per book: `book_id`, `title`, `total_quantity_sold`, `total_revenue_jpy` (sum of `quantity * unit_price`).

- Join `books` → `order_items`.
- Exclude books with zero sales (or include with 0 — pick one, document in `notes_week3.md`).
- Order by `total_revenue_jpy` descending.

```bash
curl -s http://127.0.0.1:8000/api/reports/book-sales
```

---

## Exercise 3: Multi-table report

**`GET /api/reports/customers-by-city`**

Query Builder only. Return:

```json
{
  "data": [
    { "city": "東京", "customer_count": 6, "order_count": 12 }
  ]
}
```

- `customer_count` — customers in that city.
- `order_count` — orders linked to customers in that city (0 if none).

Optional filter: `?city=東京` returns one row.

In `notes_week3.md`: when would you choose Query Builder over Eloquent for this project?

---

## Exercise 4: Users table + Sanctum setup

1. Publish and run **only** auth migrations:

   ```bash
   php artisan install:api
   # or: composer require laravel/sanctum && php artisan migrate --path=database/migrations/xxxx_create_users_table.php
   ```

   Do **not** run migrations that recreate `books`, `orders`, etc.

2. `User` model — `HasApiTokens` trait.
3. Confirm `users` and `personal_access_tokens` tables exist; bookstore tables unchanged.

---

## Exercise 5: Register and login

| Method | Path                 | Auth | Success | Body fields                          |
| ------ | -------------------- | ---- | ------- | ------------------------------------ |
| POST   | `/api/register`      | No   | `201`   | `name`, `email`, `password`          |
| POST   | `/api/login`         | No   | `200`   | `email`, `password` → returns `token` |
| POST   | `/api/logout`        | Yes  | `204`   | Revoke current token                 |
| GET    | `/api/user`          | Yes  | `200`   | Current user (`id`, `name`, `email`) |

**Token response shape:**

```json
{
  "token": "1|…",
  "token_type": "Bearer"
}
```

Validation errors → `400` + `BAD_REQUEST` (match existing API style).

```bash
curl -s -X POST http://127.0.0.1:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{"name":"Runa","email":"runa@example.com","password":"secret1234"}'

curl -s -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"runa@example.com","password":"secret1234"}'

curl -s http://127.0.0.1:8000/api/user \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## Exercise 6: Protect book writes

Apply `auth:sanctum` middleware to:

- `POST /api/books`
- `PUT/PATCH /api/books/{book}`
- `DELETE /api/books/{book}`

**Read routes stay public** (`GET /api/books`, `GET /api/orders`, reports).

Unauthenticated write → `401`:

```json
{ "error": { "code": "UNAUTHORIZED", "message": "…" } }
```

Implement via middleware or exception handler — consistent with existing error JSON.

```bash
curl -s -o /dev/null -w "%{http_code}" -X POST http://127.0.0.1:8000/api/books \
  -H "Content-Type: application/json" \
  -d '{"title":"X","author":"Y","price":1000}'
# expect 401

curl -s -o /dev/null -w "%{http_code}" -X POST http://127.0.0.1:8000/api/books \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"title":"X","author":"Y","price":1000}'
# expect 201
```

---

## Exercise 7: Authorization intro — `Gate` and `role`

Add a `role` column to `users`: `reader` (default) or `admin`.

- Migration: `add_role_to_users_table` — run this one migration only.
- **Gate** `manage-books`: allowed when `role === 'admin'`.
- `DELETE /api/books/{book}` — requires `manage-books` (in addition to auth).
- Readers may POST/PUT/PATCH; only admins may DELETE.

Forbidden → `403`:

```json
{ "error": { "code": "FORBIDDEN", "message": "…" } }
```

Seed one admin user in tinker or a one-off script (full seeder in `tasks_4.md`):

```php
User::factory()->create(['email' => 'admin@example.com', 'role' => 'admin']);
```

Test both roles. In `notes_week3.md`: difference between **authentication** (who are you?) and **authorization** (what may you do?).

---

## Test checklist (`notes_week3.md`)

| #   | Request                                    | Expect        |
| --- | ------------------------------------------ | ------------- |
| 1   | GET /api/reports/books-never-sold          | 200, 3 rows   |
| 2   | GET /api/reports/book-sales                | 200, sorted   |
| 3   | POST /api/books (no token)                 | 401           |
| 4   | POST /api/books (reader token)             | 201           |
| 5   | DELETE /api/books/1 (reader token)         | 403           |
| 6   | DELETE /api/books/1 (admin token)          | 204           |
| 7   | GET /api/books (no token)                  | 200           |

---

## Docs (Laravel 13.x)

- [Query Builder](https://laravel.com/docs/13.x/queries)
- [Sanctum](https://laravel.com/docs/13.x/sanctum)
- [Authorization — Gates](https://laravel.com/docs/13.x/authorization#gates)

---

## Submission

- [ ] Three report endpoints (Query Builder)
- [ ] Register / login / logout / user
- [ ] Sanctum on book writes; Gate on DELETE
- [ ] `notes_week3.md` — checklist + auth vs authorization note
- [ ] `.env` not committed

---

## Next

`tasks_4.md` — Policies, Migrations, Seeders.
