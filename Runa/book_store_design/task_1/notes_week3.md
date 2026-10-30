## Test checklist (`notes_week3.md`)

| #   | Check                                | Expect                           | Check |
| --- | ------------------------------------ | -------------------------------- | ----- |
| 1   | `GET /api/books?page=1`              | 200, `data.items` is an array    |
| 2   | `GET /api/books?title=` a known word | only matching titles             |
| 3   | Home, logged out                     | grid visible, header shows Login |
| 4   | Home while books load                | loading state, then cards        |
| 5   | Title search with no match           | empty message                    |
| 6   | Stop the API and reload home         | error message and retry          |
| 7   | Login from week 2                    | still works                      |
