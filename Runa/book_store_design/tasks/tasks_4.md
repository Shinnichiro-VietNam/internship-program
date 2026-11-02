# Book Store Design Tasks 4 — Week 4: Login UI, Register UI, Home page UI

**Duration:** ~25 hours · **Prerequisite:** `tasks_2.md` complete. Login and register work with Formik. `GET /api/books` from `tasks_3.md` returns a list.

This week is screens only. The home page shows sample books from a local file. Wiring `Book.index()` into the home page is next week.

Continue in `../../book_store/`. Write `../task_1/notes_week4.md`.

**UI reference:** [Bookory — Home 5](https://demo2.pavothemes.com/bookory/home-5/). Fahasa stays the reference for *which* features exist (your `notes_week1.md`). Bookory is the reference for *how it looks*.

```text
/login     → AuthLayout → LoginPage (Bookory “My Account” style)
/register  → AuthLayout → RegisterPage (same, plus confirm password)
/          → AppLayout  → HomePage (Bookory header, hero, Popular Books grid, footer)
```

---

## Blocks overview

| Block | Exercise | Task | ~Hours |
| ----- | -------- | ---- | ------ |
| A | 1 | Update UI Login | 6 |
| B | 2 | Update UI Register | 8 |
| C | 3–4 | Create UI HomePage | 11 |

---

## Bookory reference

Open these three pages in a browser before you start. Write what you see in `notes_week4.md`, one row per page, like week 1.

| Page | URL | Copy the layout of |
| ---- | --- | ------------------ |
| Home | `/bookory/home-5/` | Top bar, header row, menu row, hero, “Popular Books” section header, book card, sale strip, footer |
| Product | `/bookory/product/<any-book>/` | Not this week. Week 5 |
| Login / Register | `/bookory/my-account/` | Title band, two-column form area, label with red asterisk, pill inputs, eye icon on password, full-width coral button |

What to take: layout, spacing, rounded shapes, and the color roles below. What not to take: image files, fonts, icons as files, the Bookory name or logo, product names, the Categories dropdown, wishlist, vendor, blog.

| Role | Use |
| ---- | --- |
| Accent | Coral red. Primary buttons, prices, active menu item, badge on the cart icon |
| Text | Near-black headings, gray secondary text (author, hints) |
| Hero and sale strip | Pale pink background |
| Page band and inputs | Light gray |
| Top bar and footer | Dark gray, white text |

Set these once in `web/src/index.css` as Tailwind theme colors (`--color-accent`, `--color-ink`, `--color-blush`, `--color-mist`, `--color-dark`) and use the class names. No hex codes repeated inside components.

---

## Rules (this week)

- Follow `../../book_store/README_web.md`. Pages call `Auth`. They do not import Axios.
- Tailwind for styling. One component per file in `web/src/components/`.
- Reuse `Button` and `Input`. Change them only to add what this week asks for.
- Keep the week 2 behavior: Yup before the request, `message` above the form on 401, `errors.fields` on the matching `Input` on 400, disabled submit while `isSubmitting`.
- Book covers are solid color blocks with the first letter of the title. No image files in `web/` this week.
- No API call from the home page this week. No cart behavior.

---

## Exercise 1: Update UI Login (6 hours)

### 1.1 `Button.tsx`

Match the Bookory button.

- Pill shape (`rounded-full`), bold white text, taller padding
- `primary` is the accent color. `secondary` is white with a thin gray border and dark text
- Add `fullWidth?: boolean`
- Keep `type`, `disabled`, `children`, and the rest of the button props

### 1.2 `Input.tsx`

Match the Bookory input.

- `label` renders as a block above the input. When `required` is set, a red asterisk follows the label text
- Input is a pill: `rounded-full`, light gray border, left padding, light focus ring in the accent color
- `placeholder` passes through. Use “Enter your email...” style text on the forms
- When `error` is set, the border is red and the message shows under the input in red, small

`/dev/ui` still renders.

### 1.3 `web/src/components/AuthLayout.tsx`

Shared frame for `/login` and `/register`.

| Part | Content |
| ---- | ------- |
| Title band | Light gray background, full width. Big title left (“Login” or “Register”). Breadcrumb right in small uppercase: “Home → Login” |
| Form area | White, max width about 32rem, centered, vertical spacing like Bookory |
| Props | `title`, `children` |

Bookory puts Login and Register side by side on one page. We keep two routes. One column each.

### 1.4 `LoginPage.tsx`

Keep the Formik form from week 2. Change only the view.

- Wrap in `AuthLayout` with title “Login”
- Email label “Email address”, required asterisk, placeholder “Enter your email...”
- Password label “Password”, placeholder “Enter your password...”. The eye icon comes in Block B
- Form-level error (401) in a light red box above the fields
- Submit `Button` `fullWidth`, text “Log in”, and “Logging in…” while `isSubmitting`
- Under the button, one centered sentence: “No account yet?” with a link to `/register` in the accent color

Bookory shows “Remember me” and “Lost your password?”. Skip both. Write why in `notes_week4.md` (no API for either).

---

## Exercise 2: Update UI Register (8 hours)

### 2.1 `web/src/components/PasswordInput.tsx`

Match the Bookory eye icon.

- Same props as `Input` minus `type`
- Renders `Input` with `type="password"` and a button at the right edge inside the pill. The button draws an eye with inline SVG, no icon file
- Clicking switches between `password` and `text`. `aria-label` “Show password” / “Hide password”

Use it on `/register` and `/login`.

### 2.2 `RegisterPage.tsx`

Keep the Formik form from week 2. Change the view and add one field.

| Field | Label | Yup |
| ----- | ----- | --- |
| `name` | Full name | required |
| `email` | Email address | required, email format |
| `password` | Password | required, at least 8 characters |
| `password_confirmation` | Confirm password | required, must equal `password` |

- Wrap in `AuthLayout` with title “Register”
- Field order: name, email, password, confirm password. Both password fields use `PasswordInput`
- Under the password field, a gray hint: “At least 8 characters”
- `password_confirmation` is checked by Yup only. The body sent to `Auth.register` is still `name`, `email`, `password`
- Submit `Button` `fullWidth`, text “Register”, and “Creating account…” while `isSubmitting`
- Duplicate email (400) stays on the email input
- Under the button: “Already have an account?” with a link to `/login`

Bookory asks “I am a customer / I am a vendor”. Skip it. Every register is a reader.

In `notes_week4.md`, write two sentences: how you kept `password_confirmation` out of the request body, and what you changed in `Input.tsx` and `Button.tsx`.

---

## Exercise 3: App shell and card (part of 11 hours)

### 3.1 `web/src/components/AppLayout.tsx`

Used by `/`, `/cart`, `/books/:id`, `/account`, and from this exercise also `/login` and `/register`. Header, `Outlet`, footer.

Header, three rows like Bookory:

| Row | Content |
| --- | ------- |
| Top bar | Dark background, one line of small white text: your own tagline on the left, your own phone number on the right |
| Main row | Store name as a link to `/` (text, bold, with a small colored square as the mark). A `Button` “Categories” in the accent color, no dropdown this week. A pill search: `Input` without label plus a search `Button`, UI only. Right side: account and cart |
| Menu row | White, centered links: Home (`/`), Shop (`/`), Cart (`/cart`), Account (`/account`). Current route in the accent color |

Account and cart on the right:

- Account: “Login” link when `useAuthStore` has no user. The user’s name as a link to `/account` when it has one
- Cart: link to `/cart` with a small round badge showing “0”. `/cart` is a placeholder page with the text “Cart”

Footer, dark background, four columns on wide screens, stacked on small:

| Column | Content |
| ------ | ------- |
| Store | Store name, two lines of your own address |
| Need help | Your own phone number in the accent color, opening hours, email |
| Explore | Links: Home, Account, Cart |
| Categories | Static text list, four or five of your own category names |

One copyright line at the bottom with your store name.

Read the user with the hook (`useAuthStore((s) => s.user)`) so the header re-renders after login and logout.

### 3.2 `web/src/components/BookCard.tsx`

Match the Bookory card. Props: `book: Book`. No fetching.

Shows, top to bottom:

- Cover block, tall portrait (`aspect-[3/4]`), solid color with the first letter of the title. Color picked from a small palette by `book.id`
- Title, bold, two lines max
- Author, gray, small
- Price in the accent color, bold, from `formatPrice` in `web/src/helper/format.ts` (VND, thousands separator, `đ` suffix)
- Stock line: “In stock” in green, or “Out of stock” in red

Bookory shows star ratings. There is no rating field. Skip it and write that in the notes.

The whole card links to `/books/:id`. That route is a placeholder until week 5.

---

## Exercise 4: Home page (rest of 11 hours)

### 4.1 Sample data

`web/src/pages/home/sampleBooks.ts` exports `Book[]` with 8 items. Match `types/book.ts`. Include one with `stock_qty` 0. Your own titles and authors.

### 4.2 `web/src/pages/home/HomePage.tsx`

Replace the week 2 welcome on `/`. Sections, top to bottom, following Bookory home-5:

| # | Section | Content |
| - | ------- | ------- |
| 1 | Hero | Pale pink, full width. Left: small uppercase label (“Editor choice”), headline in three lines, a price in the accent color, white pill `Button` “Shop now”. Right: two or three cover blocks slightly rotated. Three static dots under it, UI only |
| 2 | Popular Books | Section header: title left, thin line in the middle, `Button` “View all” right linking to `/`. Grid of `BookCard`: 2 columns small, 3 medium, 5 wide |
| 3 | Sale strip | Pale pink, rounded, one line of your own sale headline and a “Shop now” link |
| 4 | Pagination | A disabled “Next page” `Button` under the grid. Replaced in week 5 |

The grid reads from `sampleBooks`. Next week it reads from `Book.index()`, so keep the list in one variable at the top of the page.

Bookory also has “Daily Deals”, “Trending Now”, “Most Viewed”, and “New Release”. Skip them. They need fields the API does not have.

### 4.3 `routes.tsx`

| Path | Wrapper | Page |
| ---- | ------- | ---- |
| `/` | `AppLayout` | `HomePage` |
| `/cart` | `AppLayout` | placeholder |
| `/books/:id` | `AppLayout` | placeholder |
| `/account` | `AppLayout` + `RequireAuth` | `AccountPage` |
| `/login`, `/register` | `AppLayout` + `GuestOnly` | `LoginPage`, `RegisterPage` |
| `/dev/ui` | none | as before |

`/login` and `/register` move inside `AppLayout` here, so they show the Bookory header and footer like `/my-account/` does.

---

## Test checklist (`notes_week4.md`)

| # | Check | Expect |
| - | ----- | ------ |
| 1 | Open `/login` | header, title band “Login”, pill inputs, asterisks, coral full-width button, footer |
| 2 | Submit `/login` empty | red border and message on both inputs, no request |
| 3 | Wrong password | light red box above the fields with the API message |
| 4 | Click the eye on the password | characters appear and hide, label changes |
| 5 | `/register` with passwords that do not match | Yup error on confirm password, no request |
| 6 | Register with an email that exists | error on the email input |
| 7 | Open `/` logged out | top bar, header with Categories, search, “Login”, cart badge 0; hero; 8 cards; sale strip; footer |
| 8 | Login as `reader@example.com` | header shows the name, link opens `/account` |
| 9 | Logout | header shows “Login” again |
| 10 | Resize the window | 2 / 3 / 5 columns, footer stacks |
| 11 | Menu row | current page link is in the accent color |
| 12 | `/dev/ui` | week 1 inputs still render in the new style |

---

## Docs

- [Bookory Home 5](https://demo2.pavothemes.com/bookory/home-5/), [My Account](https://demo2.pavothemes.com/bookory/my-account/)
- [Formik](https://formik.org/docs/overview)
- [Yup](https://github.com/jquense/yup) — `oneOf([ref("password")])`
- [React Router — Outlet, NavLink](https://reactrouter.com/)
- [Tailwind — theme variables](https://tailwindcss.com/docs/theme), [aspect-ratio](https://tailwindcss.com/docs/aspect-ratio), [grid](https://tailwindcss.com/docs/grid-template-columns)
- Layout: `../../book_store/README_web.md`

---

## Submission

- [ ] Theme colors in `index.css`, restyled `Button` and `Input`
- [ ] `AuthLayout`, restyled `/login` and `/register`, `PasswordInput`
- [ ] `AppLayout` (top bar, header, menu, footer), `BookCard`, `HomePage` with sample books, `formatPrice`
- [ ] `notes_week4.md` with the Bookory notes and checklist
- [ ] No image, font, or icon files copied from Bookory
- [ ] `.env` not committed

---

## Next

`tasks_5.md` — Home page reads `Book.index()`: search, loading, empty, error. Then the book detail page.
