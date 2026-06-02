# HTTP Quick Reference

Use with `tasks_1.md`. Details: [MDN HTTP](https://developer.mozilla.org/ja/docs/Web/HTTP).

---

## Request parts

```http
GET /api/books/3 HTTP/1.1
Host: localhost:8080
Accept: application/json
```

| Part | Example | Role |
| ---- | ------- | ---- |
| Method | `GET` | Action |
| Path | `/api/books/3` | Resource |
| Headers | `Content-Type` | Format / metadata |
| Body | JSON | Data (POST, PUT, PATCH) |

---

## Methods

| Method | Safe | Idempotent | Use | OK status |
| ------ | ---- | ---------- | --- | --------- |
| GET | Yes | Yes | Read | `200` |
| POST | No | No | Create | `201` |
| PUT | No | Yes | Full update | `200` / `204` |
| PATCH | No | Usually no | Partial update | `200` |
| DELETE | No | Yes | Delete | `204` / `200` |

**Safe** — should not change data (only GET in normal use).  
**Idempotent** — same result if you send it twice.

---

## Status codes (this module)

| Code | When |
| ---- | ---- |
| 200 | GET, PUT, PATCH success |
| 201 | POST created |
| 204 | DELETE success, no body |
| 400 | Bad JSON or validation |
| 404 | Unknown `id` |
| 405 | Method not allowed |
| 500 | Unexpected server error (avoid in normal tests) |

---

## Useful headers

| Header | When |
| ------ | ---- |
| `Content-Type: application/json` | Request with body |
| `Content-Type: application/json; charset=utf-8` | Response |
| `Location: /api/books/21` | After `201` create |

---

## curl examples

```bash
# List
curl -s http://localhost:8080/api/books

# Create
curl -s -X POST http://localhost:8080/api/books \
  -H "Content-Type: application/json" \
  -d "{\"title\":\"新しい本\",\"author\":\"研修 太郎\",\"price\":2500,\"stock_qty\":10,\"published_year\":2025}"

# Replace
curl -s -X PUT http://localhost:8080/api/books/1 \
  -H "Content-Type: application/json" \
  -d "{\"title\":\"リーダブルコード\",\"author\":\"イリイ・メイヤーズ\",\"price\":3300,\"stock_qty\":28,\"published_year\":2018}"

# Partial update
curl -s -X PATCH http://localhost:8080/api/books/1 \
  -H "Content-Type: application/json" \
  -d "{\"stock_qty\":25}"

# Delete (show status only)
curl -s -o NUL -w "%{http_code}" -X DELETE http://localhost:8080/api/books/1

# Headers + body
curl -i http://localhost:8080/api/books/1
```

On Linux/macOS use `/dev/null` instead of `NUL`.

---

## Error JSON (example)

```json
{
  "error": {
    "code": "VALIDATION_ERROR",
    "message": "price must be positive",
    "details": { "field": "price" }
  }
}
```

Document your format in `notes.md`.
