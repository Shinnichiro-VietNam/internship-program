# Book Store Design Tasks 5 — Week 5: Book detail and cart

**Duration:** ~24 hours · **Prerequisite:** `tasks_4.md` complete. `GET /api/books/{id}` already returns one book.

The first 4 hours finish the delete dialog and the 403 message if week 4 did not reach them. If those already work, start the detail page.

Continue in `../../book_store/`. Write `../task_1/notes_week5.md`.

Open a book from the home grid, then add it to a cart. The cart stays in the browser. Placing the order is week 6.

```text
Card → Book.show(id) → detail page
        ↓
Add to cart → useCartStore → /cart
```

---

## Blocks overview

| Block | Exercises | Focus | ~Hours |
| ----- | --------- | ----- | ------ |
| A | 1–2 | Public detail page | 12 |
| B | 3–5 | Cart store and cart page | 12 |

---

## Rules (this week)

- Do not add a second show endpoint. Week 4’s `FindBookQuery` and `Book.show` are the ones you call.
- The public detail page has no edit or delete controls. Those stay on `/admin/books`.
- Cart lines are not saved on the server. A reload keeps them (`localStorage` key `cart`).
- Quantity cannot go above `stock_qty`. `stock_qty` 0 disables add.
- Do not call `POST /api/orders`. On `/cart`, a logged-in user sees a disabled “Place order” button. A guest sees a link to `/login`.

---

## Exercise 1: Detail route

Confirm week 4:

```bash
curl -s http://127.0.0.1:8000/api/books/1
curl -s -i http://127.0.0.1:8000/api/books/999999
```

Second call: HTTP 404, `errors.code` = `NOT_FOUND`.

- Route `/books/:id`
- Page `web/src/pages/books/BookDetailPage.tsx`
- `Book.show(id)` returns one book in `data`
- Unknown id: show the API message and a link to `/`
- Loading state while the request runs
- A card on the home grid opens the matching book

---

## Exercise 2: Detail layout

Show title, author, price, published year (or “—” when null), and stock.

- In stock: quantity starts at 1, `Button` label “Add to cart”
- Quantity minimum 1, maximum `stock_qty`
- Out of stock: no quantity control, add button disabled
- After add, the page says “Added to cart” and the header count updates

---

## Exercise 3: Cart store

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

## Exercise 4: Cart page

Route `/cart`, public, inside `AppLayout`. Page `web/src/pages/cart/CartPage.tsx`.

- Empty cart: message and a link to `/`
- Each line: title, unit price, quantity control, line total, remove
- Subtotal under the lines
- Changing quantity updates the subtotal without a reload
- Logged-in user: disabled “Place order”
- Guest: “Log in to place an order” linking to `/login`

The cart page reads `useCartStore`. It does not call the API.

---

## Exercise 5: Edge cases

Write what you did in `notes_week5.md`.

| Case | Expected |
| ---- | -------- |
| Add the same book twice | one line, summed quantity, not above stock |
| Set quantity above stock | control stops at `stock_qty` |
| Remove the last line | empty cart message |
| Reload `/cart` | lines still there |
| Open `/books/999999` | not-found message |

---

## Test checklist (`notes_week5.md`)

| # | Check | Expect |
| - | ----- | ------ |
| 1 | `GET /api/books/1` | 200, one book in `data` |
| 2 | `GET /api/books/999999` | 404, `NOT_FOUND` |
| 3 | Open a card from home | detail title and price match the card |
| 4 | Add to cart, open `/cart` | line, subtotal, header count |
| 5 | Reload | cart remains |
| 6 | Guest on `/cart` | login link, place-order does nothing |
| 7 | Admin create and delete from week 4 | still work |

---

## Docs

- Layout: `../../book_store/README_api.md`, `../../book_store/README_web.md`

---

## Submission

- [ ] Public book detail page
- [ ] Cart in `localStorage`, cart page, header count
- [ ] `notes_week5.md` with the edge cases and checklist
- [ ] No `POST /api/orders` from the UI

---

## Next

`tasks_6.md` — Place order and order detail.
