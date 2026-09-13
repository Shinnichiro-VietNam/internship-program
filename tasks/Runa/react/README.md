# React — Bookstore Admin UI

**Duration:** 4 weeks (September) · **Stack:** React 19, TypeScript, Vite, Tailwind CSS, shadcn/ui, Zustand, Axios, React Router, Formik + Yup

Build a **Bookstore Admin UI** that talks to your existing Laravel API in `../laravel/task_1/`.

**AI tools:** Limited. Ask your trainer before using ChatGPT, Copilot, etc.

---

## Files

| File         | Purpose                                      |
| ------------ | -------------------------------------------- |
| `README.md`  | This guide                                   |
| `tasks_1.md` | Week 1 (Sep) — Setup, first API call         |
| `tasks_2.md` | Week 2 — Components, hooks, routing          |
| `tasks_3.md` | Week 3 — Axios, Zustand auth, login          |
| `tasks_4.md` | Week 4 — Forms, book CRUD, polish            |
| `../laravel/task_1/` | Laravel API (backend)                  |

Work in `task_1/` on **your intern branch**.

---

## Prerequisites

- Comfortable with JavaScript, HTML, and CSS
- Familiar with REST APIs from the RESTful API and Laravel modules
- Laravel API in `../laravel/task_1/` — minimum by React week:

| React week | Laravel minimum                                      |
| ---------- | ---------------------------------------------------- |
| Week 1     | Books API + health (`laravel/tasks_1.md`)            |
| Week 2     | + order-items, filters (`laravel/tasks_2.md`)        |
| Week 3     | + Sanctum auth (`laravel/tasks_3.md`)                |
| Week 4     | + policies — 403 on delete for non-admin (`tasks_4.md`) |

October capstone (orders, reports) is optional — not in these four files.

---

## Setup

**1. Laravel API** — start the backend first:

```bash
cd tasks/Runa/laravel/task_1
php artisan serve
curl -s http://127.0.0.1:8000/api/health
```

**2. CORS** — allow the Vite dev server. In Laravel `config/cors.php`, set `allowed_origins` to include `http://localhost:5173` (or use `*` for local dev only).

**3. React app** — inside `tasks/Runa/react/`:

```bash
npm create vite@latest task_1 -- --template react-ts
cd task_1
npm install
npm run dev
```

Open `http://localhost:5173`.

**4. Environment**

Create `task_1/.env`:

```env
VITE_API_URL=http://127.0.0.1:8000/api
```

Do not commit `.env`.

**5. Branch**

```bash
git checkout -b feature/react-bookstore-ui
```

---

## API response shape (Laravel)

**Health** — no envelope:

```json
{ "status": "OK" }
```

**Most other endpoints** — envelope:

```json
{
  "status": 200,
  "message": "OK",
  "data": [ ... ]
}
```

Single book or user: `data` is an object, not an array.

**Login / register** — token is inside `data`:

```json
{
  "status": 200,
  "message": "OK",
  "data": {
    "token": "1|…",
    "token_type": "Bearer"
  }
}
```

Read the token from `response.data.data.token` (Axios) or `json.data.token` (fetch).

**Errors:**

```json
{
  "status": 400,
  "message": "Invalid credentials.",
  "errors": { "code": "BAD_REQUEST" }
}
```

Use `errors.code` and `message` — not `error.code`.

Book JSON fields: `id`, `title`, `author`, `price` (integer JPY), `stock_qty`, `published_year` (nullable).

**Test users** (from Laravel `UserSeeder`): `admin@example.com` / `reader@example.com`, password `password`.

---

## Rules

- UI only — do not change Laravel routes or response shapes unless your trainer asks
- Use TypeScript for all new files
- Keep components small — one file, one job
- Call the real API; no hard-coded book lists in the final version
- Store the auth token in `localStorage` (pick a constant in `authStore.ts`, e.g. `bookstore_token`)

**Out of scope (weeks 1–4):** unit tests, SSR, orders UI, report charts.

**Notes:** Keep `task_1/notes_hooks.md` — one table row per React hook you use (where, why, deps). Update in weeks 1–2 when hooks are the focus. Not a reflection essay; a personal cheat sheet.

---

## Docs

- [React — Learn](https://react.dev/learn)
- [TypeScript Handbook](https://www.typescriptlang.org/docs/handbook/intro.html)
- [Vite](https://vitejs.dev/guide/)
- [Tailwind CSS](https://tailwindcss.com/docs)
- [shadcn/ui](https://ui.shadcn.com/docs)
- [React Router](https://reactrouter.com/)
- [Zustand](https://zustand.docs.pmnd.rs/getting-started/introduction)
- [Axios](https://axios-http.com/docs/intro)
- [Formik](https://formik.org/docs/overview) · [Yup](https://github.com/jquense/yup)

---

## Troubleshooting

| Problem              | Check                                           |
| -------------------- | ----------------------------------------------- |
| CORS error in browser | Laravel `config/cors.php`; API URL in `.env`   |
| Empty book list      | `php artisan serve` running; seed data exists   |
| `401` on book write  | Token sent? `Authorization: Bearer …` header    |
| Vite port conflict   | Change port in `vite.config.ts` or kill old dev server |

---

## Submission

- Branch `feature/react-bookstore-ui`
- App in `tasks/Runa/react/task_1/`
- `notes_hooks.md` — hook usage table kept up to date each week
- Manual checklists in each `tasks_N.md` completed before PR
- PR when your trainer asks

---

## After week 4

Optional October work: orders list, place order, one report page — ask your trainer for a `tasks_5.md` when ready.
