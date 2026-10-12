# Book Store Design Tasks 2 — Week 2: Login, register, app shell

**Duration:** ~24 hours · **Prerequisite:** `tasks_1.md` complete. `GET /api/health` works. `/dev/ui` renders.

Continue in `../../book_store/`. Write `../task_1/notes_week2.md`.

A user can register and log in. The router knows who is logged in. `/` is only a shell this week (header, outlet, footer). The book grid is week 3.

```text
Login or Register page → Auth.login() / Auth.register()
        ↓
useAuthStore saves data.token → Axios reads it with getState()
        ↓
RequireAuth wraps /account
```

---

## Blocks overview

| Block | Exercises | Focus | ~Hours |
| ----- | --------- | ----- | ------ |
| A | 1–2 | Sanctum register and login | 8 |
| B | 3–4 | Login and register pages | 8 |
| C | 5–6 | Auth store, router, app shell | 8 |

---

## Rules (this week)

- Follow `../../book_store/README_api.md`. Register, login, and logout are Actions. Each `handle()` does one job.
- Follow `../../book_store/README_web.md`. Pages call `Auth`. They do not import Axios.
- Reuse `Button` and `Input` from week 1.
- `/`, `/login`, `/register`, and `/dev/ui` stay public.
- A failed login shows `message`. Field errors from `errors.fields` sit on the matching `Input`.
- No book grid, cart, or order page.

---

## Auth contract

| Method | Path | Auth | Success | Body |
| ------ | ---- | ---- | ------- | ---- |
| POST | `/api/register` | No | 201 | `name`, `email`, `password` |
| POST | `/api/login` | No | 200 | `email`, `password` |
| POST | `/api/logout` | Yes | 204 | — |
| GET | `/api/user` | Yes | 200 | current user in `data` |

Token body (`data`):

```json
{
  "token": "1|…",
  "token_type": "Bearer"
}
```

`GET /api/user` returns `data`: `id`, `name`, `email`.

Validation failure is `400` with `errors.code` = `BAD_REQUEST` and `errors.fields`. Wrong password is `401`.

---

## Exercise 1: Sanctum

1. Install Sanctum the same way as `../../laravel/tasks_3.md`.
2. Run the users and personal access tokens migrations only.
3. `User` uses `HasApiTokens`. Password is hashed. Minimum length 8.

---

## Exercise 2: Auth routes

| Class | Job |
| ----- | --- |
| `Actions/Auth/RegisterUserAction` | Create the user and a token |
| `Actions/Auth/LoginUserAction` | Check email and password, issue a token |
| `Actions/Auth/LogoutUserAction` | Revoke the current token |
| `Http/Requests/Auth/RegisterRequest` | `name`, `email`, `password` |
| `Http/Requests/Auth/LoginRequest` | `email`, `password` |
| `Http/Resources/Auth/UserResource` | `id`, `name`, `email` |
| `Http/Controllers/AuthController` | Call one action, return `ResponseData` |

`GET /api/user` reads `$request->user()` and returns `UserResource`. No query class for that.

Duplicate email → 400 and a field error on `email`.

```bash
curl -s -X POST http://127.0.0.1:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{"name":"Runa","email":"runa@example.com","password":"secret1234"}'

curl -s -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"runa@example.com","password":"secret1234"}'
```

Seed one user: `reader@example.com` / `password`.

---

## Exercise 3: Login page

Route `/login`. File `web/src/pages/login/LoginPage.tsx`.

`web/src/models/Auth.ts` uses the Axios instance from `plugins/axios.ts`:

| Method | Call |
| ------ | ---- |
| `Auth.register` | `POST /register` |
| `Auth.login` | `POST /login` |
| `Auth.logout` | `POST /logout` |
| `Auth.me` | `GET /user` |

The page:

- Email and password through `Input`, submit through `Button`
- On 200, `useAuthStore.getState().setToken(data.token)`, then `Auth.me()` fills the user, then go to `/`
- On 401, show `message`
- On 400, show `errors.fields` on the inputs
- Link to `/register`

---

## Exercise 4: Register page

Route `/register`. File `web/src/pages/register/RegisterPage.tsx`.

- Fields: `name`, `email`, `password`
- Client check: all three required, password at least 8 characters. The API still validates
- On 201, save the token the same way as login and go to `/`
- On 400, show field errors, including a duplicate email
- Link to `/login`

---

## Exercise 5: Router

`stores/authStore.ts` is a Zustand store (`useAuthStore`). It already holds the token under `localStorage` key `token`. Add `user` (`id`, `name`, `email`) and `setUser`.

Pages and `RequireAuth` call the hook so they re-render. Axios keeps using `useAuthStore.getState()`.

- Login and register call `Auth.me()` after the token is saved
- Logout calls `Auth.logout()`, then clears token and user
- On 401, the Axios interceptor clears the token and sends the browser to `/login`. Skip that redirect when the request was login or register

`web/src/router/RequireAuth.tsx` renders the child route when a token exists. Otherwise it redirects to `/login`.

| Path | Who |
| ---- | --- |
| `/login`, `/register` | Guests. A logged-in user is sent to `/` |
| `/account` | Inside `RequireAuth` |
| `/` | Everyone |
| `/dev/ui` | Everyone |

`/account` shows the name, the email, and a logout button.

---

## Exercise 6: App shell

`web/src/components/AppLayout.tsx`, used by `/` and `/account`:

- Header: your store name (not Fahasa), link to `/`, link to `/cart` (the page can be an empty placeholder), and either “Login” or the user’s name
- Outlet for the page
- Footer: one line, and a link to `/account`

`/` shows a short welcome. No book cards yet.

---

## Test checklist (`notes_week2.md`)

| # | Check | Expect |
| - | ----- | ------ |
| 1 | POST `/api/register` with a new email | 201 and `data.token` |
| 2 | POST `/api/register` with the same email | 400, field error on email |
| 3 | POST `/api/login` with a wrong password | 401 |
| 4 | Open `/account` while logged out | redirect to `/login` |
| 5 | Login as `reader@example.com` | land on `/`, header shows the name |
| 6 | Logout | token gone, header shows Login |
| 7 | `/dev/ui` | week 1 inputs still render |

---

## Docs

- [Sanctum](https://laravel.com/docs/13.x/sanctum)
- Layout: `../../book_store/README_api.md`, `../../book_store/README_web.md`
- Auth to compare: `../../laravel/task_1/app/Http/Controllers/AuthController.php`

---

## Submission

- [ ] Register, login, logout, and `GET /api/user`
- [ ] `/login`, `/register`, `/account`, and the app shell
- [ ] `notes_week2.md` checklist
- [ ] `.env` not committed

---

## Next

`tasks_3.md` — Home page and the book list.
