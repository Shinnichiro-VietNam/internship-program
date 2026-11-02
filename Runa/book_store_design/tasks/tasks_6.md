# Book Store Design Tasks 6 — Week 6: Book detail UI, Book detail API, Shopping cart UI

**Duration:** ~25 hours · **Prerequisite:** `tasks_5.md` complete. `/` reads `Book.index()`. `/books/:id` renders from `sampleBooks`. `QuantityInput` works.

Finish the detail screen pieces, then put the real book behind it with `GET /api/books/{book}`. The rest of the week is the cart: a Zustand store in the browser, the “Add to cart” button that opens a cart drawer, the header badge, and the cart page. Placing the order is week 7.

Continue in `../../book_store/`. Write `../task_1/notes_week6.md`.

**UI reference:** [Bookory product page](https://demo2.pavothemes.com/bookory/product/the-girl-and-the-last-sleepover/) and [Bookory cart](https://demo2.pavothemes.com/bookory/cart/). On Bookory, “Add to cart” does not leave the page. A “Shopping cart” drawer slides in from the right, and “View cart” inside it opens the cart page. Same rule as weeks 4 and 5: layout and color roles only. No files, names, or the Bookory logo.

```text
BookCard → /books/:id → Book.show(id) → GET /api/books/{book} → detail
                              ↓
                 Add to cart → useCartStore (localStorage "cart") → CartDrawer opens, header badge
                              ↓
                 View cart  → /cart → lines, totals, checkout button (disabled until week 7)
```

---

## Blocks overview

| Block | Exercise | Task | ~Hours |
| ----- | -------- | ---- | ------ |
| A | 1 | Create UI Book Detail (finish) | 4 |
| B | 2–3 | Integrate API Book Detail | 7 |
| C | 4–6 | Create UI Shopping Cart | 14 |

Block C, hour by hour:

| Exercise | Piece | ~Hours |
| -------- | ----- | ------ |
| 4 | Cart store in `localStorage` | 3 |
| 5 | Cart drawer, Add to cart, header badge | 5 |
| 6 | View cart page (`/cart`) | 6 |

---

## Bookory reference (drawer and cart page)

On the home page, hover a card and click “Add to cart”, or click the cart icon in the header. Then open `/bookory/cart/`. Write a row per part in `notes_week6.md`.

Drawer (“Shopping cart”):

| Part | Bookory | This week |
| ---- | ------- | --------- |
| Opening | Slides in from the right over a dark transparent overlay. Opens after “Add to cart” and when the header cart icon is clicked | Same. `CartDrawer` |
| Header | “Shopping cart” left, “CLOSE ×” right | Same |
| Empty | “No products in the cart.” | Same |
| Line | Small cover, title, vendor, “1 × $289.38”, small × top right | Small cover block, title link, author, “2 × 150.000đ”, × remove. No vendor |
| Footer | “Subtotal: $289.38”, light gray pill “VIEW CART”, accent pill “CHECKOUT” | Same. “View cart” links to `/cart`. “Checkout” disabled this week, or a login link for guests |
| Closing | ×, click on the overlay | Same, plus the Escape key |

Cart page:

| Part | Bookory | This week |
| ---- | ------- | --------- |
| Title band | Light gray, “Cart” left, “HOME → CART” right | `Breadcrumb` + same band as `AuthLayout` |
| Empty cart | Large gray cart icon, “Your cart is currently empty.”, accent pill “Return to shop” | Same, inline SVG icon, link to `/` |
| Table | Columns PRODUCT, PRICE, QUANTITY, SUBTOTAL in small uppercase. × at the far left of each row. Thumbnail + title + vendor + stock text | Same columns. Cover block + title link + author + `StockBadge`. `QuantityInput` in the quantity column |
| Under the table | Coupon input, “Apply coupon”, “Update cart” | Skip all three. One link “Continue shopping” to `/`. Quantity changes apply at once, so there is no “Update cart” |
| Totals | Right card “Cart totals”: Subtotal, Total, accent pill “Proceed to checkout” | Same two rows. Button disabled this week, or a login link for guests |
| Below | “You may be interested in…” | Skip |

---

## Rules (this week)

- Follow `../../book_store/README_api.md`. Show is `Queries/Book/FindBookQuery`. The controller does not write `where`.
- Follow `../../book_store/README_web.md`. Pages call `Book.show` and `Book.index`. They do not import Axios.
- Cart lines live in the browser only (`localStorage` key `cart`). No cart table or cart API.
- Quantity never goes above `stock_qty`. `stock_qty` 0 disables add.
- No `POST /api/orders`. “Proceed to checkout” does nothing yet.
- Delete `pages/books/sampleBooks.ts` at the end of Block B. `/dev/ui` keeps a two-item inline array for previews.

---

## Exercise 1: Detail pieces (Block A)

Pull three pieces out of `BookDetailPage` so the cart page and the API states can reuse them.

| Component | Props | Shows |
| --------- | ----- | ----- |
| `components/Breadcrumb.tsx` | `items: { label, to? }[]` | Small uppercase row with arrows. Last item has no link and uses the accent color |
| `components/StockBadge.tsx` | `stockQty` | Green pill “In stock” or red pill “Out of stock”. Used on the detail page and the cart lines |
| `components/BookDetailSkeleton.tsx` | none | Gray blocks in the shape of the two detail cards: tall cover left, title, meta, price, button right. `animate-pulse` |

- `BookDetailPage` uses all three
- `/dev/ui` shows `Breadcrumb` with three items, both badges, and the skeleton
- Check the detail page at a phone width: cards stack, breadcrumb wraps, the quantity row and button stay on one line

---

## Exercise 2: `GET /api/books/{book}` (Block B)

| Class | Job |
| ----- | --- |
| `Queries/Book/FindBookQuery` | `handle(int $id): ?Book`. Returns the book or `null` |
| `Http/Controllers/BookController@show` | `authorize('view', $book)`. `null` → 404 through the existing error renderer. Else `httpOk(new BookResource($book))` |
| `Policies/BookPolicy::view` | public, same as `viewAny` |
| `routes/api.php` | `GET /books/{book}` under the existing book route |

Same JSON as one item of the list: `id`, `title`, `author`, `price`, `stock_qty`, `published_year`.

```bash
curl -s http://127.0.0.1:8000/api/books/1
curl -s -i http://127.0.0.1:8000/api/books/999999
```

Second call: HTTP 404, `errors.code` = `NOT_FOUND`.

---

## Exercise 3: Wire the detail page (Block B)

`BookDetailPage` reads `id` from `useParams`, then `Book.show<ApiSuccess<Book>>(id)`.

State: `book`, `status` (`"loading" | "error" | "notfound" | "ready"`), `errorMessage`.

| State | Shows |
| ----- | ----- |
| `loading` | `BookDetailSkeleton` |
| `notfound` (404) | `EmptyState` “Book not found” with a link to `/` |
| `error` (other) | `ErrorState` with the message from `helper/errors.ts` and Retry |
| `ready` | The week 5 layout with the real book |

- One `useEffect` keyed on `[id]`. Moving from `/books/1` to `/books/2` through a related card reloads and scrolls to the top
- Related books: `Book.index({ author: book.author, per_page: 5 })`, drop the current book, show up to 4. Empty → hide the section. This call starts after the book arrives
- Remove the `sampleBooks` import and delete the file

In `notes_week6.md`, write how you tell a 404 from a network error in the `catch`, and how many requests the page makes on first open.

---

## Exercise 4: Cart store (Block C)

`web/src/stores/cartStore.ts`. A Zustand store, `useCartStore`, same `create()` shape as `useAuthStore`.

A line:

```ts
{
  bookId: number
  title: string
  author: string
  price: number
  stockQty: number
  quantity: number
}
```

| Action | Rule |
| ------ | ---- |
| `add(book, quantity)` | Same `bookId` merges into one line. Quantities sum, capped at `stockQty` |
| `setQuantity(bookId, quantity)` | Clamped to 1..`stockQty` |
| `remove(bookId)` | Drops the line |
| `clear()` | Empties the cart |
| `openDrawer()`, `closeDrawer()` | Toggle `isDrawerOpen`. Not persisted |

Derived values, as functions on the store or a `helper/cart.ts`: `lineCount` (number of lines), `itemCount` (sum of quantities), `subtotal` (sum of `price * quantity`).

Persist the lines under `localStorage` key `cart`. `isDrawerOpen` is never saved. Read the lines on startup. Write which Zustand approach you used (manual `localStorage` like `authStore`, or `persist` middleware) and why.

---

## Exercise 5: Add to cart, drawer, header badge (Block C)

### 5.1 `components/CartDrawer.tsx`

Rendered once, inside `AppLayout`, so it is available on every page. Reads `useCartStore` with the hook.

| Part | Behavior |
| ---- | -------- |
| Overlay | Full screen, dark and transparent. Click closes the drawer |
| Panel | Fixed to the right edge, full height, white, about 24rem wide. Slides in and out with a Tailwind `transition-transform` on `translate-x` |
| Header | “Shopping cart” and a “Close ×” button |
| Empty | “No products in the cart.” centered |
| Lines | Scrollable list. Each line: small cover block, title as a link to `/books/:id` (closes the drawer), author in gray, “<quantity> × <formatPrice(price)>”, a small × that calls `remove` |
| Footer | Row “Subtotal” with `formatPrice(subtotal)` bold. `Button` secondary `fullWidth` “View cart” linking to `/cart` (closes the drawer). Under it: logged-in → accent `Button` `fullWidth` “Checkout”, disabled this week; guest → link “Log in to checkout” to `/login` |
| Keyboard | Escape closes. While open, the page behind does not scroll (`overflow-hidden` on `body`) |

Closing uses `closeDrawer`. Nothing in the drawer navigates without closing it first.

### 5.2 Detail page

Enable the week 5 button.

- `Add to cart` calls `add(book, quantity)` then `openDrawer()`. The new line is visible in the drawer at once. No separate “Added to cart” text
- `stock_qty` 0: button disabled, badge red, quantity 0, as in week 5
- Trying to add more than the stock left (already have 3 of 3): button disabled with a gray hint “Maximum in cart”

### 5.3 Header

- The cart icon is now a `button`, not a link. Click calls `openDrawer()`
- The badge from week 4 shows `itemCount`. Hidden when 0
- The header reads the store with the hook so the badge updates without a reload
- The menu row keeps its “Cart” link to `/cart` for people who want the full page directly

---

## Exercise 6: View cart page (Block C)

This is the page behind “View cart” in the drawer and “Cart” in the menu row. It shows the same lines as the drawer, with room to change quantities and see the totals.

Route `/cart`, public, inside `AppLayout`. Page `web/src/pages/cart/CartPage.tsx`. Replace the placeholder.

Ways to reach it, all must work:

| From | How |
| ---- | --- |
| Drawer | “View cart” button. The drawer closes first |
| Header | “Cart” link in the menu row |
| Address bar | Type `/cart` and reload. Lines come back from `localStorage` |

### 6.1 Empty

- Title band “Cart” with `Breadcrumb` “Home → Cart”
- Centered: a gray cart icon as inline SVG, “Your cart is currently empty.”, accent `Button` “Return to shop” linking to `/`

### 6.2 With lines

Two columns on wide screens, stacked on small.

Left, the lines. A table with a header row in small uppercase gray: PRODUCT, PRICE, QUANTITY, SUBTOTAL. `components/CartLine.tsx`, props `line`, renders one `<tr>`.

| Column | Content |
| ------ | ------- |
| Remove | First cell. A small gray “×” button, calls `remove` |
| Product | Small cover block (same palette as `BookCard`), then title as a link to `/books/:id`, author in gray, `StockBadge` |
| Price | `formatPrice(line.price)` |
| Quantity | `QuantityInput`, `min` 1, `max` `line.stockQty`, calls `setQuantity` |
| Subtotal | `formatPrice(line.price * line.quantity)` |

Under the table: a link “Continue shopping” to `/`. No coupon, no “Update cart”.

Right, `components/CartTotals.tsx`, a white card with a thin border.

| Row | Content |
| --- | ------- |
| Heading | “Cart totals” |
| Subtotal | `formatPrice(subtotal)` |
| Total | `formatPrice(subtotal)`, large, bold |
| Button | Logged-in: accent `Button` `fullWidth` “Proceed to checkout”, disabled, gray hint “Available next week”. Guest: a link “Log in to checkout” to `/login` |

The drawer footer and `CartTotals` show the same subtotal. Both read it from the store, so they cannot disagree.

Changing a quantity updates the line subtotal, the totals card, the drawer, and the header badge without a reload.

### 6.3 Edge cases

| Case | Expected |
| ---- | -------- |
| Add the same book twice | one line, summed quantity, not above stock |
| Set quantity above stock | `QuantityInput` stops at `stockQty` |
| Remove the last line | empty state on `/cart`, “No products in the cart.” in the drawer |
| Reload `/cart` | lines still there, drawer closed |
| Logout with lines in the cart | lines stay, checkout becomes the login link in both places |
| Add from a book with `stock_qty` 0 | not possible, button disabled |
| Open the drawer, press Escape | drawer closes, page scrolls again |
| Click a title inside the drawer | drawer closes, detail page opens |

---

## Test checklist (`notes_week6.md`)

| # | Check | Expect |
| - | ----- | ------ |
| 1 | `GET /api/books/1` | 200, one book in `data` |
| 2 | `GET /api/books/999999` | 404, `NOT_FOUND` |
| 3 | Open a card from `/` | skeleton, then title and price match the card |
| 4 | `/books/999999` | “Book not found” and a link to `/` |
| 5 | Stop the API, open a detail page | error and Retry |
| 6 | Related books | same author, current book not among them, hidden when none |
| 7 | Add to cart, quantity 2 | drawer slides in with the line “2 × price”, subtotal, header badge 2 |
| 8 | Click the header cart icon | drawer opens. × and the overlay close it |
| 9 | “View cart” in the drawer | drawer closes, `/cart` opens with the same line |
| 10 | Add the same book again | one line, quantity summed, capped at stock |
| 11 | Change quantity on `/cart` | line subtotal, totals card, drawer subtotal, badge all update |
| 12 | Remove the last line | “Return to shop” on `/cart`, “No products in the cart.” in the drawer |
| 13 | Reload `/cart` | lines remain, drawer closed |
| 14 | Guest | “Log in to checkout” in the drawer and in Cart totals. Logged in: disabled buttons |
| 15 | Phone width on detail, drawer, and cart | stacked layout, drawer covers the full width, nothing overflows |
| 16 | `/dev/ui` | breadcrumb, badges, detail skeleton render; `sampleBooks` no longer exists |

---

## Docs

- [Bookory cart](https://demo2.pavothemes.com/bookory/cart/)
- [Zustand](https://zustand.docs.pmnd.rs/), [persist middleware](https://zustand.docs.pmnd.rs/integrations/persisting-store-data)
- [React Router — useParams](https://reactrouter.com/)
- Layout: `../../book_store/README_api.md`, `../../book_store/README_web.md`

---

## Submission

- [ ] `Breadcrumb`, `StockBadge`, `BookDetailSkeleton`
- [ ] `GET /api/books/{book}` with `FindBookQuery`, detail page on `Book.show`, related books, `sampleBooks` deleted
- [ ] `cartStore` in `localStorage`, `CartDrawer`, Add to cart opens the drawer, header badge, `/cart` with `CartLine` and `CartTotals`
- [ ] `notes_week6.md` with the Bookory notes, edge cases, and checklist
- [ ] No image, font, or icon files copied from Bookory
- [ ] `.env` not committed

---

## Next

`task_7.md` — Admin layout, book management table on `Book.index()`, add and edit book forms. Placing the order comes after the admin weeks.
