# Database & SQL Tasks 1 (1 Week)

This file contains a **1-week plan**. Focus on correct SQL and understanding **why** each query returns the rows it does, then move to joins, aggregates, and transactions.

**Before you start:** run `schema/setup.sql` and `schema/seed.sql` on your machine. All exercises assume database `internship_bookstore` unless stated otherwise.

**Seed data conventions:**

- Names and cities are **Japanese** (e.g. `田中 太郎`, `東京`, `大阪`).
- `employees.salary` and `books.price` / `order_items.unit_price` are in **JPY (円)**.
- See `schema/README.md` for row counts and sanity-check queries.

---

## Relational Model (Quick Explanation)

- **Table**: rows (records) and columns (attributes) with a fixed schema.
- **Primary key (PK)**: uniquely identifies a row (`emp_id`, `order_id`, composite `(order_id, book_id)` on `order_items`).
- **Foreign key (FK)**: column(s) referencing a PK in another table; enforces **referential integrity**.
- **SQL categories**:
  - **DDL** — define structure (`CREATE`, `ALTER`, `DROP`)
  - **DML** — change data (`INSERT`, `UPDATE`, `DELETE`)
  - **DQL** — query data (`SELECT`)
- **Normalization (high level)**:
  - **1NF**: atomic values, no repeating groups in one column.
  - **2NF**: no partial dependency on a composite key (relevant for `order_items`).
  - **3NF**: non-key columns depend only on the PK, not on other non-key columns (e.g. do not store `dept_name` on `employees` if `dept_id` is enough).

---

## Task List

**Exercise 1: Explore the Schema**

- In `task_1/ex_1.sql`, write queries to:
  1. List all table names in `internship_bookstore` (`SHOW TABLES` or `information_schema`).
  2. For each of the six tables, run `DESCRIBE <table>` (or query `information_schema.COLUMNS`) and save a short summary in `task_1/notes.md`: PK, important columns, and FK relationships.
  3. `SELECT` all columns from `books` ordered by `price` descending.
  4. `SELECT` `full_name`, `city` from `customers` where `city = '東京'`.
- In `notes.md`: draw a simple ER diagram (boxes and arrows) for the six tables.

---

**Exercise 2: Filtering and Sorting**

- In `task_1/ex_2.sql`:
  1. Books with `published_year > 2015` and `stock_qty >= 10`, sorted by `title` ascending.
  2. Employees with monthly `salary` between **400000** and **600000** (JPY, inclusive), active only (`is_active = 1`).
  3. Orders in **2024** with status **not** `cancelled` (use `<>`, `!=`, or `NOT IN` — pick one style and stay consistent).
  4. Customers whose `email` is `NULL`, ordered by `created_at` descending.
  5. Top **3** most expensive books (`ORDER BY price DESC LIMIT 3`).
- Use explicit column lists (not `SELECT *`) for queries 1–5.

---

**Exercise 3: INSERT, UPDATE, DELETE**

- In `task_1/ex_3.sql`, wrap steps 1–4 in a **transaction** and end with `ROLLBACK` if you want to restore seed data (or `COMMIT` if your trainer allows keeping changes):

  ```sql
  START TRANSACTION;
  -- INSERT / UPDATE / DELETE here
  ROLLBACK;   -- or COMMIT;
  ```

  Step 5 (failed `DELETE` on `開発`) can run **outside** the transaction so you can capture the error without rolling it back.
  1. **INSERT** a new department `インターンシップ` in `東京`.
  2. **INSERT** a new employee in that department (Japanese-style `full_name`; unique `email`).
  3. **UPDATE** the book `リーダブルコード`: increase `stock_qty` by **5**.
  4. **DELETE** the employee you inserted in step 2 (by `emp_id` or unique `email`).
  5. Attempt to **DELETE** a department that still has employees (e.g. `開発`) — run it, capture the error message in `notes.md`, explain **why** it failed.
- Document in `notes.md`: difference between `ON DELETE RESTRICT` and `ON DELETE CASCADE` (use `order_items` / `orders` as examples from `setup.sql`).

---

**Exercise 4: INNER JOIN**

- In `task_1/ex_4.sql`:
  1. List each employee’s `full_name`, `email`, `dept_name`, and `location` (join `employees` and `departments`).
  2. List `order_id`, customer `full_name`, `order_date`, and `status` (join `orders` and `customers`).
  3. Order lines: `order_id`, book `title`, `quantity`, `unit_price`, and line total `quantity * unit_price` as `line_total` (join `order_items` and `books`).
  4. Employees in **営業** only (filter on `dept_name` after join, or use `WHERE` on `departments` — note which you chose in `notes.md`).
- Use table **aliases** (`e`, `d`, `o`, etc.) in every query.

---

**Exercise 5: LEFT JOIN and NULL**

- In `task_1/ex_5.sql`:
  1. All customers and their `order_id` if any (**LEFT JOIN** `customers` → `orders`). Include customers with **no** orders (seed has **4** such customers — verify your count).
  2. Count how many customers have **never** placed an order (use `LEFT JOIN` + `WHERE o.order_id IS NULL` or a subquery).
  3. All books and **total quantity sold** (books with no sales → `0`). Join `order_items` → `orders` and **exclude `cancelled` orders**. Use `COALESCE(SUM(oi.quantity), 0)` (or equivalent); document in `notes.md`.
- In `notes.md`: when would you use `INNER JOIN` vs `LEFT JOIN` for reporting?

---

**Exercise 6: Aggregations and GROUP BY**

