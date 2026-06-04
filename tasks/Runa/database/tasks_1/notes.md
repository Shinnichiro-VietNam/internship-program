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
