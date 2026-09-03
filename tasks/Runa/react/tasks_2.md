# React Tasks 2 — Week 2 (September): Components, Hooks, Routing

**Duration:** ~20 hours · **Prerequisite:** `tasks_1.md` complete.

Continue in `task_1/`.

**Goal:** Add search/filter UI, a book detail page, and client-side routing.

```text
/books          → list + filters
/books/:id      → single book + order items
```

---

## Blocks overview

| Block | Exercises | Focus                              | ~Hours |
| ----- | --------- | ---------------------------------- | ------ |
| A     | 1–2       | React Router, layout, book detail  | 5      |
| B     | 3–4       | Filter UI + API query params       | 5      |
| C     | 5         | Order items on detail page         | 3      |
| D     | 6–7       | Hook notes + checklist             | 7      |

---

## Rules (this week)

- Keep week-1 book list working — refactor into pages, do not delete features.
- Install **React Router v6+** — use `createBrowserRouter` or `<BrowserRouter>` (pick one, stay consistent).
- Filters must hit the **real API** (`?author=`, `?min_price=`, `?max_price=`) — do not filter only in the browser.
- Still no auth — admin buttons come in week 4.

---

## Install

```bash
cd tasks/Runa/react/task_1
npm install react-router-dom
```

---

## Target layout (new / moved files)

```text
src/
├── pages/
│   ├── BooksPage.tsx
│   └── BookDetailPage.tsx
├── components/
│   ├── books/
│   │   ├── BookFilters.tsx
│   │   ├── BookCard.tsx
│   │   └── BookList.tsx
│   └── layout/
│       ├── AppLayout.tsx
│       └── NavLink.tsx          # optional wrapper
├── hooks/
│   └── useBooks.ts              # fetch list with filter params
├── routes/
│   └── index.tsx                # route definitions
└── App.tsx                      # router provider
```

---

## Exercise 1: Routes and pages

1. **`/`** — redirect to `/books`.
2. **`/books`** — `BooksPage` with list + filters.
3. **`/books/:id`** — `BookDetailPage`.

Wrap routes in `AppLayout` (shared header/footer).

4. Add navigation link **Books** in the header.
5. Each `BookCard` links to `/books/{id}` (React Router `Link`).

Test: click a book → URL changes → detail page loads.

---

## Exercise 2: Book detail page

1. Read `id` from URL with `useParams()`.
2. `GET ${API_URL}/books/{id}` — expect envelope with single object in `data`.
3. Show all book fields. `404`-style error from API → friendly **Book not found** message.
4. **Back to list** link.

```bash
curl -s http://127.0.0.1:8000/api/books/1
curl -s http://127.0.0.1:8000/api/books/9999
```

Add loading state (reuse pattern from week 1).

---

## Exercise 3: Filter form

Create `BookFilters.tsx` with controlled inputs:

| Field       | Maps to query param |
| ----------- | ------------------- |
| Author      | `author`            |
| Min price   | `min_price`         |
| Max price   | `max_price`         |

- **Apply** button (or filter on blur/Enter — pick one).
- **Clear** button resets filters and reloads full list.

Use local state for input values; pass built query string to the fetch function.

Verify in Network tab:

```bash
curl -s "http://127.0.0.1:8000/api/books?author=Martin"
curl -s "http://127.0.0.1:8000/api/books?min_price=2000&max_price=5000"
```

---

## Exercise 4: `useBooks` hook

Move fetch logic from `App.tsx` into `useBooks.ts`:

```ts
// Example shape — adjust to your style
function useBooks(filters: BookFilters) {
  // returns { books, loading, error, refetch }
}
```

Use `useCallback` for the fetch function and `useEffect` to refetch when filters change.

Use **`useMemo`** at least once on this page — e.g. derived count of filtered books, or a sorted copy of the list. If you skip it, write in `notes_hooks.md` why it was not needed.

Router hooks count too — document **`useParams`** on the detail page.

---

## Exercise 5: Order items on detail page

Below book info, fetch **`GET /api/books/{id}/order-items`**.

Show a simple table or list. Typical fields from Laravel `OrderItemResource`:

| Column     | Field        |
| ---------- | ------------ |
| Quantity   | `quantity`   |
| Unit price | `unit_price` |

(`book_id` is the same for every row on this page — optional to show.)

Empty `data` → **No orders for this book yet**.

Check the real response first:

```bash
curl -s http://127.0.0.1:8000/api/books/1/order-items
```

---

## Exercise 6: Update hook notes

Append to `notes_hooks.md` (same table as week 1). Add rows for every hook you used this week, at minimum:

| Hook          | Expected usage                          |
| ------------- | --------------------------------------- |
| `useCallback` | stable fetch function in `useBooks`     |
| `useEffect`   | refetch when filters change             |
| `useMemo`     | derived list or count (or note why skipped) |
| `useParams`   | read book `id` on detail page           |
| custom hook   | `useBooks` — what it returns            |

Optional rows if you did the stretch: `useSearchParams`, extra `useEffect` for debounce.

---

## Exercise 7: Checklist

**Manual checklist:**

| #   | Check                                           | OK? |
| --- | ----------------------------------------------- | --- |
| 1   | `/books` shows filtered results from API        |     |
| 2   | Clear filters restores full list                |     |
| 3   | `/books/1` shows correct book                   |     |
| 4   | Invalid id shows not-found UI                   |     |
| 5   | Browser back/forward works between list/detail  |     |
| 6   | Order items section loads on detail page        |     |

---

## Optional stretch

- Sync filters to URL search params (`useSearchParams`) so refresh keeps filters.
- Debounce author input (~300 ms) with `useEffect` + timeout.
- shadcn `Input` and `Button` on the filter form.

---

## Submission

- [ ] React Router wired; `BooksPage`, `BookDetailPage`
- [ ] `BookFilters`, `useBooks` hook
- [ ] Order items on detail page
- [ ] `notes_hooks.md` updated for week 2 hooks
- [ ] Checklist above completed

---

## Next week

`tasks_3.md` — Axios, Zustand, login/register, protected routes.
