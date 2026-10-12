## Eloquent Relationships Reflection

- **hasMany**: 1つのモデルが他の複数のモデルと紐づく関係を作るために使用した。
- **hasMany**: Used to create a relationship where one model is linked to multiple other models.
- **belongsTo**: 子モデルが特定の親モデルに属する関係を作るために使用した。
- **belongsTo**: Used to create a relationship where a child model belongs to a specific parent model.
- **with()**: リレーション先のデータを一度のクエリでまとめて取得して、データベースへのアクセス回数を減らしてN+1問題を回避するために使用した。
- **with()**: Used to retrieve related data in a single query, reducing the number of database accesses and avoiding the N+1 problem.

## Exercise 8: Test Checklist

| #   | Request                          | Expect                |
| --- | -------------------------------- | --------------------- |
| 1   | POST /api/books (missing title)  | 400, BAD_REQUEST      |
| 2   | GET /api/books                   | 200, plain array      |
| 3   | GET /api/books?page=1&per_page=5 | 200, data + meta      |
| 4   | GET /api/orders/1                | 200, customer + items |
| 5   | GET /api/books/1/order-items     | 200                   |
| 6   | GET /api/books/9999/order-items  | 404                   |

## Reflection

### 1. What moved from controller → Form Request → Resource?

バリデーションのルールやエラー時の400レスポンスの処理がコントローラーからForm Requestへと移動た。また、取得したデータを出力用に整形するという処理がResourceへと移動た。これにより、コントローラーはデータの取得と保存の命令という本来の役割だけに集中できるようになり、コードの可読性が向上した。

Validation rules and handling of 400 errors have moved from the controller to the Form Request. Also, the process of formatting retrieved data for output has moved to the Resource. This allows the controller to focus solely on its primary role of retrieving and saving data, improving code readability.

### 2. Compare with() and load() and loadMissing() for GET /api/orders/1.

- **with()**: クエリを発行する段階で、リレーション先のデータを一緒にまとめて取得する。
- **with()**: Retrieves related data together with the query at the query stage.
- **load()**: すでに取得済みのモデルインスタンスに対して、後からリレーションデータを追加で取得する。
- **load()**: Retrieves additional related data for a model instance that has already been retrieved.
- **loadMissing()**: `load()`と似ているけど、そのデータがまだ読み込まれていない場合のみ追加で取得するため、無駄なクエリの発行を防ぐことができる。
- **loadMissing()**: Similar to `load()`, but only retrieves additional data if it hasn't already been loaded, preventing unnecessary queries.
