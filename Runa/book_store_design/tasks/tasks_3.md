# Book Store Design Tasks 3 — Week 3: Home page

**Duration:** ~24 hours · **Prerequisite:** `tasks_2.md` complete. Login works.

Continue in `../../book_store/`. Write `../task_1/notes_week3.md`.

The home page lists books from this API. A card shows title, author, price, and stock. Cover images, sale prices, and categories wait until those fields exist.

```text
Home → Book.index({ page: 1 }) → GET /api/books → cards
Search → Book.index({ title, page: 1 })
```

---

## Blocks overview

| Block | Exercises | Focus | ~Hours |
| ----- | --------- | ----- | ------ |
| A | 1–2 | Books table and list endpoint | 8 |
| B | 3–4 | Home layout and book cards | 10 |
| C | 5 | Search, loading, empty, errors | 6 |

---

## Rules (this week)

- Follow `../../book_store/README_api.md`. The list is a Query. Each filter is its own class. The controller does not write `where`.
- Follow `../../book_store/README_web.md`. The page calls `Book.index()`. It does not import Axios.
- `GET /api/books` is public. `BookPolicy::viewAny` returns true.
- Reuse `Button` and `Input`. Cards go in `web/src/components/BookCard.tsx`.
- Banner is a solid block or an image you made. No Fahasa art.
- A card links to `/books/:id`. That page can be a placeholder until week 4.
- No cart behavior this week.

---

## Book JSON

One book:

```json
{
  "id": 1,
  "title": "Example",
  "author": "Author",
  "price": 1500,
  "stock_qty": 12,
  "published_year": 2020
}
```

List body (`data`):

```json
{
  "items": [],
  "current_page": 1,
  "last_page": 1,
  "per_page": 8,
  "total": 8
}
```

Query parameters:

| Param | Meaning |
| ----- | ------- |
| `title` | partial match, `FilterBooksByTitle` |
| `author` | partial match, `FilterBooksByAuthor` |
| `min_price`, `max_price` | inclusive bounds, one filter class each |
| `page`, `per_page` | `per_page` max 50, default 8 |

---

## Exercise 1: Books table and seed

Create `books` in the `book_store` database. Columns match `../../laravel/task_1/database/migrations/0001_01_01_000008_create_books_table.php`: `book_id`, `title`, `author`, `price` > 0, `stock_qty` >= 0, nullable `published_year`.

`Book` model: primary key `book_id`, no timestamps, those fields fillable.

Seed at least 8 books. Include one with `stock_qty` 0.

---

## Exercise 2: `GET /api/books`

| Class | Job |
| ----- | --- |
| `Queries/Book/ListBooksQuery` | Apply the filter classes, paginate |
| `Queries/Book/Filter/FilterBooksByTitle` | `title` like |
| `Queries/Book/Filter/FilterBooksByAuthor` | `author` like |
| `Queries/Book/Filter/FilterBooksByMinPrice` | `price` >= |
| `Queries/Book/Filter/FilterBooksByMaxPrice` | `price` <= |
| `Http/Resources/Book/BookResource` | fields above. `book_id` becomes `id` |
| `Http/Controllers/BookController@index` | `authorize('viewAny')`, return `httpOk` with the page payload |
| `Policies/BookPolicy` | `viewAny` and `view` are public |

A blank filter value does not add a `where`.

```bash
curl -s "http://127.0.0.1:8000/api/books?page=1&per_page=8"
curl -s "http://127.0.0.1:8000/api/books?title=the"
```

Leave `GET /api/books/{book}` for week 4.

---

## Exercise 3: Home layout

Replace the week 2 welcome on `/` with the store home. Keep `AppLayout`.

`web/src/pages/home/HomePage.tsx`

`web/src/models/Book.ts` extends `BaseModel` with `baseUrl = "books"`. `Book.index()` is the list call.

Sections, top to bottom:

1. Banner — one line of your own headline
2. Book grid from `Book.index({ page: 1, per_page: 8 })`
3. A next-page control when `current_page` < `last_page`

Each card shows title, author, price, and stock (`In stock` or `Out of stock`). The card links to `/books/:id`. Format the price in `web/src/helper/format.ts`.

Read `response.data.data.items`.

---

## Exercise 4: Types

`web/src/types/book.ts` matches `BookResource`. Add a list type for `items` plus `current_page`, `last_page`, `per_page`, and `total`.

The home page calls `Book.index` in one place. `BookCard` receives a `Book` prop. It does not fetch.

---

## Exercise 5: Search, loading, empty, error

- Header search submits a title and calls `Book.index({ title, page: 1, per_page: 8 })`.
- While the request runs, the grid area shows a loading state.
- `items` empty → a short empty message.
- Failure → the string from `helper/errors.ts`, and a retry button.
- Clearing the search loads page 1 with no title filter.

---

## Test checklist (`notes_week3.md`)

| # | Check | Expect |
| - | ----- | ------ |
| 1 | `GET /api/books?page=1` | 200, `data.items` is an array |
| 2 | `GET /api/books?title=` a known word | only matching titles |
| 3 | Home, logged out | grid visible, header shows Login |
| 4 | Home while books load | loading state, then cards |
| 5 | Title search with no match | empty message |
| 6 | Stop the API and reload home | error message and retry |
| 7 | Login from week 2 | still works |

---

## Docs

- Layout: `../../book_store/README_api.md`, `../../book_store/README_web.md`
- Column rules: `../../laravel/task_1/database/migrations/0001_01_01_000008_create_books_table.php`

---

## Submission

- [ ] Public `GET /api/books` with title, author, and price filters
- [ ] Home grid, search, loading, empty, and error
- [ ] `notes_week3.md` checklist
- [ ] No Fahasa images in `web/`

---

## Next

`tasks_4.md` — Book detail and the cart.
