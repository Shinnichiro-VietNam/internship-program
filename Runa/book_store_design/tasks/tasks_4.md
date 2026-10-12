# Book Store Design Tasks 4 — Week 4: Book detail and cart

**Duration:** ~24 hours · **Prerequisite:** `tasks_3.md` complete. Home lists books.

Continue in `../../book_store/`. Write `../task_1/notes_week4.md`.

Open a book from the grid, then add it to a cart. The cart stays in the browser. Placing the order is week 5.

```text
Card → Book.show(id) → GET /api/books/{id}
        ↓
Add to cart → useCartStore → /cart
```

---

## Blocks overview

| Block | Exercises | Focus | ~Hours |
| ----- | --------- | ----- | ------ |
| A | 1 | `GET /api/books/{book}` | 4 |
| B | 2–3 | Detail page | 8 |
| C | 4–6 | Cart store and cart page | 12 |

---

## Rules (this week)

- Detail JSON matches `BookResource` from week 3.
- `GET /api/books/{book}` is public. Unknown id → 404 and `errors.code` = `NOT_FOUND`.
- The find is `Queries/Book/FindBookQuery`. The controller calls it and returns `BookResource`. No Eloquent in the controller.
- The page calls `Book.show(id)`.
- Cart lines are not saved on the server. A reload keeps them (`localStorage` key `cart`).
- Quantity cannot go above `stock_qty`. `stock_qty` 0 disables add.
- Do not call `POST /api/orders`. On `/cart`, a logged-in user sees a disabled “Place order” button. A guest sees a link to `/login`.

---

## Exercise 1: Book detail endpoint

`FindBookQuery::handle(int $id): ?Book`. Missing row returns null. The controller turns null into the week 1 not-found JSON.

`BookPolicy::view` stays public.

```bash
curl -s http://127.0.0.1:8000/api/books/1
curl -s -i http://127.0.0.1:8000/api/books/999999
```

Second call: HTTP 404, `errors.code` = `NOT_FOUND`.

---

## Exercise 2: Detail route

- Route `/books/:id`
- Page `web/src/pages/books/BookDetailPage.tsx`
- `Book.show(id)` returns one book in `data`
- Unknown id: show the API message and a link to `/`
- Loading state while the request runs
- A card on the home grid opens the matching book

---

## Exercise 3: Detail layout

Show title, author, price, published year (or “—” when null), and stock.

- In stock: quantity starts at 1, `Button` label “Add to cart”
- Quantity minimum 1, maximum `stock_qty`
- Out of stock: no quantity control, add button disabled
- After add, the page says “Added to cart” and the header count updates

---

## Exercise 4: Cart store

`web/src/stores/cartStore.ts`. A Zustand store, `useCartStore`, used by the detail page, the cart page, and the header. Same `create()` shape as `useAuthStore`.

A line:

```ts
{
  bookId: number
  title: string
  price: number
  stockQty: number
  quantity: number
}
```

- Add merges a line with the same `bookId`. Quantities sum, capped at `stockQty`
- Update quantity and remove a line
- Header shows the number of lines
- Persist under `localStorage` key `cart`

---

## Exercise 5: Cart page

Route `/cart`, public, inside `AppLayout`. Page `web/src/pages/cart/CartPage.tsx`.

- Empty cart: message and a link to `/`
- Each line: title, unit price, quantity control, line total, remove
- Subtotal under the lines
- Changing quantity updates the subtotal without a reload
- Logged-in user: disabled “Place order”
- Guest: “Log in to place an order” linking to `/login`

The cart page reads `useCartStore`. It does not call the API.

---

## Exercise 6: Edge cases

Write what you did in `notes_week4.md`.

| Case | Expected |
| ---- | -------- |
| Add the same book twice | one line, summed quantity, not above stock |
| Set quantity above stock | control stops at `stock_qty` |
| Remove the last line | empty cart message |
| Reload `/cart` | lines still there |
| Open `/books/999999` | not-found message |

---

## Test checklist (`notes_week4.md`)

| # | Check | Expect |
| - | ----- | ------ |
| 1 | `GET /api/books/1` | 200, one book in `data` |
| 2 | `GET /api/books/999999` | 404, `NOT_FOUND` |
| 3 | Open a card from home | detail title and price match the card |
| 4 | Add to cart, open `/cart` | line, subtotal, header count |
| 5 | Reload | cart remains |
| 6 | Guest on `/cart` | login link, place-order does nothing |
| 7 | Home search from week 3 | still filters |

---

## Docs

- Layout: `../../book_store/README_api.md`, `../../book_store/README_web.md`

---

## Submission

- [ ] Public book detail endpoint and page
- [ ] Cart in `localStorage`, cart page, header count
- [ ] `notes_week4.md` with the edge cases and checklist
- [ ] No `POST /api/orders` from the UI

---

## Next

`tasks_5.md` — Place order and order detail.
