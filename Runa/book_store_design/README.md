# Book Store Design

**Duration:** Weeks 1–6, 28 hours each except week 5 (24). Nothing runs past 28 hours in one week.

Tasks for the bookstore in `../book_store/`. Week 1 is the Fahasa feature list and the shared setup. Week 2 teaches Formik on login and register. Week 4 is the React module’s form-and-CRUD week, done here instead of `react/tasks_4.md`. Weeks 5 and 6 are the public book page, the cart, and placing an order.

**AI tools:** Allowed. The Fahasa notes have to come from pages you opened. In review you walk through the feature list and the error JSON yourself.

---

## Files

| File | Purpose |
| ---- | ------- |
| `README.md` | This guide |
| `tasks/tasks_1.md` | Week 1 — Fahasa features, Laravel envelope, Axios, base inputs |
| `tasks/tasks_2.md` | Week 2 — Login and register with Formik |
| `tasks/tasks_3.md` | Week 3 — Home page and book list |
| `tasks/tasks_4.md` | Week 4 — Admin book create, edit, delete |
| `tasks/tasks_5.md` | Week 5 — Book detail and cart |
| `tasks/tasks_6.md` | Week 6 — Place order and order detail |
| `task_1/notes_week1.md` | Your notes (you create one file per week) |
| `../book_store/` | `api/` and `web/` |
| `../book_store/README_api.md` | API layout |
| `../book_store/README_web.md` | Web layout |
| `../laravel/task_1/` | Response and error code to copy from |

Book create, edit, and delete are week 4. An admin order list is not in these weeks.

---

## Prerequisites

- `../laravel/tasks_7.md` done (`php artisan test` green there)
- `../react/tasks_3.md` done. Skip `../react/tasks_4.md`. That work is `tasks/tasks_2.md` and `tasks/tasks_4.md` here.

---

## Setup

Read `../book_store/README.md` before Exercise 3 in `tasks/tasks_1.md`. Create the `book_store` database. Do not reuse `internship_bookstore`.

---

## API shape (same as the Laravel module)

**Health** — no envelope:

```json
{ "status": "OK" }
```

**Other successful calls:**

```json
{
  "status": 200,
  "message": "OK",
  "data": {}
}
```

**Errors:**

```json
{
  "status": 400,
  "message": "The given data was invalid.",
  "errors": {
    "code": "BAD_REQUEST",
    "fields": { "email": ["The email field is required."] }
  }
}
```

Codes: `BAD_REQUEST` (400), `UNAUTHORIZED` (401), `FORBIDDEN` (403), `NOT_FOUND` (404).

Book fields today, from `BookResource`: `id`, `title`, `author`, `price`, `stock_qty`, `published_year`.

---

## Rules

- Write notes in `task_1/notes_weekN.md` for the week you are on
- Put code in `../book_store/api` and `../book_store/web`
- Follow `../laravel/task_1/` for `ResponseData` and `ApiErrorRenderer`
- Do not commit `.env`
- Do not put Fahasa images, product text, or the Fahasa logo in the repo

---

## Submission

- `task_1/notes_week1.md`
- Checklist in `tasks/tasks_1.md`
- PR when your trainer asks
