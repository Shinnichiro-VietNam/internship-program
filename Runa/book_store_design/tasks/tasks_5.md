# Book Store Design Tasks 5 — Week 5: Home page UI, Home page API, Book detail UI

**Duration:** ~25 hours · **Prerequisite:** `tasks_4.md` complete. `/` shows the Bookory-style header, hero, 8 sample cards, and footer. `GET /api/books` works.

Finish the home page screens first, then replace the sample data with `Book.index()`. The last block is the book detail screen, UI only. `GET /api/books/{id}` and the cart are next week.

Continue in `../../book_store/`. Write `../task_1/notes_week5.md`.

**UI reference:** [Bookory — Home 5](https://demo2.pavothemes.com/bookory/home-5/) for the grid, and any [Bookory product page](https://demo2.pavothemes.com/bookory/product/the-girl-and-the-last-sleepover/) for the detail layout. Same rule as week 4: take the layout and the color roles, not files, names, or the Bookory logo.

```text
Header search → /?title=x        → HomePage reads useSearchParams
HomePage      → Book.index({ title, page, per_page: 8 }) → GET /api/books → BookGrid
BookCard      → /books/:id       → BookDetailPage (sample data this week)
```

---

## Blocks overview

| Block | Exercise | Task | ~Hours |
| ----- | -------- | ---- | ------ |
| A | 1–2 | Create UI HomePage (finish) | 9 |
| B | 3–4 | Integrate API HomePage | 8 |
| C | 5–6 | Create UI Book Detail | 8 |

---

## Bookory reference (product page)

Open one product page and write a row in `notes_week5.md`.

| Part | Bookory | This week |
| ---- | ------- | --------- |
| Breadcrumb | “HOME → CATEGORY → TITLE”, small uppercase, last item in the accent color | “Home → <title>”. No categories yet |
| Two cards | Left: cover image with zoom icon. Right: details | Left: cover block. Right: details. White, rounded, thin border |
| Stock badge | Green “IN STOCK” | Green “In stock” or red “Out of stock” |
| Title | Large `h1` | Same |
| Meta line | “Author: X \| ★★★★ 5 \| SKU: …” | “Author: X \| Published: 2020”. No rating, no SKU |
| Price | Large, accent color | Same, `formatPrice` |
| Short text | Lorem description | “No description yet.” |
| Format radios | Audio / Ebook / … | Skip |
| Quantity | “− 1 +” pill | `QuantityInput` |
| Add to cart | Accent pill button, wishlist beside it | Accent pill, disabled this week. No wishlist |
| Tabs | Description / Additional information / Reviews | Description / Details. No reviews |
| Related products | Row of cards | 4 `BookCard` from the sample list |

---

## Rules (this week)

- Follow `../../book_store/README_web.md`. The page calls `Book.index()`. It does not import Axios.
- One component per file. `BookCard` does not fetch.
- Search and page live in the URL (`?title=&page=`), not only in component state. Reload keeps the same list.
- The detail page does not call the API this week. No cart behavior. “Add to cart” is disabled.
- Covers stay solid color blocks. No image, font, or icon files copied from Bookory.

---

## Exercise 1: Grid states (Block A)

The grid area on `/` has four states. Build each as a component and preview all four on `/dev/ui`.

| Component | Shows |
| --------- | ----- |
| `components/BookCardSkeleton.tsx` | Gray blocks in the shape of `BookCard`: tall cover, two text lines, price line. Tailwind `animate-pulse` |
| `components/EmptyState.tsx` | Props `message`, optional `action` (a link or `Button`). Centered text on a light gray rounded panel |
| `components/ErrorState.tsx` | Props `message`, `onRetry`. The message in red and a `Button` “Retry” |
| `components/BookGrid.tsx` | Props `books`, `status`, `errorMessage`, `onRetry`. Renders 8 skeletons, or `EmptyState`, or `ErrorState`, or the cards in the same 2 / 3 / 5 column grid as week 4 |

`status` is `"loading" | "error" | "empty" | "ready"`.

`/dev/ui` gets a “Grid states” section with the four states one under another, using `sampleBooks`.

---

## Exercise 2: Pagination and search bar (Block A)

### 2.1 `components/Pagination.tsx`

Props: `currentPage`, `lastPage`, `onChange`.

- “Previous” and “Next” as `Button` secondary (white pill with border)
- Text between them: “Page 2 of 5”
- Previous disabled on page 1. Next disabled on the last page
- Hidden when `lastPage` is 1

Replace the disabled “Next page” button from week 4 with `Pagination`, centered under the grid.

### 2.2 Header search

The pill search in the week 4 header now submits.

- On submit, navigate to `/?title=<value>`. Empty value navigates to `/`
- When the URL has `title`, the input shows that value after a reload
- `HomePage` replaces the “Popular Books” section title with “Results for “<title>”” and shows a “Clear” link to `/` on the right where “View all” was
- Still sample data this week in Block A. Filter `sampleBooks` by title so the UI can be checked before Block B

---

## Exercise 3: `Book` model and types (Block B)

`web/src/models/Book.ts`:

```ts
import { BaseModel } from "./BaseModel";

export class Book extends BaseModel {
  static baseUrl = "books";
}
```

`web/src/types/book.ts` adds the list payload. It matches `BookController@index`:

```ts
export type BookListData = {
  items: Book[];
  current_page: number;
  last_page: number;
  per_page: number;
  total: number;
};
```

Call shape: `Book.index<ApiSuccess<BookListData>>({ title, page, per_page: 8 })`. The list is `response.data.items`.

Check the API first:

```bash
curl -s "http://127.0.0.1:8000/api/books?page=1&per_page=8"
curl -s "http://127.0.0.1:8000/api/books?title=the&page=1"
```

---

## Exercise 4: Wire the home page (Block B)

`HomePage.tsx` reads `title` and `page` from `useSearchParams`. Defaults: no title, page 1.

State on the page: `books`, `status`, `errorMessage`, `lastPage`, `total`.

- One `useEffect` keyed on `[title, page]`. It sets `status` to `"loading"`, calls `Book.index`, then sets `"ready"` or `"empty"`
- Failure: `status` `"error"`, `errorMessage` from `helper/errors.ts`. Retry runs the same call again
- `Pagination.onChange` writes `page` into the URL. The effect picks it up. Scroll to the top of the grid on change
- “Results for” line shows `total`: “12 results for “the””
- The hero and the sale strip stay. Only the grid changes
- Remove the `sampleBooks` import from `HomePage`. Keep the file for `/dev/ui` and Block C

Request count: open `/`, then search once, then go to page 2. The network tab shows exactly three `GET /api/books` calls. Write the number you saw in `notes_week5.md`, and what you changed if it was higher.

Edge cases:

| Case | Expected |
| ---- | -------- |
| `/?page=99` | API returns an empty page → `EmptyState` with a link to `/` |
| `/?title=zzzz` | `EmptyState` “No books match “zzzz”” and Clear |
| API stopped | `ErrorState`, Retry works after the API is back |
| Reload on `/?title=the&page=2` | same list, header input shows “the” |

---

## Exercise 5: Detail layout (Block C)

Move `pages/home/sampleBooks.ts` to `pages/books/sampleBooks.ts`. `/dev/ui` imports from the new path. This file is deleted next week when `Book.show` lands.

Route `/books/:id`, inside `AppLayout`. Page `web/src/pages/books/BookDetailPage.tsx`.

This week the page reads `id` from `useParams` and finds the book in `sampleBooks`. Unknown id → `EmptyState` “Book not found” with a link to `/`.

Layout, following the Bookory product page:

| Area | Content |
| ---- | ------- |
| Breadcrumb | Small uppercase: “Home → <title>”. Title in the accent color. Home links to `/` |
| Left card | White, rounded, thin gray border. Cover block, tall, same palette as `BookCard` |
| Right card | Same card style. Top: stock badge, green “In stock” or red “Out of stock”. `h1` title. Meta line: “Author: <author>” and “Published: <year or —>” separated by a thin vertical line. Price large in the accent color. One gray paragraph: “No description yet.” Quantity label and `QuantityInput`. `Button` “Add to cart”, accent, disabled this week |
| Tabs | Under the two cards. Two tabs: “Description” (the same paragraph) and “Details” (a two-column table: Author, Published year, Stock). Active tab underlined in the accent color. Local `useState` for the active tab |
| Related | Section header “Related books” like the home section header. 4 `BookCard` from `sampleBooks`, excluding the current book |

Two columns on wide screens, stacked on small.

---

## Exercise 6: Quantity control (Block C)

`components/QuantityInput.tsx`

Props: `value`, `min`, `max`, `onChange`, `disabled`.

- A pill with “−” and “+” buttons around a read-only number, like Bookory
- “−” disabled at `min`. “+” disabled at `max`
- On the detail page: `min` 1, `max` `stock_qty`. `stock_qty` 0 → the control and “Add to cart” are disabled and the quantity shows 0

Add the control to `/dev/ui` with `min` 1 and `max` 3.

In `notes_week5.md`, two sentences: where the quantity state lives, and why the detail page and not `QuantityInput` owns it.

---

## Test checklist (`notes_week5.md`)

| # | Check | Expect |
| - | ----- | ------ |
| 1 | `/dev/ui` | four grid states, pagination, quantity control render |
| 2 | Open `/` | hero, then skeletons, then cards from the API |
| 3 | `GET /api/books?title=the` vs the grid after searching “the” | same titles |
| 4 | Search with no match | empty panel and Clear |
| 5 | Go to page 2, reload | still page 2, Previous enabled |
| 6 | Stop the API, reload `/` | error and Retry. Start the API, Retry → cards |
| 7 | Open `/`, search, next page | exactly 3 requests in the network tab |
| 8 | Click a card | breadcrumb, two cards, title and price match the card |
| 9 | Switch tabs | Description and Details swap, underline moves |
| 10 | `/books/999999` | “Book not found” and a link to `/` |
| 11 | Detail of the `stock_qty` 0 book | red badge, quantity 0, controls disabled |
| 12 | Related books | 4 cards, current book not among them |
| 13 | Login and `/account` from week 2 | still work inside `AppLayout` |

---

## Docs

- [Bookory product page](https://demo2.pavothemes.com/bookory/product/the-girl-and-the-last-sleepover/)
- [React Router — useSearchParams, useParams](https://reactrouter.com/)
- [React — useEffect](https://react.dev/reference/react/useEffect)
- [Tailwind — animate-pulse](https://tailwindcss.com/docs/animation)
- Layout: `../../book_store/README_api.md`, `../../book_store/README_web.md`

---

## Submission

- [ ] `BookGrid` with skeleton, empty, error; `Pagination`; header search
- [ ] `models/Book.ts`, `BookListData`, home page on `Book.index()` with URL search and page
- [ ] `BookDetailPage` on sample data with breadcrumb, two cards, tabs, related books; `QuantityInput`
- [ ] `notes_week5.md` with the Bookory notes, request count, and checklist
- [ ] No image, font, or icon files copied from Bookory

---

## Next

`tasks_6.md` — `GET /api/books/{id}` on the detail page, then the cart.
