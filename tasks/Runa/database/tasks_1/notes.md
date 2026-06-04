# Exercise 1: Explore the Schema

## 1. テーブル構造のまとめ (Table Summary)

- **departments** (部署)
    - 主キー(PK): dept_id
    - 外部キー(FK): なし
    - 説明: 会社内の部署（開発、営業など）と場所を管理。
    - Description: Manages company departments and locations.

- **employees** (社員)
    - 主キー(PK): emp_id
    - 外部キー(FK): dept_id
    - 説明: 社員の名前、メール、給与、所属部署を管理。
    - Description: Manages employee details, salaries, and department assignments.

- **customers** (顧客)
    - 主キー(PK): customer_id
    - 外部キー(FK): なし
    - 説明: 本を購入する顧客の名前や住んでいる都市を管理。
    - Description: Manages customer profiles and cities.

- **books** (本)
    - 主キー(PK): book_id
    - 外部キー(FK): なし
    - 説明: 書籍のタイトル、著者、価格、在庫数を管理。
    - Description: Manages book titles, authors, prices, and stock quantities.

- **orders** (注文)
    - 主キー(PK): order_id
    - 外部キー(FK): customer_id
    - 説明: 誰が、いつ、どんな状態で注文したかを管理。
    - Description: Manages order creation dates and statuses.

- **order_items** (注文明細)
    - 主キー(PK): (order_id, book_id) 2つの組み合わせによる複合主キー
    - 外部キー(FK):
        - order_id (references orders.order_id)
        - book_id (references books.book_id)
    - 説明: どの注文で、どの本が、何冊、いくらで売れたかの詳細を管理。
    - Description: Manages the details of books sold in each order.

---

## ER図

[departments] 1 ───> \* [employees]

[customers] 1 ───> _ [orders] 1 ───> _ [order_items] \* <─── 1 [books]

# ex_3.spl

## 5. 開発部署の削除エラーについて / Deletion Error

**エラーメッセージ / Error Message**

**エラーメッセージ / Error Message**

```sql
Cannot delete or update a parent row: a foreign key constraint fails
(`internship_bookstore`.`employees`,
 CONSTRAINT `fk_employees_department`
 FOREIGN KEY (`dept_id`)
 REFERENCES `departments` (`dept_id`)
 ON DELETE RESTRICT
 ON UPDATE CASCADE)
```

**なぜ失敗したのか / Why it failed**

開発部署に所属している社員のデータがまだ残っているため。

Because employee records that belong to the Development department still exist.

部署を先に削除すると、社員がどの部署に所属しているかわからなくなってしまう。

If the department is deleted first, the employee records would lose their department reference.

そのため、外部キー制約によって削除が禁止された。

Therefore, the foreign key constraint prevented the deletion.

---

# 6. RESTRICT と CASCADE の違い / Difference Between RESTRICT and CASCADE

## ON DELETE RESTRICT

親データに関連する子データがある場合、削除できない。

A parent record cannot be deleted if related child records still exist.

**例 / Example**

- 部署に社員がいる
- There are employees in a department
- → 部署は削除できない
- → The department cannot be deleted

データを誤って消さないための安全な設定。

This is a safe setting that helps prevent accidental data loss.

---

## ON DELETE CASCADE

親データを削除すると、関連する子データも自動で削除される。

When a parent record is deleted, all related child records are automatically deleted as well.

**例 / Example**

- 注文を削除する
- Delete an order
- → その注文の注文明細も自動で削除される
- → The related order items are also deleted automatically

関連データをまとめて削除したい場合に便利。

This is useful when you want to remove related data at the same time.

---

# Exercise 4: INNER JOIN

## 4. 営業部社員の絞り込みについて / Filtering Employees in the Sales Department

- **選んだ方法 / Chosen Approach**
    - `INNER JOIN` でテーブルを結合した後、`WHERE d.dept_name = '営業'` を使用して営業部の社員だけを絞り込んだ。
    - I chose to join the tables using `INNER JOIN` and then filter the results with `WHERE d.dept_name = '営業'`.

- **理由 / Reason**
    - SQLの基本的な流れ（結合 ➔ 絞り込み）に沿っており、コードがシンプルで読みやすいため。
    - This follows the standard SQL workflow (JOIN → FILTER), making the query simple and easy to read.

    - また、どの条件で結果を絞り込んでいるのかが明確になり、保守もしやすくなる。
    - It also makes the filtering condition clear and improves maintainability.

---

# Exercise 5: LEFT JOIN and NULL

## 3. 売れた合計冊数の集計について / Book Sales

