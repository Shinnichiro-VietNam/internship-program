# React Tasks 1 — Week 1 (September): Setup and First API Call

**Duration:** ~10 hours · **Prerequisite:** Laravel API running (`../laravel/task_1/` — at least books + health).

Create the React app in `task_1/`.

**Goal:** Scaffold the project, connect to Laravel, and display the book list.

```text
Browser → fetch(VITE_API_URL/books) → Laravel → JSON → BookList UI
```

---

## Blocks overview

| Block | Exercises | Focus                              | ~Hours |
| ----- | --------- | ---------------------------------- | ------ |
| A     | 1–2       | Project setup + TypeScript types   | 3      |
| B     | 3         | Tailwind + shadcn/ui               | 3      |
| C     | 4–5       | Components + first API call        | 3      |
| D     | 6–7       | Hook notes + checklist             | 1      |

---

## Rules (this week)

- Read `README.md` first — CORS and `.env` before you debug fetch errors.
- Use **Vite + React + TypeScript** — do not use Create React App.
- One small component per file under `src/components/`.
- Use `fetch` this week — Axios comes in `tasks_3.md`.
- Do not add React Router yet — single page is fine.

---

## Target layout (end of week)

```text
task_1/
├── src/
│   ├── components/
│   │   ├── layout/
│   │   │   └── AppLayout.tsx
│   │   └── books/
│   │       ├── BookCard.tsx
│   │       └── BookList.tsx
│   ├── types/
│   │   └── book.ts
│   ├── lib/
│   │   └── config.ts          # reads import.meta.env.VITE_API_URL
│   ├── App.tsx
│   └── main.tsx
├── .env
└── notes_hooks.md               # running hook cheat sheet (start this week)
```

---

## Exercise 1: Create the project

1. Follow `README.md` — create Vite app in `tasks/Runa/react/task_1/`.
2. Add `.env` with `VITE_API_URL=http://127.0.0.1:8000/api`.
3. Create `src/lib/config.ts`:

```ts
export const API_URL = import.meta.env.VITE_API_URL;
```

4. Confirm both servers run:

```bash
# Terminal 1
cd tasks/Runa/laravel/task_1 && php artisan serve

# Terminal 2
cd tasks/Runa/react/task_1 && npm run dev
```

5. In `App.tsx`, temporarily show `API_URL` on screen to confirm env loading works.

---

## Exercise 2: TypeScript types

Create `src/types/book.ts`:

```ts
export type Book = {
  id: number;
  title: string;
  author: string;
  price: number;
  stock_qty: number;
  published_year: number | null;
};

export type ApiListResponse<T> = {
  status: number;
  message: string;
  data: T[];
};
```

---

## Exercise 3: Tailwind + shadcn/ui

1. Install and configure Tailwind for Vite (follow [Tailwind + Vite guide](https://tailwindcss.com/docs/installation/using-vite)).
2. Init shadcn/ui for Vite + TypeScript ([shadcn installation](https://ui.shadcn.com/docs/installation/vite)).
3. Add components:

```bash
npx shadcn@latest add button card
```

4. Create `AppLayout.tsx` — header with app title **Bookstore**, main content area, simple footer.

Use Tailwind for spacing and layout. Header can include a small badge for API status (filled in Exercise 5).

---

## Exercise 4: BookCard and BookList

**`BookCard`** — receives one `book: Book` as a prop. Show:

- `title` (prominent)
- `author`
- `price` formatted as JPY (e.g. `¥3,000` — `toLocaleString('ja-JP')` is fine)

Use shadcn `Card`.

**`BookList`** — receives `books: Book[]`. Map to `BookCard`. Use `book.id` as React `key`.

Handle empty list: show **No books found** (plain text or muted Card).

Practice topics:

- Functional components
- Props
- Rendering lists
- Conditional rendering (empty vs has items)

---

## Exercise 5: Fetch books from Laravel

In `App.tsx` (or a small `useBooks` hook in `src/hooks/useBooks.ts` if you prefer):

1. On mount, `GET ${API_URL}/health` — response is `{ "status": "OK" }` (no `data` wrapper). Show **API: OK** or **API: offline** in the header.
2. `GET ${API_URL}/books` — envelope response; parse as `ApiListResponse<Book>`, store `data` in state.
3. Show **Loading…** while fetching.
4. On error, show a short error message (do not leave a blank screen).

```bash
# Same data your UI should show
curl -s http://127.0.0.1:8000/api/books
```

Use `useState` and `useEffect`. No router, no auth yet.

---

## Exercise 6: Hook notes

Create `task_1/notes_hooks.md` — a short cheat sheet of hooks **you actually used**, not general definitions from the docs.

Add one table row per hook. Keep each **Notes** cell to one line (file name, dependency array, or one pitfall you hit).

```markdown
# React hooks — usage notes

| Hook       | Used in   | Purpose              | Notes                          |
| ---------- | --------- | -------------------- | ------------------------------ |
| useState   | App.tsx   | books, loading, error | separate state vs one object?  |
| useEffect  | App.tsx   | fetch books on mount | deps: `[]` — runs once       |
```

Update this file whenever you add a hook in later weeks (`tasks_2.md`, etc.).

---

## Exercise 7: Checklist

**Test checklist** (manual — browser + DevTools Network tab):

| #   | Check                                      | OK? |
| --- | ------------------------------------------ | --- |
| 1   | Vite dev server opens without errors       |     |
| 2   | Health badge shows OK when Laravel runs    |     |
| 3   | Book list matches `curl /api/books` count  |     |
| 4   | Each card shows title, author, price       |     |
| 5   | Stop Laravel → error message appears       |     |
| 6   | `.env` is not committed                    |     |

---

## Optional stretch

- TypeScript: add `ApiError` type matching Laravel: `{ status: number; message: string; errors?: { code: string } }`.
- Skeleton loading UI with shadcn `Skeleton`.
- Dark mode toggle with Tailwind `dark:` classes.

---

## Submission

- [ ] Branch `feature/react-bookstore-ui`
- [ ] App in `tasks/Runa/react/task_1/`
- [ ] `BookList`, `BookCard`, `AppLayout`, types, `.env` (not committed)
- [ ] `notes_hooks.md` — at least `useState` and `useEffect` documented
- [ ] Checklist above completed

---

## Next week

`tasks_2.md` — filters, book detail page, React Router, more hooks.
