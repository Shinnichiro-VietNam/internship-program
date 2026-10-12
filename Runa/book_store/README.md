# Book Store — Selling site and admin

**Duration:** ongoing · **Stack:** Laravel 13.x, MariaDB (`book_store`), React, TypeScript, Vite, Tailwind CSS

Build a small online bookstore from [Fahasa](https://www.fahasa.com/): the public selling site, and an admin site you design yourself. Fahasa does not publish an admin.

Weekly instructions are in `../book_store_design/`.

**AI tools:** Allowed on this module. You still explain the feature list and the code in review.

---

## Files

| Path | Purpose |
| ---- | ------- |
| `README.md` | This guide |
| `README_api.md` | API layout: controller, Action, Query, Resource |
| `README_web.md` | Web layout: pages call models, models call Axios |
| `api/` | Laravel API. Empty until `book_store_design/tasks/tasks_1.md` |
| `web/` | React app. Empty until the same task |
| `../book_store_design/` | Tasks and your notes |
| `../laravel/task_1/` | API style to follow (responses, auth, books, orders) |

Work on **your intern branch**.

---

## Prerequisites

- Laravel module through `laravel/tasks_7.md`
- React module through `react/tasks_3.md`. Formik and admin book CRUD are in `book_store_design`, not in `react/tasks_4.md`.

---

## Setup

Week 1 creates both apps. Until then, `api/` and `web/` only hold `.gitkeep`.

`composer create-project` and `npm create vite` both refuse a non-empty folder. Delete the `.gitkeep` in that folder first, then follow `tasks_1.md`.

**Database** — new database, not `internship_bookstore`:

```sql
CREATE DATABASE IF NOT EXISTS book_store CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**API** — from `Runa/book_store/api/` after it exists:

```bash
php artisan serve
curl -s http://127.0.0.1:8000/api/health
```

**Web** — from `Runa/book_store/web/`:

```bash
npm run dev
```

Open `http://localhost:5173`.

**`.env`**

```env
# api/.env
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=book_store
DB_USERNAME=root
DB_PASSWORD=your_password
```

```env
# web/.env
VITE_API_URL=http://127.0.0.1:8000/api
```

Do not commit `.env`.

**Branch**

```bash
git checkout -b feature/book-store
```

---

## Rules

- API layout and JSON shape: `README_api.md`
- Web layout: `README_web.md`. Pages call model classes, not Axios
- Call the API in this folder. Do not point `web/` at `laravel/task_1/`

**Out of scope until a later task says otherwise:** payment gateways, SMS or Zalo OTP, loyalty points, flash-sale engine.

---

## Docs

- [Fahasa](https://www.fahasa.com/) — selling site to study
- [Laravel 13.x](https://laravel.com/docs/13.x)
- [React](https://react.dev/learn)
- [Vite](https://vitejs.dev/guide/)
- [Tailwind CSS](https://tailwindcss.com/docs)
- [Axios](https://axios-http.com/docs/intro)
- [React Router](https://reactrouter.com/)

---

## Troubleshooting

| Problem | Check |
| ------- | ----- |
| `composer create-project` refuses `api/` | Delete `api/.gitkeep` first |
| `npm create vite` refuses `web/` | Delete `web/.gitkeep` first |
| DB connection error | `book_store` database exists; `api/.env` credentials |
| CORS error | `api/config/cors.php` allows `http://localhost:5173` |
| Port 8000 already in use | Stop `laravel/task_1` before `php artisan serve` here |

---

## Submission

- Branch `feature/book-store`
- Apps in `api/` and `web/`
- Notes in `../book_store_design/task_1/`
- PR when your trainer asks
