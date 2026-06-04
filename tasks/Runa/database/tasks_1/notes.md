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
