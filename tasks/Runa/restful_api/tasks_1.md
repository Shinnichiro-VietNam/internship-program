# RESTful API Tasks 1 (3 Days)

| Day | Work                               |
| --- | ---------------------------------- |
| 1   | Concepts (Ex 1–2)                  |
| 2   | Design + setup + GET (Ex 4–6)      |
| 3   | CRUD + validation + tests (Ex 7–8) |

**Exercise 3** (curl on your API): do **after Ex 5 and 7**.

Read `README.md`, `reference/http_cheatsheet.md`, and `reference/rest_design_checklist.md`.

Copy `data/books.seed.json` → `task_1/data/books.json`.

**Folder layout**

```text
task_1/
  notes.md
  data/books.json
  api/
    index.php
    src/          # BookRepository, handlers, optional Response helper
```

---

## Concepts (for Exercise 1)

**API** — How programs talk to each other. A web API often uses HTTP: request in, response out (usually JSON).

**RESTful API** — API design around **resources** (`books`, `orders`). Each resource has a URL. The client uses HTTP methods (`GET`, `POST`, …). The server does not keep “chat memory” between requests (**stateless**).

**Six REST constraints** (list all in `notes.md`):

1. Client–server
2. Stateless
3. Cacheable
4. Uniform interface
5. Layered system
6. Code on demand (optional; brief note is enough)

**Design habits**

- URLs use nouns: `/api/books`, not `/api/deleteBook`
- Use HTTP methods and status codes, not only `200` + `"error"` in the body
- JSON for request/response bodies

**HTTP methods (books)**

| Method | Use                | Body? | Example                    |
| ------ | ------------------ | ----- | -------------------------- |
| GET    | Read               | No    | List books, get book `3`   |
| POST   | Create             | Yes   | New book; server sets `id` |
| PUT    | Replace all fields | Yes   | Replace book `3`           |
| PATCH  | Update some fields | Yes   | Change only `stock_qty`    |
| DELETE | Remove             | No    | Delete book `3`            |

In `notes.md`, say which methods are **safe** and **idempotent** (see cheatsheet).

---

### Exercise 1: Concept notes

In `task_1/notes.md`, answer in your own words (English and Japanese):

1. What is an API? One real-world example.
2. What is a RESTful API?
3. Name the six REST constraints. One-line example each for **client–server** and **stateless** (Books API).
4. Why noun URLs? Why status codes instead of always `200`?
5. Compare GET, POST, PUT, PATCH, DELETE (purpose + idempotent or not).

---

### Exercise 2: Status codes

In `notes.md`, update the table: **scenario → method → status code → reason**.
Example scenarios:
| # | Scenario | Method | Status Code | Reason |
| --- | --- | --- | --- | --- |
| 1 | List all books | GET | 200 | Success |
| 2 | Get book `99` | GET | 404 | Not found |
| 3 | Create valid book | POST | 201 | Created |
| 4 | Create with invalid JSON | POST | 400 | Bad request |
| 5 | Delete existing book | DELETE | 204 | No content |
| 6 | `POST /api/books/5` (not in your API design) | POST | 405 | Method not allowed |

---

### Exercise 3: curl on your API

**After Exercises 5 and 7.** Section in `notes.md`: `## HTTP practice (curl)`.

```bash
cd task_1/api
php -S localhost:8080 index.php
```

For each request, write: curl command, status code, one-line summary of the body.

| #   | Request                                 | Expect                       |
| --- | --------------------------------------- | ---------------------------- |
| 1   | `GET /api/health`                       | `200`                        |
| 2   | `GET /api/books`                        | `200`, array                 |
| 3   | `GET /api/books/1`                      | `200`, one book              |
| 4   | `GET /api/books/999`                    | `404`                        |
| 5   | `GET /api/books?author=ミック`          | `200`, filtered (Ex 6)       |
| 6   | `POST /api/books`                       | `201`, `Location` header     |
| 7   | `PUT /api/books/1`                      | `200`                        |
| 8   | `PATCH /api/books/1`                    | `200`                        |
| 9   | `DELETE /api/books/{id}`                | `204` or `200` (your choice) |
| 10  | Wrong method (e.g. `POST /api/books/1`) | `405`                        |

Use `curl -i` once to see headers.

**Short reflection:** path vs query (`/books/3` vs `?author=`); after POST, does GET list the new book?; why `204` on DELETE is common.

---

### Exercise 4: Design

In `notes.md` (use `rest_design_checklist.md`), fill:

| Method | Path | What it does | Success | Response |
| ------ | ---- | ------------ | ------- | -------- |
|        |      |              |         |          |

**Endpoints (required)**

- `GET /api/books` — list (`?author=` optional)
- `GET /api/books/{id}`
- `POST /api/books`
- `PUT /api/books/{id}`
- `PATCH /api/books/{id}`
- `DELETE /api/books/{id}`

**Book fields:** `id`, `title`, `author`, `price` (JPY, integer), `stock_qty`, `published_year`

**Also write:** validation rules (`price > 0`, `stock_qty >= 0`, `title` not empty) and error JSON shape (see cheatsheet).

Optional: link fields to table `books` in `internship_bookstore`.

---

### Exercise 5: Setup + health

1. Create folders above.
2. Copy seed → `task_1/data/books.json`.
3. `GET /api/health` → `{"status":"ok"}`.
4. Route in `index.php`: method + path; `405` for wrong method.
5. `php -S localhost:8080 index.php` from `task_1/api/`.
6. In `notes.md`: start command + one `curl` for health.

Use `declare(strict_types=1);`. One helper for status + JSON is enough.

---

### Exercise 6: GET

1. `GET /api/books` → `200`, all books.
2. `GET /api/books/{id}` → `200` or `404`.
3. Optional: `?author=ミック` — filter by author (document match rule).

Read/write `task_1/data/books.json`. Header: `Content-Type: application/json; charset=utf-8`.

In `notes.md`: 3 curl examples (include one `404`).

---

### Exercise 7: POST, PUT, PATCH, DELETE

1. **POST** — no `id` in body; server picks next id; validate; `201` + body + `Location: /api/books/{id}`; save file.
2. **PUT** — replace all fields; `404` if missing.
3. **PATCH** — only fields in body; `404` if missing; `400` if empty/invalid body.
4. **DELETE** — `204` (no body) or `200` + `{"deleted":true}`; document choice; `404` if missing.

Save `books.json` after each change.

---

### Exercise 8: Validation + test checklist

**400** when:

- Invalid JSON
- `price` not positive
- `stock_qty` negative
- `title` or `author` empty on create

Same error JSON shape for `400`, `404`, `405`.

**Checklist** in `notes.md` (reuse Ex 3 rows + add invalid create → `400`):

| #   | Action | Status | OK? |
| --- | ------ | ------ | --- |
|     |        |        |     |

**Reflection (short):** auth later? JSON file vs SQL `books` table? What would Laravel change (high level)?

---

## Optional stretch

- Filter `?min_price=` / `?max_price=`
- PDO instead of JSON
- Pagination `?page=1&per_page=5`
- Postman / `.http` file for your trainer

**Tip:** Broken `books.json`? Copy from `data/books.seed.json` again.
