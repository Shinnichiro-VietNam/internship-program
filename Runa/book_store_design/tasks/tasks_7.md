# Book Store Design Tasks 7 — Week 7: Admin layout, Book management list, Add and edit book UI

**Duration:** ~25 hours · **Prerequisite:** `tasks_6.md` complete. `GET /api/books` and `GET /api/books/{book}` work. The cart drawer and `/cart` work.

This week opens the admin side. A logged-in user gets an admin area with its own layout, a book table that reads the real list API, and the add and edit forms. Saving a book (`POST`, `PUT`), deleting, and the `admin` role are week 8. Placing an order is also later.

Continue in `../../book_store/`. Write `../task_1/notes_week7.md`.

**UI reference:** Bookory has no admin. Use the same theme colors from week 4 (`index.css`) on a plain admin frame: dark sidebar on the left, white top bar, light gray content area. Keep it simple and readable. No admin template files copied into the repo.

```text
Header “Admin” link → /admin            → AdminLayout → DashboardPage
                      /admin/books      → AdminBooksPage → Book.index() → table
                      /admin/books/new  → BookCreatePage → BookForm (no save yet)
                      /admin/books/:id/edit → BookEditPage → Book.show(id) → BookForm (no save yet)
```

---

## Blocks overview

| Block | Exercise | Task | ~Hours |
| ----- | -------- | ---- | ------ |
| A | 1–2 | Create UI Layout Admin | 10 |
| B | 3 | Create UI list Book Management | 5 |
| C | 4 | Integrate API list book | 5 |
| D | 5–6 | Create UI Add + Edit Book | 5 |

---

## Rules (this week)

- Follow `../../book_store/README_web.md`. Pages call `Book`. They do not import Axios.
- One component per file. Admin-only pieces go in `web/src/components/admin/`. Admin pages go in `web/src/pages/admin/`.
- Every `/admin` route sits inside `RequireAuth`. A guest is sent to `/login`. Any logged-in user can open the admin this week. The `admin` role check is week 8.
- Reuse `Button`, `Input`, `Select`, `StockBadge`, `EmptyState`, `ErrorState`, `Pagination`, `formatPrice`.
- `BookForm` submits are UI only this week. No `POST /api/books` or `PUT /api/books/{id}` exist yet.
- The public site (`/`, `/books/:id`, `/cart`) does not change.

---

## Exercise 1: Admin frame (Block A)

### 1.1 `web/src/components/admin/AdminLayout.tsx`

Three areas. `Outlet` in the content area.

| Area | Content |
| ---- | ------- |
| Sidebar | Dark background, fixed on the left, about 16rem wide. Store name on top as a link to `/admin`. Menu below |
| Top bar | White, thin bottom border. Left: a page title slot. Right: “View store” link to `/`, the user’s name, and a “Logout” button that calls `Auth.logout()` then clears the store and goes to `/login` |
| Content | Light gray background, padding, max width about 72rem centered |

Small screens: the sidebar is hidden and a hamburger button in the top bar opens it over the content with a dark overlay, same idea as `CartDrawer`. Close with ×, overlay click, or Escape.

### 1.2 `web/src/components/admin/SidebarLink.tsx`

Props: `to`, `icon` (inline SVG as a React node), `label`. Uses `NavLink`. Active item: accent color bar on the left and lighter background.

Menu items this week:

| Label | To |
| ----- | -- |
| Dashboard | `/admin` |
| Books | `/admin/books` |
| Orders | `/admin/orders`, disabled, gray, small text “Later” |

### 1.3 Routes and header link

| Path | Page |
| ---- | ---- |
| `/admin` | `DashboardPage` |
| `/admin/books` | `AdminBooksPage` |
| `/admin/books/new` | `BookCreatePage` |
| `/admin/books/:id/edit` | `BookEditPage` |

All inside `RequireAuth` and `AdminLayout`. `AdminLayout` does not use `AppLayout`. The public header, footer, and cart drawer are not rendered in the admin.

In `AppLayout`, the header’s account area gets an “Admin” link to `/admin` when `useAuthStore` has a user.

