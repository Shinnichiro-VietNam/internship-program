# Laravel — Books API

**Duration:** 1 week · **Stack:** Laravel 13.x, MariaDB (`internship_bookstore`)

Rebuild your **Books API** from the REST module with Laravel routes, a controller, and Eloquent. Same endpoints as plain PHP `index.php`.

**AI tools:** Limited. Ask your trainer before using ChatGPT, Copilot, etc.

---

## Files

| File                     | Purpose                                      |
| ------------------------ | -------------------------------------------- |
| `README.md`              | This guide                                   |
| `tasks_1.md`             | Block 1 — routes, controller, Eloquent     |
| `tasks_2.md`             | Week 1 — Form Request, relationships, resources, pagination |
| `tasks_3.md`             | Week 2 — Query Builder, Sanctum, Gates       |
| `tasks_4.md`             | Week 3 — Policies, migrations, seeders       |
| `tasks_5.md`             | Week 4 — Action Pattern (thin controllers)   |
| `../restful_api/task_1/` | Plain PHP reference                          |
| `../database/schema/`    | MariaDB setup and seed                       |

Work in `task_1/` on **your intern branch**.

---

## Prerequisites

- RESTful API module — working Books API
- Database module — `internship_bookstore` on MariaDB
- System design reading — lifecycle, container, providers, facades

Plain PHP n-layer refactor (`system_design/tasks_2.md`) is **not** required.

---

## Setup

**1. Database** — from `tasks/Runa/database/`:

```bash
mariadb -u root -p < schema/setup.sql
mariadb -u root -p < schema/seed.sql
```

Windows (PowerShell): `Get-Content schema\setup.sql | mariadb -u root -p` (same for `seed.sql`).

**2. Laravel** — inside `tasks/Runa/laravel/task_1/`:

```bash
cd tasks/Runa/laravel
composer create-project laravel/laravel task_1
cd task_1
```

PHP 8.2+, Composer, MariaDB 10.4+.

**3. `.env`**

```env
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=internship_bookstore
DB_USERNAME=root
DB_PASSWORD=your_password
```

**4. Run**

```bash
php artisan serve
curl -s http://127.0.0.1:8000/api/health
```

Do not run migrations to recreate `books`. Do not commit `.env`.

**5. Branch**

```bash
git checkout -b feature/laravel-books-api
```

---

## Rules

- API only — `routes/api.php` (prefixed with `/api`)
- Match plain PHP contract — paths, methods, status codes, error JSON
- Use existing `books` table via Eloquent; do not drop `internship_bookstore`
- DB column is `book_id`; JSON uses `id` — see `tasks_1.md` Exercise 3

**Out of scope:** API Resources, repositories, services, Sanctum, pagination, Pest, relationships, custom providers.

---

## Docs (Laravel 13.x)

- [Routing](https://laravel.com/docs/13.x/routing)
- [Controllers](https://laravel.com/docs/13.x/controllers)
- [Eloquent](https://laravel.com/docs/13.x/eloquent)
- [Validation](https://laravel.com/docs/13.x/validation)

---

## Troubleshooting

| Problem             | Check                                      |
| ------------------- | ------------------------------------------ |
| DB connection error | `.env` credentials; `setup.sql` run        |
| `404` on all routes | Server running? URL has `/api`             |
| Empty book list     | `seed.sql` run; `Book` model / `$fillable` |
| Garbled Japanese    | Client charset `utf8mb4`                   |

---

## Submission

- Branch `feature/laravel-books-api`
- App in `tasks/Runa/laravel/task_1/`
- `notes.md` — checklist + reflection (`tasks_1.md` Exercise 8)
- PR when your trainer asks

---

## After Block 1

| Week | File         | Topics                                                |
| ---- | ------------ | ----------------------------------------------------- |
| 1    | `tasks_2.md` | Form Request, relationships, API Resources, pagination |
| 2    | `tasks_3.md` | Query Builder, Sanctum, authorization (Gates)         |
| 3    | `tasks_4.md` | Policies, migrations, seeders                         |
| 4    | `tasks_5.md` | Action Pattern — thin controllers, Actions, Queries   |

Still later: providers, Pest, queues/jobs. (No default Repository / `*Service` layer — see `tasks_5.md`.)
