# REST Design Checklist

For **Exercise 4** and final review.

---

## URLs

- [ ] Nouns: `/api/books`, not `/api/getBooks`
- [ ] `GET /api/books` — list
- [ ] `GET /api/books/{id}` — one item
- [ ] Plural name consistent (`books`)

---

## Methods

- [ ] GET — read only
- [ ] POST — create; server assigns `id`
- [ ] PUT — replace full resource
- [ ] PATCH — update sent fields only
- [ ] DELETE — remove; `204` is fine

---

## Responses

- [ ] JSON body for success and errors
- [ ] Correct status code (see `http_cheatsheet.md`)
- [ ] `201` + `Location` on create
- [ ] `404` when `id` missing (not `200` + null)
- [ ] `400` with clear message on bad input

---

## REST constraints (explain in `notes.md`)

| Name | Meaning (Books API) |
| ---- | ------------------- |
| Client–server | curl = client, PHP = server |
| Stateless | Each request stands alone; no server “memory” of past calls |
| Uniform interface | Same pattern: JSON, verbs, status codes |
| Layered system | Client does not need to know your file layout |
| Cacheable | GET may be cached (optional here) |
| Code on demand | Rare for JSON APIs; optional note |

---

## Later (not required now)

- Auth: `Authorization` header  
- API version: `/api/v1/books`  
- Do not send stack traces in JSON errors in production  
- Validate all input from the client  
