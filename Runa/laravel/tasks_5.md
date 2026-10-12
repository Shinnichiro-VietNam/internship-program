# Laravel Tasks 5 — Week 4: Action Pattern (thin controllers)

**Duration:** ~16–20 hours · **Prerequisite:** `tasks_4.md` complete.

Same app in `task_1/`. Write `task_1/notes_week5.md`.

**Goal:** Move business/data work out of controllers into small **Action** classes so each controller method only does HTTP work.

Flow:

```text
Route → Controller (HTTP only) → Action → Eloquent Model
```

For report endpoints that use Query Builder, use a **Query** class instead of an Action (Exercise 6).

Do **not** create `*Repository` or `*Service` classes this week.

---

## Blocks overview

| Block | Exercises | Focus                                      | ~Hours |
| ----- | --------- | ------------------------------------------ | ------ |
| A     | 1–2       | First Action (`CreateBook`)                | 4      |
| B     | 3–5       | Refactor all Book endpoints to Actions     | 8      |
| C     | 6–7       | Query classes for reports; Orders choice   | 4      |
| D     | 8         | Checklist + reflection                     | 2–4    |

---

## Rules (this week)

- Controllers stay thin: authorize → call Action/Query → return response.
- Keep **FormRequest**, **Policy**, and **API Resources** — Actions do not replace them.
- **One Action class = one job.** The only public entry method is **`handle`**. Do not add a second public method on the same Action (e.g. no `create` + `update` on one class).
- Call Actions explicitly: `$createBook->handle(...)`. Do **not** use `__invoke` (calling the object like a function).
- Paths, status codes, and JSON shape must stay the same. This week is a **structure** refactor only.
- Do not create `BookRepository`, `BookService`, or interface files like `BookRepositoryInterface`.

---

## Folder layout (target)

```text
app/
├── Actions/
│   └── Book/
│       ├── CreateBook.php
│       ├── UpdateBook.php
│       ├── DeleteBook.php
│       ├── ListBooks.php
│       ├── ShowBook.php
│       └── ListBookOrderItems.php
├── Queries/
│   └── Report/
│       ├── BooksNeverSold.php
│       ├── BookSales.php
│       └── CustomersByCity.php
├── Http/Controllers/     # thin after refactor
├── Http/Requests/
├── Http/Resources/
├── Models/
└── Policies/
```

**Naming:** Action = verb + noun (`CreateBook`). Query = report name (`BooksNeverSold`).

You can create folders/files by hand, or:

```bash
php artisan make:class Actions/Book/CreateBook
```

(Adjust the path for each class.)

---

## Exercise 1: First Action — `CreateBook`

1. Create `app/Actions/Book/CreateBook.php`:

```php
<?php

namespace App\Actions\Book;

use App\Models\Book;

final class CreateBook
{
    public function handle(array $data): Book
    {
        return Book::create($data);
    }
}
```

2. Change `BookController::store` to inject and call it. Add the `use` import:

```php
use App\Actions\Book\CreateBook;

public function store(StoreBookRequest $request, CreateBook $createBook)
{
    $this->authorize('create', Book::class);

    $book = $createBook->handle($request->validated());

    return $this->httpCreated(new BookResource($book))
        ->toResponse($request)
        ->header('Location', route('books.show', $book));
}
```

Laravel resolves `CreateBook` automatically — no service provider needed.

3. Confirm `POST /api/books` still returns `201` with a Bearer token.

---

## Exercise 2: Notes — what moved where?

In `notes_week5.md`, answer briefly (bullet points OK):

1. In `store`, what stays in the **controller**? What moved into **`CreateBook`**?
2. Why one class with a single `handle` method instead of one big `BookService` with `create`, `update`, `delete`, …?
3. (Guess is OK for now.) Reports use Query Builder today. Why might those become **Query** classes later, not Actions?

---

## Exercise 3: Write Actions — `UpdateBook`, `DeleteBook`

Create:

- `App\Actions\Book\UpdateBook`
- `App\Actions\Book\DeleteBook`

Suggested shapes:

```php
// UpdateBook
public function handle(Book $book, array $data): Book
{
    $book->update($data);

    return $book;
}

// DeleteBook
public function handle(Book $book): void
{
    $book->delete();
}
```

Wire them in `update` / `destroy`. Keep `$this->authorize(...)`, FormRequest, and status helpers in the controller.

Verify:

| Request               | Expect |
| --------------------- | ------ |
| PUT/PATCH book (auth) | 200    |
| DELETE as reader      | 403    |
| DELETE as admin       | 204    |

---

## Exercise 4: Read Actions — `ListBooks`, `ShowBook`, `ListBookOrderItems`

Move list filters/pagination, show, and order-items loading into Actions under `Actions/Book/`.

**`ListBooks` — suggested idea:**

