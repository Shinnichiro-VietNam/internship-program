# Book Store Design

**Duration:** Weeks 1–3, 28 hours each. Weeks 4–7, 25 hours each. Nothing runs past the week’s hours.

Tasks for the bookstore in `../book_store/`. Week 1 is the Fahasa feature list and the shared setup. Week 2 teaches Formik on login and register. Week 3 is the book list API. Weeks 4–6 build the screens on the [Bookory](https://demo2.pavothemes.com/bookory/home-5/) look: login and register, home page, book detail, cart drawer, and view cart page. Week 7 opens the admin side: layout, book table, add and edit forms. Saving books, roles, and placing an order come after week 7.

**UI reference:** Fahasa for *which* features exist. Bookory for *how it looks*. Take layout and color roles from Bookory, never its images, fonts, icons, names, or logo.

**AI tools:** Allowed. The Fahasa and Bookory notes have to come from pages you opened. In review you walk through the feature list and the error JSON yourself.

---

## Files

| File | Purpose |
| ---- | ------- |
| `README.md` | This guide |
| `tasks/tasks_1.md` | Week 1 — Fahasa features, Laravel envelope, Axios, base inputs |
| `tasks/tasks_2.md` | Week 2 — Login and register with Formik |
| `tasks/tasks_3.md` | Week 3 — Book list API (`GET /api/books`, filters, pagination) |
| `tasks/tasks_4.md` | Week 4 — Login UI (6h), Register UI (8h), Home page UI (11h) |
| `tasks/tasks_5.md` | Week 5 — Home page UI finish (9h), Home page API (8h), Book detail UI (8h) |
| `tasks/tasks_6.md` | Week 6 — Book detail UI finish (4h), Book detail API (7h), Shopping cart: store, drawer, view cart page (14h) |
| `tasks/task_7.md` | Week 7 — Admin layout (10h), Book management table UI (5h), table on the list API (5h), Add and edit book forms UI (5h) |
| `task_1/notes_week1.md` | Your notes (you create one file per week) |
| `../book_store/` | `api/` and `web/` |
| `../book_store/README_api.md` | API layout |
| `../book_store/README_web.md` | Web layout |
| `../laravel/task_1/` | Response and error code to copy from |

Saving a book (`POST`, `PUT`, `DELETE /api/books`), the `admin` role, placing an order (`POST /api/orders`), and the order detail page are not in these seven weeks. They follow as week 8 and later.

---

## Prerequisites

- `../laravel/tasks_7.md` done (`php artisan test` green there)
- `../react/tasks_3.md` done. Skip `../react/tasks_4.md`. The form work from that module is `tasks/tasks_2.md` here; the CRUD part comes with the admin screens after week 6.

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
