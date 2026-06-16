# Software Architecture Tasks 2 — n-Layer Refactor (1–2 Days)

**Prerequisite:** Finish `tasks_1.md` (Exercises 1–3 at minimum) and complete the REST API on branch `feature/restful-task-1`.

You will **refactor** your monolithic Books API into **presentation → business → data** layers. Same endpoints and behavior; clearer structure.

Read `reference/layered_api_guide.md` before you start.

---

## Branch setup

```bash
git fetch origin
git checkout feature/restful-task-1
git checkout -b feature/restful-layered
```

Work in `tasks/Runa/restful_api/task_1/api/` (same paths as before).

---

## Target layout

```text
task_1/api/
  index.php
  bootstrap.php              # autoload + wiring
  src/
    Http/Response.php
    Http/Router.php
    Controllers/HealthController.php
    Controllers/BookController.php
    Services/BookService.php
    Repositories/BookRepositoryInterface.php
    Repositories/JsonBookRepository.php
```

See `reference/layered_api_guide.md` for what each layer may and may not do.

---

### Exercise 10: Quick plan (short notes)

Create `task_1/refactor_notes.md`. Write **briefly** (a few lines total):

1. What was wrong with having everything in one `index.php`?
2. One simple diagram: `Controller → Service → Repository`
3. List the **class names** you will create (no need to map every `if` block).

---

### Exercise 11: Data layer

1. Create `BookRepositoryInterface` (e.g. `all()`, `save()`).
2. Create `JsonBookRepository` for `../data/books.json`.
3. No `echo` or `http_response_code` in this layer.

---

### Exercise 12: Business layer

1. Create `BookService` with `BookRepositoryInterface` injected.
2. Move validation, filters, and CRUD logic here.
3. Return data or errors — not HTTP responses.

---

### Exercise 13: Presentation layer

1. Create `Response` helper (JSON, status codes, `Location` on 201, 204 on DELETE).
2. Create `HealthController`, `BookController`, and `Router`.
3. Slim `index.php` to bootstrap + dispatch only.

---

### Exercise 14: Verify + short reflection

1. Run the server and confirm the API still works (health, list books, one GET by id, one POST).
2. In `refactor_notes.md`, add **3–5 lines**:
   - Which layer was easiest to write? Which was hardest?
   - One thing that is still “monolith” about this project.

Optional: re-run your BooksAPIPractice collection if you have it.

---

## Submission

- Branch: `feature/restful-layered`
- Layered code under `task_1/api/`, plus short `task_1/refactor_notes.md`
- Open a PR when your trainer asks; mention the three layers in the PR body.

**Reference (after you try):** ask your trainer — solution is not in the repo.
