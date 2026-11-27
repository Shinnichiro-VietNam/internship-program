# Week 6 Notes

## Detail page

### Detail API (404 vs network)

- `axios.isAxiosError(error)` && `error.response?.status === 404` -> notfound
- No response / another fail -> `parseApiError` message error

### Request count on first open

1. `GET /api/books/{id}`
2. `Get /api/books?author=...$per_page=5` (related), after show succeeds.

Total 2. StrictMode may run the effect twice in dev

---

## Test checklist (`notes_week6.md`)

| #   | Check                                   | Expect                                                                             | OK  |
| --- | --------------------------------------- | ---------------------------------------------------------------------------------- | --- |
| 1   | `GET /api/books/1`                      | 200, one book in `data`                                                            | ✅️  |
| 2   | `GET /api/books/999999`                 | 404, `NOT_FOUND`                                                                   | ✅️  |
| 3   | Open a card from `/`                    | skeleton, then title and price match the card                                      | ✅️  |
| 4   | `/books/999999`                         | “Book not found” and a link to `/`                                                 | ✅️  |
| 5   | Stop the API, open a detail page        | error and Retry                                                                    | ✅️  |
| 6   | Related books                           | same author, current book not among them, hidden when none                         | ✅️  |
| 7   | Add to cart, quantity 2                 | drawer slides in with the line “2 × price”, subtotal, header badge 2               | ✅️  |
| 8   | Click the header cart icon              | drawer opens. × and the overlay close it                                           | ✅️  |
| 9   | “View cart” in the drawer               | drawer closes, `/cart` opens with the same line                                    | ✅️  |
| 10  | Add the same book again                 | one line, quantity summed, capped at stock                                         | ✅️  |
| 11  | Change quantity on `/cart`              | line subtotal, totals card, drawer subtotal, badge all update                      | ✅️  |
| 12  | Remove the last line                    | “Return to shop” on `/cart`, “No products in the cart.” in the drawer              | ✅️  |
| 13  | Reload `/cart`                          | lines remain, drawer closed                                                        | ✅️  |
| 14  | Guest                                   | “Log in to checkout” in the drawer and in Cart totals. Logged in: disabled buttons | ✅️  |
| 15  | Phone width on detail, drawer, and cart | stacked layout, drawer covers the full width, nothing overflows                    | ✅️  |
| 16  | `/dev/ui`                               | breadcrumb, badges, detail skeleton render; `sampleBooks` no longer exists         | ✅️  |

---