---

## Exercise 2: Shared admin pieces and dashboard (Block A)

### 2.1 Components

| Component | Props | Shows |
| --------- | ----- | ----- |
| `admin/PageHeader.tsx` | `title`, `description?`, `action?` | Title as `h1`, gray one-line description, an action slot on the right (for “Add book”) |
| `admin/StatCard.tsx` | `label`, `value`, `hint?` | White card, thin border, small gray label, large value, small hint |
| `admin/DataTable.tsx` | `columns: { key, header, align? }[]`, `children` | A styled `<table>`: header row in small uppercase gray, zebra rows, hover highlight, horizontal scroll on small screens. Rows are passed as children so each page controls its cells |

### 2.2 `pages/admin/DashboardPage.tsx`

- `PageHeader` “Dashboard” with the description “Overview of your store”
- Three `StatCard`: “Books” (filled in Exercise 4 from `total`), “Out of stock” (count from the first page, note that it is a partial count), “Orders” with value “—” and hint “Later”
- Under the cards, a short card “Quick links”: Add a book, Manage books, View store

Until Exercise 4, the two book cards show “—”.

### 2.3 `/dev/ui`

Add an “Admin” section: `PageHeader` with an action button, three `StatCard`, and a `DataTable` with two static rows.

---

## Exercise 3: Book management table, UI only (Block B)

`pages/admin/AdminBooksPage.tsx`

- `PageHeader` “Books” with description “All books in the store” and an action `Button` “Add book” linking to `/admin/books/new`
- Toolbar above the table: a search `Input` with placeholder “Search by title...” and a `Button` secondary “Clear”. UI only in this block
- `DataTable` columns:

| Column | Cell |
| ------ | ---- |
| ID | `book.id`, gray |
| Title | Bold. Under it the author in gray |
| Price | `formatPrice`, right aligned |
| Stock | `StockBadge` and the number |
| Published | Year or “—” |
| Actions | `Button` secondary small “Edit” linking to `/admin/books/:id/edit`. `Button` secondary small “Delete”, disabled, title “Week 8” |

- Under the table: `Pagination` and a line “Showing 1–15 of 42”
- Three states on the table body: skeleton rows (5 gray rows), `EmptyState` “No books yet” with an “Add book” action, `ErrorState` with Retry

For this block, the page renders from an inline array of three `Book` objects at the top of the file. It is removed in Exercise 4.

Check the page at a phone width: the table scrolls sideways, the header action stays visible.

---

## Exercise 4: Table on `Book.index()` (Block C)

Same pattern as the home page in week 5. `title` and `page` live in the URL.

- `useSearchParams` for `title` and `page`. Default page 1
- One `useEffect` keyed on `[title, page]`. `Book.index<ApiSuccess<BookListData>>({ title, page, per_page: 15 })`
- Status `"loading" | "error" | "empty" | "ready"` drives the table body
- Search: submit writes `title` into the URL and resets `page` to 1. Clear removes `title`
- `Pagination.onChange` writes `page`. “Showing a–b of total” comes from `current_page`, `per_page`, `total`
- Remove the inline array

Dashboard: `DashboardPage` calls `Book.index({ per_page: 1 })` once and reads `total` for the “Books” card. For “Out of stock”, call `Book.index({ per_page: 50 })` once and count `stock_qty === 0` on that page. Write in the notes why this count is not exact and what API change would make it exact.

Request count: open `/admin/books`, search once, go to page 2. Exactly three `GET /api/books`. Write the number you saw.

```bash
curl -s "http://127.0.0.1:8000/api/books?page=1&per_page=15"
curl -s "http://127.0.0.1:8000/api/books?title=the&page=1&per_page=15"
```

---

## Exercise 5: `BookForm` (Block D)

`web/src/pages/admin/BookForm.tsx`. Formik + Yup, same pieces as the login form.

Props: `initialValues`, `onSubmit`, `submitLabel`, `submitting?`.

