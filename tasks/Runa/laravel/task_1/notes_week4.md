# Week 4 Notes

## Migration order (FK-safe)

1. `users` / `cache` / `jobs` / `personal_access_tokens` / `add_role_to_users` (auth stack)
2. `departments` — no FK
3. `employees` — FK → departments
4. `customers` — no FK
5. `books` — no FK
6. `orders` — FK → customers
7. `order_items` — FK → orders, books

Parent tables must exist before child tables that reference them.

## Intentional differences vs `setup.sql`

- Laravel also creates `users`, `password_reset_tokens`, `sessions`, `cache`, `jobs`, `personal_access_tokens` for the API app.
- `users.role` is included in the users migration (default `reader`); `add_role_to_users_table` is idempotent for older DBs.
- Bookstore tables otherwise match column names, types, indexes, FKs, and CHECK constraints from `setup.sql`.

## Gate vs Policy

- **Gate:** simple capability checks (e.g. one boolean like “admin can manage books”).
- **Policy:** better when rules are tied to a **model** and multiple actions (`view`, `create`, `update`, `delete`). Policies keep controller code readable with `$this->authorize()` and scale as rules grow.

Reports (`/api/reports/*`) stay public: they are read-only analytics and do not expose write operations.

## Fresh workflow (zero → working API)

```bash
# create empty DB, set DB_DATABASE in .env, then:
php artisan migrate:fresh --seed
php artisan serve
```

Local login users (do not commit real secrets):

- `reader@example.com` / `password` (role: reader)
- `admin@example.com` / `password` (role: admin)

## Final test checklist

| #   | Step / request                              | Expect              | Result |
| --- | ------------------------------------------- | ------------------- | ------ |
| 1   | `migrate:fresh --seed`                      | no errors           | OK     |
| 2   | Row counts match schema README              | OK                  | OK     |
| 3   | GET /api/books                              | 200                 | OK     |
| 4   | GET /api/orders (no token)                  | 401                 | OK     |
| 5   | GET /api/orders (reader token)              | 200                 | OK     |
| 6   | DELETE /api/books/1 (reader)                | 403                 | OK     |
| 7   | DELETE /api/books/18 (admin)                | 204                 | OK     |
| 8   | GET /api/reports/books-never-sold           | 200, 3 rows         | OK     |

Note: `DELETE /api/books/1` fails at the DB layer (`order_items` FK `ON DELETE RESTRICT`), even for admin. Policy allows the action; use an unsold book (e.g. `18`) to observe `204`.

## Reflection

Previously, schema and seed lived in hand-maintained SQL files (`setup.sql` / `seed.sql`). That is easy to inspect and run with the MySQL client, but drift between the SQL files and the Laravel app is easy. With migrations and seeders, Laravel owns the repeatable path (`migrate:fresh --seed`), so teammates get the same schema and auth tables automatically. The trade-off is more PHP files to maintain, and CHECK/FK details must be written carefully to match the original SQL.
