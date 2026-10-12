# Book Store Design Tasks 5 — Week 5: Place order and order detail

**Duration:** ~28 hours · **Prerequisite:** `tasks_4.md` complete. The cart survives a reload.

Continue in `../../book_store/`. Write `../task_1/notes_week5.md`.

A logged-in user turns the cart into an order and opens that order. This week is longer because the write touches customers, orders, order lines, and stock in one transaction.

```text
Cart → Order.store({ items }) → POST /api/orders
        ↓
/orders/:id → Order.show(id) → GET /api/orders/{id}
```

A new order has status `pending`. No payment gateway, address form, or shipping fee.

---

## Blocks overview

| Block | Exercises | Focus | ~Hours |
| ----- | --------- | ----- | ------ |
| A | 1–2 | Customers, orders, order items | 6 |
| B | 3–4 | `POST /api/orders` in a transaction | 10 |
| C | 5–6 | Cart submit and order detail | 8 |
| D | 7 | Checklist | 4 |

---

## Rules (this week)

- Follow `../../book_store/README_api.md`. One Action, `handle()`, and `DB::transaction()` inside it.
- `unit_price` is copied from `books.price`. The browser does not send a price.
- `POST /api/orders` and `GET /api/orders/{order}` use `auth:sanctum`. A guest gets 401.
- Stock is checked inside the transaction. Quantity above stock, or a missing book, rolls back and returns 400 with `errors.code` = `BAD_REQUEST`.
- A user reads only their own order. Someone else’s id returns 404.
- The page calls `Order.store` and `Order.show`. It does not import Axios.
- After 201, clear the cart.
- Admin order screens stay in the week 1 notes. Do not build them here.

---

## Tables

Copy the column rules from `../../laravel/task_1/database/migrations/`:

- `customers` — `customer_id`, `full_name`, nullable `city`, nullable `email`
- `orders` — `order_id`, `customer_id`, `order_date`, `status`
- `order_items` — primary key (`order_id`, `book_id`), `quantity` > 0, `unit_price` > 0

`Enums/OrderStatus.php`: `pending`, `paid`, `shipped`, `cancelled`.

On the user’s first order, create a `customers` row from `users.name` and `users.email` and save `users.customer_id`. The next order reuses that row.

---

## Request and response

`POST /api/orders`

```json
{
  "items": [
    { "book_id": 1, "quantity": 2 }
  ]
}
```

Success `201`, `data`:

```json
{
  "id": 1,
  "order_date": "2026-10-12",
  "status": "pending",
  "items": [
    { "book_id": 1, "title": "…", "quantity": 2, "unit_price": 1500 }
  ],
  "total": 3000
}
```

`GET /api/orders/{order}` returns the same `data` shape. `total` is the sum of `quantity * unit_price`, computed in the Resource or the Action. Same number either way. Write which one you picked in the notes.

---

## Exercise 1: Schema

Migrations for the three tables and `users.customer_id`. Foreign keys: `orders.customer_id` → `customers`, `order_items` → `orders` and `books`.

Run only these new migrations.

---

## Exercise 2: Models

`Customer`, `Order`, `OrderItem`.

- `Order` belongs to `Customer` and has many `OrderItem`
- `OrderItem` belongs to `Book`
- `User` belongs to `Customer` when `customer_id` is set

---

## Exercise 3: `CreateOrderAction`

`Actions/Order/CreateOrderAction::handle(User $user, array $items)`.

Inside one transaction:

1. Use the user’s customer, or create one and store `customer_id` on the user.
2. Load each book. A missing book fails the transaction.
3. Reject `quantity` < 1 or `quantity` > `stock_qty`.
4. Insert the order with status `pending` and today’s `order_date`.
5. Insert items with `unit_price` from `books.price`.
6. Decrement `stock_qty`.

Return the order with items. No mail and no log call in this Action.

---

## Exercise 4: Routes

| Method | Path | Auth | Success |
| ------ | ---- | ---- | ------- |
| POST | `/api/orders` | logged-in user | 201 |
| GET | `/api/orders/{order}` | owner of that order | 200 |

| Class | Job |
| ----- | --- |
| `Http/Requests/Order/StoreOrderRequest` | `items` required, at least one, `book_id` integer, `quantity` integer |
| `Queries/Order/FindOrderQuery` | order by id, with items and book titles, or null |
| `Http/Resources/Order/OrderResource` | the `data` shape above, including `total` |
| `Http/Controllers/OrderController` | `store` calls the Action, `show` calls the Query |
| `Policies/OrderPolicy` | `create` needs a user. `view` needs that user’s `customer_id` |

```bash
curl -s -X POST http://127.0.0.1:8000/api/orders \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"items":[{"book_id":1,"quantity":1}]}'
```

Guest → 401. Quantity above stock → 400 and the stock row unchanged.

---

## Exercise 5: Place order from the cart

`web/src/models/Order.ts` extends `BaseModel` with `baseUrl = "orders"`.

Enable the week 4 button for a logged-in user.

- Label “Place order”
- `Order.store({ items })` sends `book_id` and `quantity` only
- On 201, `useCartStore.getState()` clears the lines, the header count goes to 0, go to `/orders/{id}`
- On 400, stay on `/cart` and show `message`
- Disable the button while the request runs
- Guest behavior from week 4 stays: link to `/login`, cart kept

---

## Exercise 6: Order detail

Route `/orders/:id`, inside `RequireAuth`. Page `web/src/pages/orders/OrderDetailPage.tsx`.

- `Order.show(id)`
- Show id, date, status, each line (title, quantity, unit price, line total), and the order total
- 404 → the API message and a link to `/cart`

`/account` stays name, email, and logout. A full order history page is later. Skip it unless the detail page is done, and if you add it, say so in the notes.

---

## Exercise 7: Checklist (`notes_week5.md`)

| # | Check | Expect |
| - | ----- | ------ |
| 1 | POST `/api/orders` with no token | 401 |
| 2 | POST a valid cart | 201, `status` `pending`, `total` equals price × quantity |
| 3 | Book `stock_qty` after that order | decreased by the quantity |
| 4 | POST quantity above stock | 400, stock unchanged, no new order |
| 5 | Cart page after 201 | empty cart, browser opens `/orders/{id}` |
| 6 | GET another user’s order id | 404 |
| 7 | Reload order detail | same lines and total |
| 8 | Home, login, and `/dev/ui` | still work |

---

## Docs

- Layout: `../../book_store/README_api.md`, `../../book_store/README_web.md`
- Order tables to copy: `../../laravel/task_1/database/migrations/`
- [Database transactions](https://laravel.com/docs/13.x/database#database-transactions)

---

## Submission

- [ ] `POST /api/orders` in a transaction, price taken from the book
- [ ] Owner-only `GET /api/orders/{order}`
- [ ] Cart places the order and opens the detail page
- [ ] `notes_week5.md` checklist
- [ ] `.env` not committed

---

## Next

Admin screens from `notes_week1.md` (books, price, stock, orders) come in a later task. Wait until this checklist passes.
