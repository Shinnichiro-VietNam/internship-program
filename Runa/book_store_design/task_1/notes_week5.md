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
