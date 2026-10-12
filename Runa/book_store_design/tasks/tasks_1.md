# Book Store Design Tasks 1 — Week 1: Fahasa features and shared setup

**Duration:** ~28 hours · **Prerequisite:** `../../laravel/tasks_7.md` and `../../react/tasks_3.md` done.

Write `../task_1/notes_week1.md`. Code goes in `../../book_store/api` and `../../book_store/web`.

Selling site to study: [https://www.fahasa.com/](https://www.fahasa.com/)

Fahasa has no public admin. You write the admin screen list yourself.

---

## Blocks overview

| Block | Exercises | Focus | ~Hours |
| ----- | --------- | ----- | ------ |
| A | 1–2 | Fahasa pages, feature list, admin screens | 8 |
| B | 3–4 | Laravel app and error JSON | 8 |
| C | 5 | Axios, errors, types | 6 |
| D | 6–7 | Button, Input, Select, DateInput | 6 |

---

## Rules (this week)

- Open the Fahasa pages in a browser for Exercises 1 and 2.
- Error JSON matches `../../laravel/task_1/` (`ResponseData`, `ApiErrorRenderer`). Same field names.
- Frontend: Vite, React, TypeScript, Tailwind CSS.
- Folder layout: `../../book_store/README_api.md` and `../../book_store/README_web.md`.
- One component per file in `web/src/components/`.
- Login, home, book detail, and cart are later weeks.
- No Fahasa images, product blurbs, or logo in the repo.

---

## Exercise 1: Selling-site pages

Browse [fahasa.com](https://www.fahasa.com/). In `notes_week1.md`, one row per page.

| Page | What to write down |
| ---- | ------------------ |
| Home | Header, search, cart, account, banner, name of each product block |
| All products, or one category | Filters, sort, fields on a card (price, discount, stock) |
| One product | Price, quantity, add to cart, description |
| Search | Run one query. Note the result page |
| Cart | Empty cart. A line with a book, if you can add one without paying |
| Login and register | Field names only. Do not submit the form |
| Footer account links | Order history, address, account. Which ones send you to login |

Columns: path, what the page is for, actions on the page, data it needs (books, cart, user, order).

---

## Exercise 2: Feature list and admin screens

**Selling site.** One feature per row.

| Feature | Where you saw it | Basic / Later / Out of scope | Why |
| ------- | ---------------- | ---------------------------- | --- |

- **Basic** — find a book, put it in a cart, place an order, open that order again. Login and register count as Basic.
- **Later** — discounts, reviews, admin-edited banners, anything else you would add after that path works.
- **Out of scope** — payment gateways, OTP, loyalty points, in-store pickup, wholesale, blog, store locator.

**Admin site.** Screens for one admin. Fahasa does not give you this UI.

| Screen | What the admin does | Selling page that fails if this is missing |
| ------ | ------------------- | ------------------------------------------ |

Cover books (create and edit), price, stock, and orders. Extra screens only if a Basic selling feature needs them.

**Gap against the current API.** Read `../../laravel/task_1/routes/api.php`. A book is `id`, `title`, `author`, `price`, `stock_qty`, `published_year`. `POST /api/orders` is admin-only.

| Need | Covered today? | What is missing |
| ---- | -------------- | --------------- |
| Book list and detail | | |
| Login and register | | |
| Cover, category, sale price | | |
| Cart | | |
| Customer places an order | | |

---

## Exercise 3: Laravel app

Read `../../book_store/README.md` and `../../book_store/README_api.md`. Delete `api/.gitkeep`, then from `Runa/book_store`:

```bash
composer create-project laravel/laravel api
cd api
php artisan serve
```

Database name: `book_store`. Leave `internship_bookstore` alone.

```env
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=book_store
DB_USERNAME=root
DB_PASSWORD=your_password
```

```sql
CREATE DATABASE IF NOT EXISTS book_store CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

No book, order, or customer migrations this week. Do not commit `.env`.

`GET /api/health`:

```json
{ "status": "OK" }
```

---

## Exercise 4: Error JSON

Copy the pattern from these files in `../../laravel/task_1/`:

- `app/Http/Responses/ResponseData.php`
- `app/Http/Responses/ApiErrorRenderer.php`
- `bootstrap/app.php` (renders for `api/*`)
- `app/Traits/HandleResponse.php`

Success:

```json
{
  "status": 200,
  "message": "OK",
  "data": {}
}
```

Error:

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

Handle `BAD_REQUEST` (400), `UNAUTHORIZED` (401), `FORBIDDEN` (403), `NOT_FOUND` (404).

```bash
curl -s -i http://127.0.0.1:8000/api/does-not-exist
```

Expect HTTP 404 and `errors.code` = `NOT_FOUND`.

In `config/cors.php`, allow `http://localhost:5173`.

In `notes_week1.md`, list the files you added.

---

## Exercise 5: Axios, errors, types

Delete `web/.gitkeep`, then from `Runa/book_store`:

```bash
npm create vite@latest web -- --template react-ts
cd web
npm install
npm install axios react-router-dom zustand
npm install tailwindcss @tailwindcss/vite
```

Use the Tailwind + Vite steps from the Tailwind docs if those install flags differ.

`web/.env`:

```env
VITE_API_URL=http://127.0.0.1:8000/api
```

Do not commit `.env`.

Follow `../../book_store/README_web.md`. This week, add these files:

```text
web/src/
├── plugins/axios.ts       # single Axios instance
├── models/BaseModel.ts    # index, show, store, update, destroy
├── helper/errors.ts       # message and field errors from a failed response
├── stores/authStore.ts    # Zustand useAuthStore, token in localStorage key token
├── types/api.ts           # ApiSuccess<T>, ApiErrorBody
└── types/book.ts          # id, title, author, price, stock_qty, published_year
```

`plugins/axios.ts`:

- `baseURL` is `import.meta.env.VITE_API_URL`
- If `useAuthStore.getState().token` is set, send `Authorization: Bearer {token}`
- On 401, call `setToken(null)`. No redirect yet

`helper/errors.ts` returns:

- `message` when the body has one
- `fields` when `errors.fields` is present
- a fixed fallback string when the body is empty

`Book.price` and `Book.stock_qty` are numbers, same as `BookResource`.

The preview page in Exercise 6 calls `GET /api/health` through the Axios instance and shows `OK` or the string from `helper/errors.ts`. Health is not a `BaseModel` call.

---

## Exercise 6: Shared inputs

Under `web/src/components/`, Tailwind for styling. Route file: `web/src/router/routes.tsx`.

| Component | Behavior |
| --------- | -------- |
| `Button.tsx` | `type` (`button` or `submit`), variants `primary` and `secondary`, `disabled`, `children` |
| `Input.tsx` | `label`, `error` string, plus `type`, `value`, `onChange`, `name` |
| `Select.tsx` | `label`, `error`, `options` (`{ value, label }[]`), `value`, `onChange` |
| `DateInput.tsx` | `label`, `error`, `value`, `onChange`, `name`. Renders `<input type="date">` |

`web/src/pages/UiPreviewPage.tsx`, route `/dev/ui`:

- Primary, secondary, and disabled primary buttons
- Input with an error string
- Select with two options
- Date input
- Health result from Exercise 5

---

## Exercise 7: Checklist

Put this at the end of `notes_week1.md`.

| # | Check | Done |
| - | ----- | ---- |
| 1 | Home, list, product, search, cart, login/register opened on Fahasa | |
| 2 | Each selling feature marked Basic, Later, or Out of scope | |
| 3 | Admin list includes books, price, stock, and orders | |
| 4 | `GET /api/health` returns `{"status":"OK"}` | |
| 5 | `GET /api/does-not-exist` returns 404 and `errors.code` `NOT_FOUND` | |
| 6 | `/dev/ui` shows the four inputs and the health result | |
| 7 | `.env` files are not committed | |

---

## Docs

- [Fahasa](https://www.fahasa.com/)
- Responses to follow: `../../laravel/task_1/app/Http/Responses/`
- [Axios instances](https://axios-http.com/docs/instance)
- [React Router](https://reactrouter.com/)

---

## Submission

- [ ] `book_store_design/task_1/notes_week1.md`
- [ ] `book_store/api` health route and error JSON
- [ ] `book_store/web` Axios client, types, and `/dev/ui`
- [ ] No login, home, or cart page

---

## Next

`tasks_2.md` — Login, register, and the app shell.