- **工夫した点 / Approach**
    - `COALESCE` を使って、売れていない本も `0` と表示した。
    - Used `COALESCE` so unsold books are shown as `0`.

    - キャンセルされた注文は集計に含めていない。
    - Excluded cancelled orders from the total sales count.

---

## 4. INNER JOIN と LEFT JOIN の違い / INNER JOIN vs LEFT JOIN

### INNER JOIN

- 両方のテーブルにあるデータだけ表示する。
- Shows only matching data from both tables.

**例 / Example**

- 社員と所属部署
- Employees and their departments

---

### LEFT JOIN

- 左側のテーブルのデータをすべて表示する。
- Shows all records from the left table.

- 関連データがない場合は `NULL` になる。
- If no matching data exists, the result is `NULL`.

**例 / Example**

- 注文していない顧客
- Customers with no orders

- まだ売れていない本
- Books with no sales

---

# Exercise 7: HAVING vs WHERE

## 5. HAVING が WHERE の代わりにならない理由 / Why HAVING Cannot Replace WHERE

- `WHERE` は集計する前にデータを絞り込む。
- `WHERE` filters data before grouping.

- `HAVING` は集計した後に結果を絞り込む。
- `HAVING` filters results after grouping.

- `WHERE` を使うと、最初から不要なデータを除外できる。
- `WHERE` removes unnecessary data before processing.

- `HAVING` だけを使うと、不要なデータまで集計してしまう。
- Using only `HAVING` means extra data is grouped unnecessarily.

- そのため、処理が遅くなったり効率が悪くなったりする。
- This can make queries slower and less efficient.

**流れ / Order**

1. `WHERE`
2. `GROUP BY`
3. `HAVING`

---

# Exercise 8: Subqueries

## 2. クエリ2を JOIN で書いた場合の別解 / Rewrite with JOIN

```sql
SELECT e.full_name, e.salary, e.dept_id
FROM employees AS e
INNER JOIN (
    SELECT dept_id, AVG(salary) AS avg_sal
    FROM employees
    GROUP BY dept_id
) AS dept_avg
ON e.dept_id = dept_avg.dept_id
WHERE e.salary > dept_avg.avg_sal;
```

### 説明 / Explanation

- 部署ごとの平均給与を求めるサブクエリを作成する。
- Create a subquery that calculates the average salary for each department.

- `INNER JOIN` で社員データと平均給与を結合する。
- Join employee data with the department averages using `INNER JOIN`.

- 自分の部署の平均給与より高い社員だけを表示する。
- Show only employees whose salary is higher than their department's average salary.

- サブクエリ版と同じ結果になる。
- This produces the same result as the subquery version.

---

# Exercise 10: Indexes and EXPLAIN

## 1〜4. EXPLAIN の結果まとめ / EXPLAIN Output Summary

### クエリ1 (email検索) / Query 1 (Search by Email)

- `type`: `ALL` または `const`
- `key`: `NULL` または email のインデックス

### クエリ3 (hire_date検索) / Query 3 (Search by Hire Date)

- `type`: `range`
- `key`: `idx_employees_hire_date`

### クエリ4 (3テーブル結合) / Query 4 (3-Table Join)

- `type`: `eq_ref`、`ref`、または `ALL`
- `key`: `PRIMARY` や外部キーのインデックス

---

## 5. インデックス（索引）のメリット / Benefits of Indexes

- インデックスは本の「索引」と同じ。
- An index is like the index of a book.

- インデックスがないと、全データを順番に探す必要がある。
- Without an index, the database checks all rows one by one.

- インデックスがあると、必要なデータをすぐ見つけられる。
- With an index, the database can find data much faster.

- 検索速度が速くなる。
- Queries run faster.

- データベースの負担を減らせる。
- It reduces database workload.

---

# Exercise 11: Transactions

## 4. ECサイトでトランザクションが重要な理由 / Why Transactions Are Important in E-commerce

- トランザクションは、複数の処理をまとめて安全に実行する仕組み。
- A transaction is a way to run multiple operations safely as one unit.

---

### なぜ必要か / Why it is needed

- ECサイトでは「注文・支払い・在庫更新」がセットで動く。
- In e-commerce, order, payment, and stock updates happen together.

- 途中で1つでも失敗すると、データがバラバラになる可能性がある。
- If one step fails, data can become inconsistent.

---

### トランザクションの役割 / Role of Transactions

- すべて成功したら確定（COMMIT）
- If everything succeeds, changes are saved (COMMIT)

- 1つでも失敗したら全部戻す（ROLLBACK）
- If anything fails, everything is undone (ROLLBACK)

---

### まとめ / Summary

- データの矛盾を防ぐために必要
- Prevents data inconsistency

- お金や在庫を安全に管理できる
- Keeps money and inventory data safe and reliable
