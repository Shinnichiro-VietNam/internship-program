# Edge cases

| Case                           | Expected                                                    | Result                                    |
| ------------------------------ | ----------------------------------------------------------- | ----------------------------------------- |
| `/?page=99`                    | API returns an empty page → `EmptyState` with a link to `/` | OK ✅️                                     |
| `/?title=zzzz`                 | `EmptyState` “No books match “zzzz”” and Clear              | OK ✅️                                     |
| API stopped                    | `ErrorState`, Retry works after the API is back             | OK ✅️something went to wrong Retry button |
| Reload on `/?title=the&page=2` | same list, header input shows “the”                         | OK ✅️return 2 books                       |

Request count: 4
Open `/` sent GET /api/books twice. Search sent it once. Page 2 sent it once.
StrictMode runs the effect twice on the first load.

## Test checklist (`notes_week5.md`)

| #   | Check                                                        | Expect                                                | OK  |
| --- | ------------------------------------------------------------ | ----------------------------------------------------- | --- |
| 1   | `/dev/ui`                                                    | four grid states, pagination, quantity control render | OK  |
| 2   | Open `/`                                                     | hero, then skeletons, then cards from the API         | OK  |
| 3   | `GET /api/books?title=the` vs the grid after searching “the” | same titles                                           | OK  |
| 4   | Search with no match                                         | empty panel and Clear                                 | OK  |
| 5   | Go to page 2, reload                                         | still page 2, Previous enabled                        | OK  |
| 6   | Stop the API, reload `/`                                     | error and Retry. Start the API, Retry → cards         | OK  |
| 7   | Open `/`, search, next page                                  | exactly 3 requests in the network tab                 | OK  |
| 8   | Click a card                                                 | breadcrumb, two cards, title and price match the card | OK  |
| 9   | Switch tabs                                                  | Description and Details swap, underline moves         | OK  |
| 10  | `/books/999999`                                              | “Book not found” and a link to `/`                    | OK  |
| 11  | Detail of the `stock_qty` 0 book                             | red badge, quantity 0, controls disabled              | OK  |
| 12  | Related books                                                | 4 cards, current book not among them                  | OK  |
| 13  | Login and `/account` from week 2                             | still work inside `AppLayout`                         | OK  |
