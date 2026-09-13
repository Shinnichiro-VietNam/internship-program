# React Tasks 3 — Week 3 (September): API Layer and Authentication

**Duration:** ~20 hours · **Prerequisite:** `tasks_2.md` complete.

Continue in `task_1/`.

**Goal:** Replace raw `fetch` with Axios, add login/register, and protect routes with Zustand.

```text
Login → token in Zustand + localStorage → Axios interceptor → Laravel Sanctum
```

---

## Blocks overview

| Block | Exercises | Focus                              | ~Hours |
| ----- | --------- | ---------------------------------- | ------ |
| A     | 1–2       | Axios client + services             | 4      |
| B     | 3–4       | Zustand auth store                  | 4      |
| C     | 5–6       | Login + register pages (Formik intro) | 6   |
| D     | 7–8       | Protected routes + header auth UI   | 6      |

---

## Rules (this week)

- Refactor existing book fetches to use Axios — remove duplicate `fetch` calls.
- Token storage: `localStorage` + Zustand (persist on login, clear on logout).
- Send header: `Authorization: Bearer {token}` on protected requests.
- Public routes stay public: `GET /api/books`, book detail, filters.
- Match Laravel auth contract — do not invent new field names.

---

## Auth API contract (Laravel)

| Method | Path            | Auth | Success | Body                          |
| ------ | --------------- | ---- | ------- | ----------------------------- |
| POST   | `/api/register` | No   | `201`   | `name`, `email`, `password`   |
| POST   | `/api/login`    | No   | `200`   | `email`, `password`           |
| POST   | `/api/logout`   | Yes  | `204`   | —                             |
| GET    | `/api/user`     | Yes  | `200`   | current user in `data`        |

Login response (envelope — token is in `data`):

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

Register (`201`) uses the same `data.token` shape.

`GET /api/user` returns `data`: `id`, `name`, `email` — **no `role` field** in the current API. Show the **Admin** link for any logged-in user; handle **403** on delete in week 4 (readers can create/edit books, only admin can delete).

API errors use `message` + `errors.code` (e.g. `BAD_REQUEST`), not `error.code`.

**Test users:** `admin@example.com` / `reader@example.com`, password `password`.

```bash
curl -s -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com","password":"password"}'

curl -s http://127.0.0.1:8000/api/user \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## Install

```bash
npm install axios zustand formik yup
npx shadcn@latest add input label alert
```

---

## Target layout

```text
src/
├── lib/
│   └── apiClient.ts             # axios instance + interceptors
├── services/
│   ├── authService.ts
│   └── bookService.ts           # move GET helpers here
├── stores/
│   └── authStore.ts
├── pages/
│   ├── LoginPage.tsx
│   ├── RegisterPage.tsx
│   └── ...
├── components/
│   └── auth/
│       ├── LoginForm.tsx
│       ├── RegisterForm.tsx
│       └── ProtectedRoute.tsx
└── types/
    ├── auth.ts
    └── book.ts
```

---

## Exercise 1: Axios client

Create `src/lib/apiClient.ts`:

1. `baseURL` = `import.meta.env.VITE_API_URL`.
2. **Request interceptor** — if token exists in auth store, set `Authorization` header.
3. **Response interceptor** — on `401`, clear auth and redirect to `/login` (optional but recommended).

Export the configured instance. Use it everywhere instead of `fetch`.

---

## Exercise 2: Book service

Create `src/services/bookService.ts` with functions such as:

- `getBooks(params?)` → `Book[]`
- `getBook(id)` → `Book`
- `getBookOrderItems(id)` → order items array

Update `useBooks` and `BookDetailPage` to use these functions.

Confirm list, detail, and filters still work after the refactor.

---

## Exercise 3: Zustand auth store

Create `src/stores/authStore.ts`:

| State / action | Purpose                              |
| -------------- | ------------------------------------ |
| `token`        | Bearer token or `null`               |
| `user`         | Logged-in user or `null`             |
| `login(token)` | Save token; persist to localStorage  |
| `setUser(user)`| After `GET /user`                    |
| `logout()`     | Clear token, user, localStorage      |
| `hydrate()`    | Load token from localStorage on app start |

Call `hydrate()` once when the app mounts (e.g. in `App.tsx` or `main.tsx`).

If token exists on load, call `GET /api/user` to restore `user`.

---

## Exercise 4: Auth service

Create `src/services/authService.ts`:

- `register(name, email, password)`
- `login(email, password)` → returns token string (read from `response.data.data.token`)
- `logout()` → `POST /api/logout` with token
- `fetchMe()` → current user

Map API errors to a simple message string for the UI.

---

## Exercise 5: Register page

Route: **`/register`**

Form fields: `name`, `email`, `password`, `confirm password`.

Use **Formik** for form state and **Yup** for validation:

- All fields required
- Email format
- Password min 8 characters (match Laravel)
- Confirm password must match

On success → `201` → read token from `data.token` if auto-login, or redirect to `/login` with a success message.

Use shadcn `Input`, `Label`, `Button`, `Alert` for errors.

---

## Exercise 6: Login page

Route: **`/login`**

Fields: `email`, `password`.

On success:

1. Save token via auth store.
2. Fetch `/api/user`.
3. Redirect to `/books` (or previous page if you implement `redirect` query param).

Show API error (e.g. wrong password) under the form.

Link to **Register** and vice versa.

---

## Exercise 7: Protected routes

Create `ProtectedRoute` — if no token, redirect to `/login`.

Apply protection to routes you will need next week (you can add the pages as stubs):

- `/admin/books/new` (week 4 — create book)
- Or protect a placeholder **Admin** section

**Do not** protect public `/books` and `/books/:id`.

Header changes:

- Guest: **Login** / **Register**
- Logged in: user name + **Logout** button (`logout()` → call API → clear store → go to `/books`)

---

## Exercise 8: Checklist

| #   | Check                                              | OK? |
| --- | -------------------------------------------------- | --- |
| 1   | Book list still works via Axios                    |     |
| 2   | Register with invalid data shows validation errors |     |
| 3   | Login stores token; refresh keeps session          |     |
| 4   | Logout clears token; protected URL redirects       |     |
| 5   | `GET /user` populates header name                    |     |
| 6   | Wrong password shows API error message             |     |

---

## Optional stretch

- Remember last visited URL before login redirect.
- shadcn `Form` wrapper with Formik (if comfortable).
- Disable submit button while Formik `isSubmitting`.

---

## Submission

- [ ] `apiClient`, `authService`, `bookService`, `authStore`
- [ ] Login + register pages with Formik/Yup
- [ ] Protected route + header auth UI
- [ ] Checklist above completed

---

## Next week

`tasks_4.md` — admin book CRUD, shadcn Table/Dialog, toasts, polish.
