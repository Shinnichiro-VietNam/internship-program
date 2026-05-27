# Database & SQL Assignment for Interns

Welcome! This module introduces **relational databases** and **SQL**. You will design tables with constraints, write queries from simple filters to multi-table joins and aggregations, and practice transactions and basic performance awareness.

**Important Note:**
For the best interest of trainees to gain the most from the internship program.
Using AI tools (e.g., ChatGPT, GitHub Copilot) is strictly limited. Consult your trainer first before using any AI assistance to ensure proper learning and compliance.

---

## 📁 Files in this module

| File / folder           | Purpose                                    |
| ----------------------- | ------------------------------------------ |
| `README.md` (this file) | How to work on the module                  |
| `tasks_1.md`            | **1-week exercise list** (Exercises 1–12)  |
| `schema/setup.sql`      | Creates database and tables (run first)    |
| `schema/seed.sql`       | Sample data in Japanese / JPY (run second) |
| `schema/README.md`      | Setup, verify, and reset instructions      |

Create your work in `task_1/` (not provided — you create it on your branch).

---

## 📂 Assignments

1. **Project Structure**
   - Read this `README.md` and `tasks_1.md`.
   - Create a folder `task_1/` under `tasks/Runa/database/` on **your intern branch**.
   - Put your SQL solutions in `task_1/` (e.g., `ex_1.sql`, `ex_2.sql`, …, `ex_12.sql`).
   - Add `task_1/notes.md` with:
     - Answers to reflection questions in the tasks
     - `EXPLAIN` summaries for Exercise 10 (if your trainer asks)

2. **Database Setup**
   - Run `schema/setup.sql`, then `schema/seed.sql` — see `schema/README.md`.
   - Database name: `internship_bookstore`.
   - Seed data uses **Japanese names and cities** and **JPY (円)** for money columns.
   - Use **UTF-8 (`utf8mb4`)** in your SQL client so Japanese text displays correctly.
   - **Do not** change files under `schema/` for graded work; only change `task_1/`.

3. **Rules for SQL**
   - Write SQL **by hand** for each exercise.
   - One file per exercise; label sections with comments (e.g., `-- Exercise 4a`).
   - Target **MySQL 8** or **MariaDB 10.4+** (same syntax as the setup scripts).
   - Prefer explicit column lists in `SELECT` unless the task allows `SELECT *`.
   - When counting **sales** or **quantities sold**, exclude **`cancelled`** orders unless the task says otherwise (join `orders` and filter `status`).

4. **How to Run**

   From the `database` folder:

   ```bash
   mysql -u root -p < schema/setup.sql
   mysql -u root -p < schema/seed.sql
   ```

   Run one exercise file:

   ```bash
   mysql -u root -p internship_bookstore < task_1/ex_1.sql
   ```

   Or paste statements into MySQL Workbench, DBeaver, or phpMyAdmin.

5. **Prerequisites**
   - **Basic Programming** module completed (or in progress with trainer approval).
   - **Algorithms** / **Data Structures** are helpful but not required.
   - Later: **OOP** and **SOLID**, then PHP with **PDO**, will connect application code to a database.

6. **If something goes wrong**
   - **Garbled Japanese** → set connection charset to `utf8mb4`.
   - **Table doesn't exist** → run `setup.sql` before `seed.sql`.
   - **Broken data after experiments** → run `setup.sql` and `seed.sql` again (see `schema/README.md`).
   - **FK error on DELETE** → expected in Exercise 3; document the message in `notes.md`.

---

## 📚 Resources

- [Database Introduction](https://hnavi.co.jp/knowledge/blog/sql/)
- [W3Schools SQL Tutorial](https://www.w3schools.com/sql/)
- [MySQL 8 Reference Manual](https://dev.mysql.com/doc/refman/8.0/en/)
- [MariaDB Knowledge Base](https://mariadb.com/kb/en/documentation/)

---

## ✅ Expected Results

By completing this module, you should be able to:

- Explain tables, primary keys, foreign keys, and referential integrity.
- Write `SELECT` queries with `WHERE`, `ORDER BY`, `LIMIT`, and `DISTINCT`.
- Insert, update, and delete rows while respecting constraints.
- Join tables with `INNER JOIN` and `LEFT JOIN` and choose the correct join type.
- Use `GROUP BY`, aggregate functions, and `HAVING` to summarize data.
- Write subqueries and combine them with joins where appropriate.
- Create indexes and read a basic `EXPLAIN` plan.
- Use transactions with `COMMIT` and `ROLLBACK` for multi-step changes.
- Discuss 1NF / 2NF / 3NF at a high level and avoid obvious redundancy in simple designs.
