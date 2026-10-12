# Book Store Design Tasks 4 — Week 4: Admin book form

**Duration:** ~28 hours · **Prerequisite:** `tasks_3.md` complete. Home lists books. Login uses Formik.

Create and edit are the goal for these 28 hours. If the delete dialog or the 403 message is still open when the week ends, finish that at the start of week 5.

Continue in `../../book_store/`. Write `../task_1/notes_week4.md`.

This is the rest of the React module’s week 4 (create, edit, delete, errors). Build it on this app. Do not go back to `react/task_1/`.

A logged-in user can create and edit a book. Only an admin can delete one. The public home page stays read-only.

```text
/admin/books → Book.index()
/admin/books/new → Formik BookForm → Book.store() → POST /api/books
/admin/books/:id/edit → Book.show(id) → Book.update() → PUT /api/books/{id}
Delete → confirm → Book.destroy() → DELETE /api/books/{id}
```

---

## Blocks overview

| Block | Exercises | Focus | ~Hours |
| ----- | --------- | ----- | ------ |
| A | 1–2 | Role, write actions, show query | 8 |
| B | 3–4 | BookForm, create, edit | 12 |
| C | 5–6 | Table, delete confirm, errors | 8 |

---

## Rules (this week)

- Follow `../../book_store/README_api.md`. Create, update, and delete are three Actions. Show is `FindBookQuery`.
- Pages call `Book.store`, `Book.update`, `Book.show`, `Book.destroy`. They do not import Axios.
- `BookForm` is Formik + Yup, same pieces as the login form in week 2.
- Public `/` has no edit or delete buttons.
- Guest write → 401. Reader delete → 403 and `errors.code` = `FORBIDDEN`. The screen shows “You do not have permission”.
- Create and update are allowed for any logged-in user. Delete is admin only.

---

## Write contract

| Method | Path | Who | Success |
| ------ | ---- | --- | ------- |
| GET | `/api/books/{book}` | public | 200, one book in `data` |
| POST | `/api/books` | logged-in | 201 |
| PUT | `/api/books/{book}` | logged-in | 200 |
| DELETE | `/api/books/{book}` | admin | 204 |

Body for create and update: `title`, `author`, `price`, `stock_qty`, `published_year`. `published_year` may be null. `price` > 0. `stock_qty` is an integer >= 0. `title` and `author` are required.

`GET /api/user` now includes `role`: `reader` or `admin`.

Seed `admin@example.com` / `password` with `role` `admin`. `reader@example.com` from week 2 stays `reader`. New registers are `reader`.

---

## Exercise 1: Role and policies

Add `users.role`, string, default `reader`.

`BookPolicy`:

| Method | Allowed |
| ------ | ------- |
| `viewAny`, `view` | everyone, including guests |
| `create`, `update` | logged-in user |
| `delete` | `role` is `admin` |

`UserResource` adds `role`. `useAuthStore` keeps it on `user` after `Auth.me()`.

---

## Exercise 2: Show and write actions

| Class | Job |
| ----- | --- |
| `Queries/Book/FindBookQuery` | book by id, or null. Controller returns 404 |
| `Actions/Book/CreateBookAction` | `handle(array $data): Book` |
| `Actions/Book/UpdateBookAction` | `handle(Book $book, array $data): Book` |
| `Actions/Book/DeleteBookAction` | `handle(Book $book): void` |
| `Http/Requests/Book/StoreBookRequest` | create rules |
| `Http/Requests/Book/UpdateBookRequest` | same rules |
| `BookController` | `show`, `store`, `update`, `destroy`. Each method calls one class |

PUT sends every field. No PATCH this week.

```bash
curl -s -X POST http://127.0.0.1:8000/api/books \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"title":"Example","author":"Runa","price":1500,"stock_qty":5,"published_year":2024}'
```

Reader token on DELETE → 403. Missing token on POST → 401.

---

## Exercise 3: BookForm

`web/src/pages/admin/BookForm.tsx`

Props: `initialValues`, `onSubmit`, `submitLabel`.

| Field | Yup |
| ----- | --- |
| `title` | required string |
| `author` | required string |
| `price` | required number, > 0 |
| `stock_qty` | required integer, >= 0 |
| `published_year` | optional, empty becomes null |

Use `Input` for each field. Show Yup errors under the field. Disable submit while `isSubmitting`.

On a 400, map `errors.fields` onto those inputs and show `message` at the top. A 403 shows “You do not have permission”.

---

## Exercise 4: Create and edit

| Route | Page | Submit |
| ----- | ---- | ------ |
| `/admin/books/new` | `BookCreatePage.tsx` | `Book.store`. Empty form. On 201, go to `/admin/books` |
| `/admin/books/:id/edit` | `BookEditPage.tsx` | Load with `Book.show(id)`, then `Book.update(id, values)`. On 200, go to `/admin/books` |

Both routes sit inside `RequireAuth`.

Edit shows a loading state while `Book.show` runs. Unknown id shows the API message and a link back to `/admin/books`.

`Book.store` and `Book.update` come from `BaseModel`. Pass the form values. Do not send `id` in the body.

---

## Exercise 5: Admin table and delete

Route `/admin/books`, inside `RequireAuth`. Page `web/src/pages/admin/AdminBooksPage.tsx`.

- `Book.index({ page: 1, per_page: 15 })`
- Table columns: title, author, price, stock, actions
- “Add book” links to `/admin/books/new`
- Edit links to `/admin/books/:id/edit`
- Delete opens `web/src/components/ConfirmDialog.tsx`: the title, “This cannot be undone.”, Cancel, and Delete
- Confirm calls `Book.destroy(id)`. On 204, refetch the list
- Header link “Admin” only when `useAuthStore` has a user
- Loading, empty (“No books”), and error-with-retry, same idea as the home grid

A reader still sees Delete. The 403 message is the lesson. You may hide the button when `user.role` is not `admin`, and you still test 403 with a direct `Book.destroy` or with the button left visible. Write which you did in the notes.

---

## Exercise 6: Checklist (`notes_week4.md`)

| # | Check | Expect |
| - | ----- | ------ |
| 1 | Guest opens `/admin/books` | redirect to `/login` |
| 2 | Create with an empty title | Yup error, no request |
| 3 | Create a valid book as `reader@example.com` | 201, row in the admin table and on `/` |
| 4 | Edit that book’s price as reader | 200, new price on `/` |
| 5 | Delete as reader | 403 and “You do not have permission” |
| 6 | Delete as `admin@example.com` | 204, row gone |
| 7 | Logout, open `/admin/books/new` | redirect to `/login` |
| 8 | Home, logged out | list still works, no edit buttons |

---

## Docs

- [Formik](https://formik.org/docs/overview)
- [Yup](https://github.com/jquense/yup)
- Layout: `../../book_store/README_api.md`, `../../book_store/README_web.md`
- Policies to compare: `../../laravel/task_1` book policy and `StoreBookRequest`

---

## Submission

- [ ] Create, update, delete, and show on `book_store/api`
- [ ] Admin list, `BookForm`, create, edit, confirm delete
- [ ] `notes_week4.md` checklist
- [ ] `.env` not committed

---

## Next

`tasks_5.md` — Public book detail and the cart.
