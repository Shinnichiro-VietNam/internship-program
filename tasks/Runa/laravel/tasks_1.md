# Laravel Tasks 1 — Block 1: Routes, Controller, Eloquent

Port the **Books API** from `restful_api/task_1/api/index.php` to Laravel. Same endpoints and behavior.

Read `README.md` first. Write `task_1/notes.md` as you go — mostly at the end (Exercise 8).

---

## Blocks overview

| Block | Exercises | Focus                         |
| ----- | --------- | ----------------------------- |
| A     | 1         | Setup                         |
| B     | 2         | Health route                  |
| C     | 3–4       | Model + GET                   |
| D     | 5–6       | POST, PUT/PATCH               |
| E     | 7         | DELETE + filters + validation |
| F     | 8         | Test + reflection             |

---

## API contract (must match plain PHP)

| Method | Path              | Success       | Notes                                                    |
| ------ | ----------------- | ------------- | -------------------------------------------------------- |
| GET    | `/api/health`     | `200`         | `{"status":"ok"}`                                        |
| GET    | `/api/books`      | `200`         | Array; optional `?author=`, `?min_price=`, `?max_price=` |
| GET    | `/api/books/{id}` | `200` / `404` | Single book                                              |
| POST   | `/api/books`      | `201`         | `title`, `author` required; `Location` header            |
| PUT    | `/api/books/{id}` | `200` / `404` | Replace all fields                                       |
| PATCH  | `/api/books/{id}` | `200` / `404` | Partial update                                           |
| DELETE | `/api/books/{id}` | `204` / `404` | No body on success                                       |

**JSON fields:** `id`, `title`, `author`, `price` (integer JPY), `stock_qty`, `published_year` (nullable).

**Errors:** `{"error":{"code":"NOT_FOUND"}}` · `{"error":{"code":"BAD_REQUEST","message":"..."}}` · `405` for wrong method.

**Validation:** `title` and `author` required on create/PUT; `price` > 0 when present; `stock_qty` >= 0; empty PATCH body → `400`.

---

## Exercise 1: Setup

1. Create Laravel in `tasks/Runa/laravel/task_1/` (see `README.md`).
2. MariaDB running; `internship_bookstore` exists (`database/schema/setup.sql` + `seed.sql`).
3. Configure `.env` → `internship_bookstore`.
4. Confirm connection: `php artisan db:show` or `DB::connection()->getPdo()` in tinker.

Do **not** run migrations to recreate `books` — the table already exists.

---

## Exercise 2: Health

1. `GET /api/health` → `HealthController@index` → `200` + `{"status":"ok"}`.
2. `POST /api/health` → `405`.

```bash
curl -s http://127.0.0.1:8000/api/health
```

---

## Exercise 3: `Book` model

1. `app/Models/Book.php` — table `books`, primary key `book_id`.
2. `$fillable`: `title`, `author`, `price`, `stock_qty`, `published_year`.
3. JSON uses `id` (from `book_id`) — pick one approach (accessor, manual mapping in controller, etc.).

Test in tinker: `Book::first()`.

---

## Exercise 4: GET books

1. `GET /api/books` — list, ordered by `book_id`.
2. `GET /api/books/{book}` — one book or `404`; use **route model binding**.

```bash
curl -s http://127.0.0.1:8000/api/books
curl -s http://127.0.0.1:8000/api/books/1
curl -s -o /dev/null -w "%{http_code}" http://127.0.0.1:8000/api/books/9999
```

---

## Exercise 5: POST

- Validate input; create via Eloquent; `201` + body + `Location: /api/books/{id}`.
- Invalid input → `400` + `BAD_REQUEST`.

```bash
curl -s -i -X POST http://127.0.0.1:8000/api/books \
  -H "Content-Type: application/json" \
  -d '{"title":"テスト書籍","author":"テスト著者","price":3000,"stock_qty":10}'
```

---

## Exercise 6: PUT and PATCH

- **PUT** — replace all fields; `404` if missing.
- **PATCH** — only fields in body; `400` if body empty.

---

## Exercise 7: DELETE + filters

**DELETE** — `204`, no body; `404` if missing. Hard delete (no soft deletes).

**Filters** on `GET /api/books` (Eloquent `where`, not PHP collection filter):

| Param       | Rule             |
| ----------- | ---------------- |
| `author`    | substring match  |
| `min_price` | `price >=` value |
| `max_price` | `price <=` value |

Combine with AND when multiple params are set.

Also confirm `400` for: missing `title` on POST, bad `price`, negative `stock_qty`, empty PATCH, invalid JSON.

---

## Exercise 8: Verify and reflect

In `task_1/notes.md`:

1. **Test checklist** (mark OK?):

| #   | Request                      | Expect         |
| --- | ---------------------------- | -------------- |
| 1   | GET /api/health              | 200            |
| 2   | GET /api/books               | 200            |
| 3   | GET /api/books/1             | 200            |
| 4   | GET /api/books/9999          | 404            |
| 5   | GET /api/books?author=ミック | 200, filtered  |
| 6   | POST /api/books (valid)      | 201 + Location |
| 7   | PUT /api/books/1             | 200            |
| 8   | PATCH /api/books/1           | 200            |
| 9   | DELETE /api/books/{id}       | 204            |
| 10  | POST /api/books/1            | 405            |

2. Re-run **BooksAPIPractice** against `http://127.0.0.1:8000` if you have it.

3. **Short reflection** (one paragraph total):
   - Plain PHP `index.php` vs Laravel — what moved to routes, controller, and Eloquent?
   - Trace `GET /api/books/1` through the request lifecycle (high level).

---

## Optional stretch

- `php artisan route:list`
- Form Request for validation
- One feature test for `GET /api/health`

---

## Submission

- [ ] Branch `feature/laravel-books-api`
- [ ] App in `tasks/Runa/laravel/task_1/`
- [ ] `HealthController`, `BookController`, `Book` model, routes in `api.php`
- [ ] `notes.md` with checklist + reflection
- [ ] `.env` not committed

---

## Later (not this file)

Relationships, API Resources, repositories/services, providers, Sanctum, pagination, Pest — see `README.md` **After Block 1**.