```php
public function handle(array $filters)
{
    $query = Book::query()
        ->when(/* author, min_price, max_price from $filters */)
        ->orderBy('book_id', 'asc');

    if (! empty($filters['page'])) {
        $perPage = min((int) ($filters['per_page'] ?? 15), 50);

        return $query->paginate($perPage);
    }

    return $query->get();
}
```

Controller builds `$filters` from `$request->query()`, calls `$listBooks->handle($filters)`, then wraps with `BookResource` / `httpOk` as today.

**`ShowBook`:** may only `return $book` (route model binding already loaded it). Still create the Action so every Book endpoint follows the same pattern.

**`ListBookOrderItems`:** move `$book->load('orderItems.order')` here; return the relation collection; controller still uses `OrderItemResource`.

Guidelines:

- Filtering and pagination live in **`ListBooks`**, not the controller.
- Actions return models / collections / paginators — **not** `response()->json(...)`.
- Controller + Resource still own HTTP JSON shape.

---

## Exercise 5: Thin `BookController` check

After Exercises 1–4, each Book method should look like:

1. `authorize` (if needed)
2. call Action
3. return Resource / status helper

No `Book::query()`, `Book::create()`, `->update()`, or `->delete()` left in `BookController`.

Paste a short before/after of `store` or `index` (about 5–10 lines each) into `notes_week5.md`.

---

## Exercise 6: Query classes for reports

Reports already use `DB::table(...)` in `ReportController`. Move that SQL into Query classes:

| Endpoint                             | Class                               |
| ------------------------------------ | ----------------------------------- |
| `GET /api/reports/books-never-sold`  | `App\Queries\Report\BooksNeverSold` |
| `GET /api/reports/book-sales`        | `App\Queries\Report\BookSales`      |
| `GET /api/reports/customers-by-city` | `App\Queries\Report\CustomersByCity`|

Example:

```php
<?php

namespace App\Queries\Report;

use Illuminate\Support\Facades\DB;

final class BooksNeverSold
{
    public function handle()
    {
        return DB::table('books as b')
            ->leftJoin('order_items as oi', 'oi.book_id', '=', 'b.book_id')
            ->whereNull('oi.book_id')
            ->select('b.book_id', 'b.title')
            ->get();
    }
}
```

`ReportController`:

```php
public function booksNeverSold(BooksNeverSold $booksNeverSold)
{
    return response()->json(['data' => $booksNeverSold->handle()]);
}
```

Use the same `handle` style for all three. Do **not** name them `*Repository`.

**Simple rule:** Book CRUD-style work → **Action** (Eloquent). Report/aggregate `DB::table` reads → **Query**.

---

## Exercise 7: Orders (choose one)

- **Option A:** Leave `OrderController` as-is. In notes, write 2–3 sentences: when is it OK to leave simple reads in the controller?
- **Option B:** Add `ListOrders` / `ShowOrder` Actions and thin the controller like books.

Pick one. Consistency matters more than extracting every line.

---

## Exercise 8: Final checklist + reflection

**Checklist:**

| #   | Step / request                     | Expect              |
| --- | ---------------------------------- | ------------------- |
| 1   | `migrate:fresh --seed` (if you use it) | no errors       |
| 2   | GET /api/books                     | 200                 |
| 3   | GET /api/books?author=…&page=1     | 200, filtered/paged |
| 4   | POST /api/books (token)            | 201 + Location      |
| 5   | PUT /api/books/{id} (token)        | 200                 |
| 6   | DELETE /api/books/{id} (reader)    | 403                 |
| 7   | DELETE /api/books/{id} (admin)     | 204                 |
| 8   | GET /api/orders (no token)         | 401                 |
| 9   | GET /api/reports/books-never-sold  | 200, 3 rows         |
| 10  | GET /api/reports/book-sales        | 200                 |

**Reflection** (short paragraphs in `notes_week5.md`):

1. Action vs one `BookService` with many methods — what feels clearer after this week?
2. Why did reports become Query classes instead of Actions?
3. Name one thing you would **not** split further yet in this bookstore app, and why.

---

## Docs

- Laravel: [Service Container](https://laravel.com/docs/13.x/container) (method injection of `CreateBook`, etc.)

---

## Submission

- [ ] `app/Actions/Book/` — create, update, delete, list, show, order-items
- [ ] `app/Queries/Report/` — three report queries
- [ ] `BookController` and `ReportController` thin (no Eloquent / `DB::` left there for those jobs)
- [ ] HTTP contract unchanged
- [ ] `notes_week5.md` — Exercise 2 answers, before/after, checklist, reflection
- [ ] No `*Repository` / `*Service` classes

---

## Optional stretch

- Auth Actions: `RegisterUser` / `LoginUser` / `LogoutUser`.
- Feature test: create book → 201; delete as reader → 403.
- If one HTTP request must do two writes (e.g. create order + decrease stock), how would you use `DB::transaction` inside one Action? Write 3–5 sentences in notes.

---

## Later (not this file)

Automated testing — `tasks_6.md`. Then place order + jobs / providers — `tasks_7.md`.
