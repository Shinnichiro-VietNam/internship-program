# Refactoring the Books API into n-Layer Architecture

Use this guide when refactoring code from branch `feature/restful-task-1`.

Your current `task_1/api/index.php` mixes routing, validation, filtering, JSON encoding, and file I/O in one file. **n-layer** splits those jobs.

---

## Target folder layout

```text
task_1/api/
  index.php                          # Presentation: bootstrap + wire layers
  src/
    Http/
      Response.php                   # Presentation: status + JSON helpers
      Router.php                     # Presentation: match path/method → controller
    Controllers/
      HealthController.php           # Presentation: HTTP entry per resource
      BookController.php
    Services/
      BookService.php                # Business: rules, validation, filtering
    Repositories/
      BookRepositoryInterface.php    # Data: contract (DIP)
      JsonBookRepository.php         # Data: read/write books.json
```

---

## Layer responsibilities

| Layer | Classes | Does | Does **not** |
| ----- | ------- | ---- | ------------ |
| **Presentation** | `index.php`, `Router`, `Response`, `Controllers` | HTTP, routing, status codes, headers | Read `books.json` directly; business rules |
| **Business** | `BookService` | Validation, filters (`author`, price), next `id` | `echo`, `http_response_code` |
| **Data** | `BookRepository` | Load/save books array | Know about GET/POST or URLs |

**Request flow**

```text
index.php → Router → BookController → BookService → JsonBookRepository → books.json
                ↑______________________________|
                      (array data back up)
```

---

## What moves where (from monolithic `index.php`)

| Today (one file) | After refactor |
| ---------------- | -------------- |
| `if ($uri === '/api/health')` | `HealthController::index()` |
| `file_get_contents($jsonPath)` | `JsonBookRepository::all()` |
| `file_put_contents(...)` | `JsonBookRepository::save($books)` |
| Author / price filters | `BookService::list($filters)` |
| Empty title → 400 | `BookService::validateForCreate()` |
| `http_response_code` + `json_encode` | `Response::json()` / `Response::noContent()` |
| Route matching | `Router::dispatch()` |

---

## Dependency direction (important)

```text
Controllers → Services → Repository interface
                              ↑
                    JsonBookRepository implements
```

- `BookController` depends on `BookService`, not on `JsonBookRepository`.
- `BookService` depends on `BookRepositoryInterface`, not on JSON details.
- Wire concrete classes in `index.php` (manual dependency injection).

This matches **DIP** from your SOLID module.

---

## `index.php` after refactor (sketch)

```php
<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';   // autoload + create objects

$repository = new JsonBookRepository(__DIR__ . '/../data/books.json');
$bookService = new BookService($repository);
$router = new Router(
    new HealthController(),
    new BookController($bookService),
);

$router->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/');
```

---

## Checklist (same behavior as `restful-task-1`)

- [ ] `GET /api/health` → 200
- [ ] `GET /api/books` + optional `?author=`, `?min_price=`, `?max_price=`
- [ ] `GET /api/books/{id}` → 200 or 404
- [ ] `POST /api/books` → 201 + `Location` header
- [ ] `PUT` / `PATCH` / `DELETE` on `/api/books/{id}`
- [ ] Validation errors → 400 with same error shape
- [ ] Wrong method → 405 where applicable
- [ ] Re-test with curl or your BooksAPIPractice collection

---

## Reference implementation

A full working example is kept by your **trainer** locally (not in the git repo).

Try the refactor yourself first. If you are stuck, ask your trainer to review your structure or share the reference after you have attempted Exercises 10–13.