| Field | Component | Yup |
| ----- | --------- | --- |
| `title` | `Input` | required string, max 255 |
| `author` | `Input` | required string, max 255 |
| `price` | `Input type="number"` | required number, > 0 |
| `stock_qty` | `Input type="number"` | required integer, >= 0 |
| `published_year` | `Input type="number"` | optional integer between 1000 and the current year. Empty becomes `null` |

- Two columns on wide screens: title and author full width, price and stock side by side, published year half width
- Yup messages under each field. Red border on error
- A footer row: `Button` “Cancel” secondary linking to `/admin/books`, and the submit `Button` with `submitLabel`. Submit disabled while `isSubmitting`
- A slot above the fields for a form-level error box (used in week 8 for 400 and 403)

Add the form to `/dev/ui` with empty values. Submitting there logs the values to the console.

---

## Exercise 6: Create and edit pages (Block D)

| Route | Page | Behavior this week |
| ----- | ---- | ------------------ |
| `/admin/books/new` | `BookCreatePage.tsx` | `PageHeader` “Add book”. Empty `BookForm`, `submitLabel` “Create book”. On submit: `console.log(values)`, show a green banner “Preview only. Saving arrives in week 8.”, stay on the page |
| `/admin/books/:id/edit` | `BookEditPage.tsx` | `PageHeader` “Edit book”. Load with `Book.show(id)`. Skeleton while loading. 404 → `EmptyState` “Book not found” with a link to `/admin/books`. Then `BookForm` with the book as `initialValues`, `submitLabel` “Save changes”. Same preview banner on submit |

`BookEditPage` converts `published_year` `null` to `""` for the form and back to `null` on submit. Write the two lines that do it in the notes.

Breadcrumb in the `PageHeader` description: “Books / Add book” and “Books / <title>”.

---

## Test checklist (`notes_week7.md`)

| # | Check | Expect |
| - | ----- | ------ |
| 1 | Guest opens `/admin` | redirect to `/login` |
| 2 | Login, click “Admin” in the header | `/admin`, dark sidebar, top bar with the name, no store header or footer |
| 3 | Dashboard cards | “Books” equals `total` from the API, “Orders” shows “—” |
| 4 | Sidebar at phone width | hidden, hamburger opens it, Escape closes it |
| 5 | `/admin/books` | skeleton rows, then 15 rows, “Showing 1–15 of N” |
| 6 | Search “the” | only matching rows, URL has `?title=the` |
| 7 | Page 2, reload | still page 2 |
| 8 | Stop the API, reload the table | error and Retry |
| 9 | Open `/admin/books`, search, page 2 | exactly 3 requests |
| 10 | “Add book” with an empty title | Yup error, no console log |
| 11 | Valid “Add book” | values in the console, green preview banner |
| 12 | “Edit” on a row | form prefilled with that book, year empty when `null` |
| 13 | `/admin/books/999999/edit` | “Book not found” |
| 14 | “Delete” button | disabled |
| 15 | “View store” | `/` with the header, cart drawer still works |
| 16 | `/dev/ui` | admin section and `BookForm` render |

---

## Docs

- [React Router — NavLink, nested routes](https://reactrouter.com/)
- [Formik](https://formik.org/docs/overview), [Yup](https://github.com/jquense/yup)
- [Tailwind — table](https://tailwindcss.com/docs/table-layout), [overflow](https://tailwindcss.com/docs/overflow)
- Layout: `../../book_store/README_web.md`

---

## Submission

- [ ] `AdminLayout`, `SidebarLink`, `PageHeader`, `StatCard`, `DataTable`, `/admin` routes under `RequireAuth`
- [ ] `AdminBooksPage` on `Book.index()` with URL search and page, dashboard counts
- [ ] `BookForm`, `BookCreatePage`, `BookEditPage` with `Book.show` prefill, preview-only submit
- [ ] `notes_week7.md` with the request count, the year conversion, and the checklist
- [ ] `.env` not committed

---

## Next

Week 8 — `users.role`, `BookPolicy` for create, update, delete; `POST`, `PUT`, `DELETE /api/books`; `BookForm` saves for real; delete with a confirm dialog and the 403 message.
