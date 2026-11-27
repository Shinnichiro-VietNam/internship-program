# Week 6 Notes

## Detail page

### Detail API (404 vs network)

- `axios.isAxiosError(error)` && `error.response?.status === 404` -> notfound
- No response / another fail -> `parseApiError` message error

### Request count on first open

1. `GET /api/books/{id}`
2. `Get /api/books?author=...$per_page=5` (related), after show succeeds.

Total 2. StrictMode may run the effect twice in dev
