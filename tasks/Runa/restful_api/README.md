# RESTful API Assignment for Interns

**Duration:** 3 days · **Stack:** plain PHP (no Laravel)

You will learn HTTP and REST basics, then build a small **Books API** that returns JSON.

**AI tools:** Limited. Ask your trainer before using ChatGPT, Copilot, etc.

---

## Files

| File                                 | Purpose                     |
| ------------------------------------ | --------------------------- |
| `README.md`                          | This guide                  |
| `tasks_1.md`                         | Exercises 1–8               |
| `data/books.seed.json`               | Starter book data           |
| `reference/http_cheatsheet.md`       | Methods, status codes, curl |
| `reference/rest_design_checklist.md` | Design checklist            |

Work in `task_1/` on **your intern branch**.

---

## Setup

1. Read `tasks_1.md` and the two reference files.
2. Create `tasks/Runa/restful_api/task_1/`.
3. Copy `data/books.seed.json` → `task_1/data/books.json`.
4. Build the API under `task_1/api/` (layout in `tasks_1.md`).
5. Write answers and design notes in `task_1/notes.md`.

**Stack**

- PHP 8.1+, `php -S` built-in server
- JSON file for storage (`task_1/data/books.json`)
- Optional stretch: PDO → `internship_bookstore.books`

**Rules**

- Responses: `Content-Type: application/json`
- Use status codes: `200`, `201`, `204`, `400`, `404`, `405` (and `500` only for real server errors)
- No Laravel/Slim unless your trainer says otherwise
- Route with your own `if`/`switch` or a small router class
- Document each endpoint in `notes.md`

**Run the API**

```bash
cd task_1/api
php -S localhost:8080 index.php
```

```bash
curl -s http://localhost:8080/api/books
```

Postman / Insomnia / Thunder Client are fine. Save example requests in `notes.md`.

**Prerequisites:** Basic Programming, OOP. Database module helps (same book theme).

**Troubleshooting**

| Problem              | Check                                                              |
| -------------------- | ------------------------------------------------------------------ |
| Every route 404      | Server started in `task_1/api/`? Routes match path in `index.php`? |
| Empty or broken JSON | Path to `task_1/data/books.json`; PHP errors enabled locally       |
| Port busy            | `php -S localhost:8081 index.php`                                  |
| Garbled Japanese     | UTF-8 files; `Content-Type: application/json; charset=utf-8`       |

---

## Resources

- [REST Introduction](https://qiita.com/masato44gm/items/dffb8281536ad321fb08)
- [MDN: HTTP](https://developer.mozilla.org/ja/docs/Web/HTTP)
- [MDN: HTTP methods](https://developer.mozilla.org/ja/docs/Web/HTTP/Methods)
- [MDN: Status codes](https://developer.mozilla.org/ja/docs/Web/HTTP/Reference/Status)
- [REST API Tutorial](https://restfulapi.net/)
- [PHP built-in server](https://www.php.net/manual/en/features.commandline.webserver.php)
- [PHP JSON](https://www.php.net/manual/en/book.json.php)

---

## After this module

You should be able to:

- Explain API, REST, and the main HTTP verbs
- Design simple resource URLs and pick status codes
- Implement book CRUD in plain PHP and test with curl
