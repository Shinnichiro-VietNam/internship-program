# Web

React client for the bookstore API. The browser talks to Laravel with JSON. Pages do not call Axios themselves.

Read `README.md` for `npm run dev` and `web/.env`.

---

## Call path

```text
Page
  → Model static method     Book.index(), Book.show(id), Book.store(body)
      → Axios instance      base URL, token header, error handling
          → Laravel /api
```

```ts
// pages/books/BooksPage.tsx
const response = await Book.index<ApiSuccess<Book[]>>({ page: 1 });
const books = response.data.data;
```

```ts
// models/Book.ts
class Book extends BaseModel {
  static baseUrl = "books";
}
```

`BaseModel` maps the five CRUD calls:

| Method | HTTP | URL |
| ------ | ---- | --- |
| `index` | GET | `/{baseUrl}` |
| `show` | GET | `/{baseUrl}/{id}` |
| `store` | POST | `/{baseUrl}` |
| `update` | PUT | `/{baseUrl}/{id}` |
| `destroy` | DELETE | `/{baseUrl}/{id}` |

A route that is not one of those five is another static method on that model. It still uses the shared Axios instance.

---

## Layout

```text
src/
├── plugins/axios.ts          # one Axios instance
├── models/BaseModel.ts       # index, show, store, update, destroy
├── models/Book.ts            # baseUrl + extra calls for books
├── models/Auth.ts
├── types/api.ts              # ApiSuccess<T>, ApiErrorBody
├── types/book.ts
├── stores/authStore.ts       # token and current user
├── helper/errors.ts          # message and field errors from a failed response
├── router/routes.tsx         # route table
├── router/RequireAuth.tsx    # sends a guest to /login
├── pages/books/BooksPage.tsx # one folder per screen
├── pages/dev/UiPreviewPage.tsx
└── components/Button.tsx     # shared inputs and layout
```

| Folder | Put it here |
| ------ | ----------- |
| `plugins` | The Axios instance. Nothing else |
| `models` | One class per API resource. Pages import these |
| `types` | Response envelope and the fields of each resource |
| `stores` | Token and the logged-in user. The Axios interceptor reads the token from here |
| `helper` | Small functions with no React |
| `router` | Paths, and which paths need a login |
| `pages` | A screen and the pieces only that screen uses |
| `components` | Button, Input, Select, DateInput, header, footer |

Shared UI props stay small. A page-only form stays in that page's folder.

---

## Axios

`src/plugins/axios.ts` creates one instance.

- `baseURL` is `import.meta.env.VITE_API_URL`
- Request: if the auth store has a token, set `Authorization: Bearer {token}`
- The store keeps that token in `localStorage` under the key `token`
- Response error: 401 clears the token. Field errors for a form come from `helper/errors.ts` (`message`, `errors.fields`)

Login and register responses put the token in `data.token`. The auth store saves it. Later calls pick it up from the interceptor.

---

## Types

Match the API envelope in `README_api.md`.

```ts
export type ApiSuccess<T> = {
  status: number;
  message: string | null;
  data: T;
};

export type ApiErrorBody = {
  status: number;
  message: string | null;
  errors?: {
    code?: string;
    fields?: Record<string, string[]>;
  };
};
```

`Book` matches `BookResource`: `id`, `title`, `author`, `price`, `stock_qty`, `published_year`. `price` and `stock_qty` are numbers.

---

## Rules

- A page imports a model. It does not import Axios
- One component per file
- Do not commit `.env`
- Do not copy Fahasa images, product text, or the Fahasa logo
