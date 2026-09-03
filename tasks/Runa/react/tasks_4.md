# React Tasks 4 — Week 4 (September): Forms, Admin CRUD, Polish

**Duration:** ~20 hours · **Prerequisite:** `tasks_3.md` complete (logged-in user with token).

Continue in `task_1/`.

**Goal:** Admin users can create, edit, and delete books through the UI. Errors and loading states feel complete.

```text
Protected admin routes → Formik forms → POST/PUT/PATCH/DELETE /api/books
```

---

## Blocks overview

| Block | Exercises | Focus                              | ~Hours |
| ----- | --------- | ---------------------------------- | ------ |
| A     | 1–2       | Admin table + navigation           | 4      |
| B     | 3–4       | Create + edit book forms           | 6      |
| C     | 5         | Delete with confirmation           | 3      |
| D     | 6–7       | Errors, toasts, loading polish     | 4      |
| E     | 8         | Final checklist                    | 3      |

---

## Rules (this week)

- Book writes require auth — reuse Axios client from week 3.
- Match Laravel validation: `title` and `author` required on create; `price` > 0; `stock_qty` >= 0.
- Map API `400` / `403` / `404` errors to user-visible messages — no silent failures.
- After successful create, Laravel may return `201` + `Location` — redirect to detail or admin list.
- Laravel tests must stay green — you are only adding a frontend.

---

## Book write API (reminder)

| Method | Path              | Success | Notes                    |
| ------ | ----------------- | ------- | ------------------------ |
| POST   | `/api/books`      | `201`   | Create                   |
| PUT    | `/api/books/{id}` | `200`   | Replace all fields       |
| PATCH  | `/api/books/{id}` | `200`   | Partial update           |
| DELETE | `/api/books/{id}` | `204`   | No body on success       |

Guest or missing token on write → `401`.

**Policy reminder:** readers can create and edit books; **only admin can delete**. Non-admin delete → `403` with `errors.code: FORBIDDEN`.

Test with `admin@example.com` / `password` for delete checklist items; use `reader@example.com` to confirm create/edit still works.

```bash
TOKEN=your_token_here

curl -s -i -X POST http://127.0.0.1:8000/api/books \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"title":"React入門","author":"Runa","price":3200,"stock_qty":5}'

curl -s -o /dev/null -w "%{http_code}" -X DELETE http://127.0.0.1:8000/api/books/99 \
  -H "Authorization: Bearer $TOKEN"
```

---

## Install

```bash
npx shadcn@latest add table dialog dropdown-menu sonner
```

Add `<Toaster />` from Sonner in `App.tsx` (see shadcn toast docs).

---

## Target layout

```text
src/
├── pages/
│   ├── AdminBooksPage.tsx       # table of all books
│   ├── BookCreatePage.tsx
│   └── BookEditPage.tsx
├── components/
│   └── books/
│       ├── BookForm.tsx         # shared Formik form
│       ├── BookTable.tsx
│       └── DeleteBookDialog.tsx
└── services/
    └── bookService.ts           # add create, update, delete
```

---

## Exercise 1: Admin books page

Route: **`/admin/books`** — protected (login required).

1. Reuse book list data or fetch fresh `GET /api/books`.
2. shadcn **Table** columns: title, author, price, stock, actions.
3. Actions per row:
   - **Edit** → `/admin/books/:id/edit`
   - **Delete** → opens dialog (Exercise 5)
4. **Add book** button → `/admin/books/new`.

Public `/books` page stays read-only — no edit buttons there.

Add **Admin** link in header (only when logged in).

---

## Exercise 2: Shared BookForm

Create `BookForm.tsx` with Formik + Yup.

Fields:

| Field            | Input type | Validation              |
| ---------------- | ---------- | ----------------------- |
| title            | text       | required                |
| author           | text       | required                |
| price            | number     | required, > 0           |
| stock_qty        | number     | required, integer >= 0  |
| published_year   | number     | optional, nullable      |

