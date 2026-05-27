# Bookstore Practice Database — Setup

Shared **schema** and **seed data** for the Database & SQL module. Trainees complete exercises in `../tasks_1.md` in their own `task_1/` folder.

- **Names / cities:** Japanese (e.g. `田中 太郎`, `東京`, `大阪`)
- **Money:** JPY (円) — `employees.salary` is **monthly** salary

---

## Requirements

- **MySQL 8.0.16+** or **MariaDB 10.4+** (`CHECK` constraints need a recent version)
- **`utf8mb4`** support (required for Japanese text)
- User with `CREATE DATABASE` and DDL/DML rights

---

## Quick setup

**Linux / macOS** — from the `database` folder:

```bash
mysql -u root -p < schema/setup.sql
mysql -u root -p < schema/seed.sql
```

**Windows (PowerShell)** — same commands if `mysql` is on your `PATH` (XAMPP, Laragon, or MySQL Installer):

```powershell
Get-Content schema\setup.sql | mysql -u root -p
Get-Content schema\seed.sql | mysql -u root -p
```

**MySQL client** (`SOURCE` must use forward slashes or escaped backslashes):

```sql
SOURCE D:/SHINNICHIRO/Training/internship-program/tasks/Runa/database/schema/setup.sql;
SOURCE D:/SHINNICHIRO/Training/internship-program/tasks/Runa/database/schema/seed.sql;
```

---

## Verify

```sql
USE internship_bookstore;
SHOW TABLES;

SELECT 'departments' AS tbl, COUNT(*) AS n FROM departments
UNION ALL SELECT 'employees', COUNT(*) FROM employees
UNION ALL SELECT 'customers', COUNT(*) FROM customers
UNION ALL SELECT 'books', COUNT(*) FROM books
UNION ALL SELECT 'orders', COUNT(*) FROM orders
UNION ALL SELECT 'order_items', COUNT(*) FROM order_items;
```

Expected counts:

| Table        | Rows |
| ------------ | ---- |
| departments  | 6    |
| employees    | 16   |
| customers    | 18   |
| books        | 20   |
| orders       | 23   |
| order_items  | 40   |

Sanity checks (should match exercise expectations):

```sql
-- Customers who never ordered (4 rows)
SELECT c.customer_id, c.full_name
FROM customers c
LEFT JOIN orders o ON o.customer_id = c.customer_id
WHERE o.order_id IS NULL;

-- Books never sold (3 rows: book_id 18, 19, 20)
SELECT b.book_id, b.title
FROM books b
LEFT JOIN order_items oi ON oi.book_id = b.book_id
WHERE oi.book_id IS NULL;
```

---

## Reset

```sql
DROP DATABASE IF EXISTS internship_bookstore;
```

Then run `setup.sql` and `seed.sql` again.

---

## Troubleshooting

| Problem | Likely fix |
| ------- | ---------- |
| `Unknown database` on seed | Run `setup.sql` first |
| `????` or garbled Japanese | Set client to `utf8mb4`; reconnect after `setup.sql` |
| `mysql: command not found` | Add MySQL `bin` to PATH or use full path to `mysql.exe` |
| `Cannot add foreign key constraint` | Old tables left over — run full `setup.sql` (drops DB) |
| `CHECK constraint` errors | Upgrade to MySQL 8.0.16+ or MariaDB 10.4+ |

---

## Schema overview

| Table        | Purpose |
| ------------ | ------- |
| departments  | `dept_name`, office `location` |
| employees    | Monthly `salary` (JPY), FK → departments |
| customers    | `city` (Japanese city name), optional `email` |
| books        | `price` (JPY), `stock_qty` |
| orders       | `status`: pending / paid / shipped / cancelled |
| order_items  | Composite PK `(order_id, book_id)` |

```
departments 1──* employees
customers   1──* orders
orders      1──* order_items *──1 books
```

---

## Seed reference (trainers)

See `../TRAINER_NOTES.md` for grading hints and expected query results.

| Concept | Detail |
| ------- | ------ |
| `営業` department | `dept_id` 2 — Exercise 4 |
| Customers in `東京` | 6 |
| `email IS NULL` | customer_id 3, 7, 11, 15 |
| No orders | customer_id 7, 12, 15, 18 |
| Cancelled orders | order_id 7, 17 |
| Zero stock | `未刊行プロトタイプ資料` (`book_id` 20) |