- In `task_1/ex_6.sql`:
  1. Number of employees per department (`dept_name`, `employee_count`).
  2. Average `salary` per department, rounded to 2 decimal places (MySQL: `ROUND(AVG(salary), 2)`).
  3. Total revenue per order: `SUM(quantity * unit_price)` grouped by `order_id`. Include only orders with **`status <> 'cancelled'`** and at least one line item.
  4. Total quantity sold per book (`book_id`, `title`, `total_qty_sold`). **Exclude `cancelled` orders** (same rule as Exercise 5.3).
  5. Number of orders per customer (`customer_id`, `full_name`, `order_count`) — count **all** orders (any status).

---

**Exercise 7: HAVING vs WHERE**

- In `task_1/ex_7.sql`:
  1. Departments with **more than one** active employee (`HAVING` after `GROUP BY`).
  2. Customers who placed **more than one** non-cancelled order.
  3. Books whose **total sold quantity** is greater than **1** (exclude `cancelled` orders; use `HAVING`, not `WHERE` on a bare column).
  4. Authors with **average book price** above **3500** JPY (among books in catalog).
- In `notes.md`: explain in one paragraph why `HAVING` cannot replace `WHERE` for filtering rows **before** grouping.

---

**Exercise 8: Subqueries**

- In `task_1/ex_8.sql`, solve using subqueries (you may rewrite one query with a join in `notes.md` for comparison):
  1. Books more expensive than the **average** price of all books.
  2. Employees who earn more than the **average salary in their own department** (correlated subquery or join — document approach).
  3. Customers who have at least one order with status `shipped` (use `IN` or `EXISTS`).
  4. The book(s) with the highest `stock_qty` (handle ties: return all tied rows).
- Record time complexity intuition in `notes.md` (not formal Big-O): nested loop vs index lookup when tables grow.

---

**Exercise 9: Multi-Table Reporting**

- In `task_1/ex_9.sql`, write one query each:
  1. **Order summary**: `order_id`, customer name, `order_date`, `status`, **order_total** (sum of line totals), sorted by `order_date` descending.
  2. **Best-selling book**: title and total quantity sold (non-cancelled orders only).
  3. **Customer spend ranking**: `customer_id`, `full_name`, `lifetime_spend` (sum of line totals for `paid` + `shipped` orders), top 5 customers.
  4. **Monthly order count** for **2024**: year-month (`YYYY-MM`) and `order_count` (hint: `DATE_FORMAT(order_date, '%Y-%m')`).
- Comment each query with the business question it answers.

---

**Exercise 10: Indexes and EXPLAIN**

- In `task_1/ex_10.sql`:
  1. Run `EXPLAIN` on a query from Exercise 4 that filters by `employees.email` (e.g. `taro.tanaka@example.co.jp`).
  2. Create an index: `CREATE INDEX idx_employees_hire_date ON employees (hire_date);`  
     (If the index already exists from a previous run, use `DROP INDEX idx_employees_hire_date ON employees;` first, or skip creation and note that in `notes.md`.)
  3. Run `EXPLAIN` on: employees hired after `2023-01-01`, ordered by `hire_date`.
  4. Run `EXPLAIN` on a query joining `order_items` → `orders` → `customers` filtering `customers.city = '東京'`.
- In `notes.md`: paste or summarize `EXPLAIN` output (columns: `type`, `key`, `rows` if shown). In plain language, what might an index improve?

---

**Exercise 11: Transactions**

- In `task_1/ex_11.sql`, simulate placing an order **safely**:
  1. `START TRANSACTION;`
  2. `INSERT` a new row into `orders` for an existing customer (status `pending`).
  3. `INSERT` two rows into `order_items` for that order (existing `book_id`s, valid `quantity` and `unit_price` from `books.price`).
  4. `UPDATE` `books` to decrease `stock_qty` for each book ordered (do not let `stock_qty` go negative — if it would, `ROLLBACK` and document).  
     **Success path:** use books with enough stock (e.g. `リーダブルコード`).  
     **Failure path (second block):** try ordering `未刊行プロトタイプ資料` (`stock_qty = 0`) and `ROLLBACK`.
  5. `COMMIT;` on success.
- Add a second script block that **intentionally fails** (e.g. invalid `book_id`) and show `ROLLBACK` leaves `orders`, `order_items`, and `books` unchanged.
- In `notes.md`: why are transactions important for e-commerce?

---

**Exercise 12: Mini Design + DDL**

- In `task_1/ex_12.sql`:
  1. Design and `CREATE TABLE` **`reviews`**:
     - `review_id` (PK), `book_id` (FK → `books`), `customer_id` (FK → `customers`), `rating` (1–5), `comment` (optional text), `created_at`.
     - Appropriate constraints (`CHECK` or application rule documented in `notes.md`).
  2. `INSERT` at least **3** sample reviews (Japanese comments welcome).
  3. Write a query: average rating per book, only books with **at least 2** reviews.
  4. Write a query: list books with **no** reviews (`LEFT JOIN` + `IS NULL`).
- In `notes.md`: would storing `author` on `reviews` violate normalization? Why or why not?

---

## Optional Stretch (Not Required)

- Create a **VIEW** `v_order_summary` for Exercise 9 query 1 and select from it.
- Add `UNIQUE (customer_id, book_id)` on `reviews` if one review per customer per book — discuss trade-offs.
- Query customers grouped by `city` and rank cities by total `lifetime_spend`.
- Sketch how you would connect to this database from PHP using **PDO** (no code required unless your trainer assigns it).

---

## Notes

- Keep SQL readable: uppercase keywords are optional but be **consistent**; indent joined tables.
- The goal is not only “a result set”, but also **correct reasoning** about joins, nulls, aggregates, and constraints.
- If you break seed data during experiments, re-run `schema/setup.sql` and `schema/seed.sql` (see `schema/README.md`).