Props example: `initialValues`, `onSubmit`, `submitLabel`.

Show field-level errors under each input. Disable submit while submitting.

---

## Exercise 3: Create book

Route: **`/admin/books/new`**

1. Render `BookForm` with empty initial values.
2. On submit → `POST /api/books` via `bookService.create`.
3. Success → toast **Book created** → navigate to `/admin/books` or `/books/{id}`.
4. API validation error → show `message` or map `errors.code` from the envelope.

---

## Exercise 4: Edit book

Route: **`/admin/books/:id/edit`**

1. Load book with `getBook(id)` for initial values.
2. On submit → `PUT /api/books/{id}` (full replace — send all fields).
3. Success → toast **Book updated** → back to admin list.
4. Not found → friendly error page.

Optional: support PATCH for partial updates later — not required this week.

---

## Exercise 5: Delete book

`DeleteBookDialog.tsx`:

1. shadcn **Dialog** — "Delete {title}? This cannot be undone."
2. Confirm → `DELETE /api/books/{id}`.
3. Success → `204` → toast → remove row or refetch list.
4. Error → toast or inline alert.

Wire from admin table **Delete** action.

---

## Exercise 6: Error and loading polish

Across admin pages:

| State    | UI                                      |
| -------- | --------------------------------------- |
| Loading  | Skeleton or spinner on table/form load  |
| Empty    | "No books" on admin table               |
| Error    | Alert with retry button where useful    |
| Success  | Sonner toast on create/update/delete    |

Centralize API error parsing in one helper (e.g. `getErrorMessage(err)` in `lib/errors.ts`). Read Axios `err.response.data.message` and `errors.code`.

Handle `403` with **You do not have permission** (not a generic crash).

---

## Exercise 7: Extend bookService

Add to `bookService.ts`:

- `createBook(payload)`
- `updateBook(id, payload)`
- `deleteBook(id)`

Type the create/update payload (same fields as `Book`, minus `id`).

Remove any leftover `fetch` calls in the project.

---

## Exercise 8: Final checklist

**End-to-end checklist:**

| #   | Action                              | Expect                        | OK? |
| --- | ----------------------------------- | ----------------------------- | --- |
| 1   | Guest opens `/admin/books`          | Redirect to login             |     |
| 2   | Login (any user)                    | Admin link + user name in header |  |
| 3   | Create book with empty title        | Form validation error         |     |
| 4   | Create valid book (reader OK)       | 201, appears in admin table   |     |
| 5   | Edit book price (reader OK)         | 200, updated in public list   |     |
| 6   | Delete book as **admin**            | 204, gone from list + detail  |     |
| 7   | Delete as **reader**                | 403 message shown             |     |
| 8   | Logout → open `/admin/books/new`    | Redirect to login             |     |
| 9   | Public `/books` works logged out    | List + detail OK              |     |

---

## Optional stretch

- Pagination: if Laravel returns paginated `GET /api/books?page=1`, add page controls on admin table.
- Optimistic UI on delete (rollback if API fails).
- Confirm unsaved changes when leaving edit form.

---

## Submission

- [ ] Admin CRUD routes protected and working
- [ ] `BookForm`, `BookTable`, `DeleteBookDialog`
- [ ] Toasts + consistent error handling
- [ ] Checklist above completed
- [ ] No `.env` committed; Laravel API unchanged unless trainer approved

---

## After week 4

Optional October capstone: orders list, place order (`POST /api/orders`), one report page — ask your trainer for `tasks_5.md`.

**References**

- [shadcn Table](https://ui.shadcn.com/docs/components/table)
- [shadcn Dialog](https://ui.shadcn.com/docs/components/dialog)
- [shadcn Sonner](https://ui.shadcn.com/docs/components/sonner)
- [React — Managing State](https://react.dev/learn/managing-state)
