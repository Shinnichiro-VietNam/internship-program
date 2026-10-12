# Laravel Tasks 4 — Week 3: Authorization (policies), Migrations, Seeders

**Duration:** ~20 hours · **Prerequisite:** `tasks_3.md` complete.

Same app in `task_1/`. Write `task_1/notes_week4.md`.

---

## Blocks overview

| Block | Exercises | Focus                         | ~Hours |
| ----- | --------- | ----------------------------- | ------ |
| A     | 1–2       | Authorization — Policies      | 4      |
| B     | 3–5       | Migrations                    | 8      |
| C     | 6–8       | Seeders + fresh DB workflow   | 8      |

---

## Rules (this week)

- Replace the Gate-only DELETE check from week 2 with a **Policy** — remove duplicate logic.
- Migrations must reproduce `../database/schema/setup.sql` on an **empty** database.
- Seed data must match `../database/schema/seed.sql` row counts (see `schema/README.md`).
- Keep `.env` out of git.

---

## Exercise 1: `BookPolicy`

1. `php artisan make:policy BookPolicy --model=Book`
2. Methods:

| Action   | Rule                                              |
| -------- | ------------------------------------------------- |
| `viewAny`, `view` | always `true` (public read)              |
| `create`, `update` | authenticated user (`reader` or `admin`) |
| `delete` | `admin` only                                      |

3. Register in `AuthServiceProvider` / `bootstrap/app.php` (Laravel 13 style).
4. Use `$this->authorize()` in `BookController` instead of inline Gate checks.
5. Remove the week-2 Gate for DELETE once the policy works.

```bash
# reader → 403
curl -s -o /dev/null -w "%{http_code}" -X DELETE http://127.0.0.1:8000/api/books/99 \
  -H "Authorization: Bearer READER_TOKEN"
```

---

## Exercise 2: Policy on orders (read vs write)

**`OrderPolicy`**

| Action   | Rule                                |
| -------- | ----------------------------------- |
| `viewAny`, `view` | authenticated user           |
| `create`, `update`, `delete` | `admin` only        |

- Apply to `GET /api/orders` and `GET /api/orders/{order}` — now require auth (change from week 2).
- Reports (`/api/reports/*`) stay **public** unless you document why not in `notes_week4.md`.

Update checklist tests from week 2 for orders.

In `notes_week4.md`: Gate vs Policy — when is a Policy better?

---

## Exercise 3: Migration plan

Study `../database/schema/setup.sql`. Plan one migration per table (or logical groups), in FK-safe order:

1. `departments`
2. `employees`
3. `customers`
4. `books`
5. `orders`
6. `order_items`

Document the order and why in `notes_week4.md`.

**Do not** `DROP DATABASE` on your main dev DB until Exercise 6. For Exercises 3–5, use a **separate test database** (e.g. `internship_bookstore_migrate_test`) in `.env.testing` or a second `.env` copy.

---

## Exercise 4: Write migrations

Create migrations that match the schema:

- Column names, types, and nullability match `setup.sql`.
- Primary keys, indexes, and foreign keys included.
- `CHECK` constraints where present (`price > 0`, etc.) — use `DB::statement()` if needed on MariaDB.

```bash
php artisan make:migration create_departments_table
# … repeat for each table
```

On the **test database**:

```bash
php artisan migrate --database=… --env=testing
# or swap DB_DATABASE temporarily
```

Verify:

```bash
php artisan db:show
php artisan schema:dump  # optional — inspect generated SQL
```

Compare with `setup.sql` — list any intentional differences in `notes_week4.md`.

---

## Exercise 5: Users migration in the chain

Include in your migration set (or keep separate files run in order):

- `users` (with `role`: `reader` | `admin`, default `reader`)
- `personal_access_tokens` (Sanctum)
- `cache`, `jobs` — only if your fresh install needs them

`php artisan migrate:fresh` on the test DB should leave a valid schema for both bookstore and auth.

---

## Exercise 6: Seeders — bookstore data

```bash
php artisan make:seeder DepartmentSeeder
php artisan make:seeder EmployeeSeeder
php artisan make:seeder CustomerSeeder
php artisan make:seeder BookSeeder
php artisan make:seeder OrderSeeder
php artisan make:seeder OrderItemSeeder
```

- Port data from `../database/schema/seed.sql` into seeders (hardcode rows or read SQL — your choice).
- `DatabaseSeeder` calls them in FK order.

**`php artisan migrate:fresh --seed`** on the test DB → expected counts:

| Table        | Rows |
| ------------ | ---- |
| departments  | 6    |
| employees    | 16   |
| customers    | 18   |
| books        | 20   |
| orders       | 23   |
| order_items  | 40   |

Run sanity queries from `schema/README.md` (books never sold, customers with no orders).

---

## Exercise 7: `UserSeeder`

- At least two users:
  - `reader@example.com` / password you document locally (not in git)
  - `admin@example.com` / `role = admin`
- Call from `DatabaseSeeder` after bookstore seeders.

Confirm login + policy behavior still works against the test DB.

---

## Exercise 8: Fresh workflow + final reflection

1. Document in `notes_week4.md` how to go from zero to a working API:

   ```bash
   # create DB, configure .env, then:
   php artisan migrate:fresh --seed
   php artisan serve
   ```

2. **Final test checklist**

| #   | Step / request                              | Expect              |
| --- | ------------------------------------------- | ------------------- |
| 1   | `migrate:fresh --seed`                      | no errors           |
| 2   | Row counts match table above                | OK                  |
| 3   | GET /api/books                              | 200                 |
| 4   | GET /api/orders (no token)                  | 401                 |
| 5   | GET /api/orders (reader token)                | 200                 |
| 6   | DELETE /api/books/1 (reader)                | 403                 |
| 7   | DELETE /api/books/1 (admin)                 | 204                 |
| 8   | GET /api/reports/books-never-sold           | 200, 3 rows         |

3. **Reflection** (one paragraph): task_1 used hand-maintained SQL files; now Laravel owns schema and seed — what are the trade-offs?

---

## Docs (Laravel 13.x)

- [Authorization — Policies](https://laravel.com/docs/13.x/authorization#creating-policies)
- [Migrations](https://laravel.com/docs/13.x/migrations)
- [Seeding](https://laravel.com/docs/13.x/seeding)

---

## Submission

- [ ] `BookPolicy`, `OrderPolicy` wired in controllers
- [ ] Migrations for all bookstore tables + users/tokens
- [ ] Seeders matching `seed.sql` counts + `UserSeeder`
- [ ] `notes_week4.md` — migration order, checklist, reflection
- [ ] `.env` not committed

---

## Optional stretch

- Feature test: guest cannot delete a book; admin can.
- `php artisan db:seed --class=BookSeeder` individually.
- Export `schema.sql` from your migrated DB and diff against `setup.sql`.

---

## Later (not this file)

Action Pattern (thin controllers) — `tasks_5.md`. Then providers, Pest — see `README.md`.
