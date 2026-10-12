# Week 5 Notes

## Exercise 2: What moved where?

### 1. Controllers vs CreateBook

- **コントローラに残るもの:** `authorize`、FormRequest の受け取り、Action の呼び出し、`BookResource` / `httpCreated` / `Location` ヘッダなどの HTTP レスポンス。
- **What stays in the controller:** `authorize`, receiving the FormRequest, calling the Action, and HTTP response work (`BookResource`, `httpCreated`, `Location` header).

- **CreateBook に移したもの:** `Book::create($data)` というデータの作成。
- **What moved into CreateBook:** Creating the book with `Book::create($data)`.

### 2. Why one Action with a single `handle`?

- 1クラス1仕事にすると、何をするクラスか名前だけで分かる。大きな `BookService` に `create` / `update` / `delete` を詰め込むより、変更の影響範囲が小さく読みやすい。
- One class = one job. The class name alone shows what it does. That is clearer than one big `BookService` with many methods, and changes stay smaller.

### 3. Why Query classes for reports (not Actions)?

- レポートは Eloquent の保存ではなく、`DB::table` の集計・読み取り専用クエリ。CRUD の Action と分けた方が書く処理と調べる処理がはっきりする。
- Reports are read-only aggregates with Query Builder, not Eloquent writes. Separating them as Query classes keeps write/change work (Actions) distinct from “look up/report” work.

---

## Exercise 5: Before / after (`store`)

### Before

```php
public function store(StoreBookRequest $request)
{
    $this->authorize('create', Book::class);
    $book = Book::create($request->validated());
    return $this->httpCreated(new BookResource($book))
        ->toResponse($request)
        ->header('Location', route('books.show', $book));
}
```

### After

```php
public function store(StoreBookRequest $request, CreateBook $createBook)
{
    $this->authorize('create', Book::class);
    $book = $createBook->handle($request->validated());
    return $this->httpCreated(new BookResource($book))
        ->toResponse($request)
        ->header('Location', route('books.show', $book));
}
```

---

## Exercise 7: Orders — Option A

注文の一覧・詳細は認証と Policy、eager load くらいで、書き込みや複雑な分岐がなく、今の規模ではコントローラに残しても読みやすく、無理に Action 化するとファイルだけ増える。単純な読み取りでロジックが薄いときは、コントローラに置いたままでOK。

Order list/detail only need auth, policy, and eager loading — no writes or complex branching. At this size, leaving them in the controller stays readable; forcing Actions would add files without much benefit. Simple thin reads can stay in the controller for now.

---

## Final checklist

| #   | Step / request                    | Expect              | Result |
| --- | --------------------------------- | ------------------- | ------ |
| 1   | `migrate:fresh --seed`            | no errors           | OK     |
| 2   | GET /api/books                    | 200                 | OK     |
| 3   | GET /api/books?author=…&page=1    | 200, filtered/paged | OK     |
| 4   | POST /api/books (token)           | 201 + Location      | OK     |
| 5   | PUT /api/books/{id} (token)       | 200                 | OK     |
| 6   | DELETE /api/books/{id} (reader)   | 403                 | OK     |
| 7   | DELETE /api/books/{id} (admin)    | 204                 | OK     |
| 8   | GET /api/orders (no token)        | 401                 | OK     |
| 9   | GET /api/reports/books-never-sold | 200, 3 rows         | OK     |
| 10  | GET /api/reports/book-sales       | 200                 | OK     |

---

## Reflection

### 1. Action vs one BookService

Action の方が「このクラスは何をするか」が名前で分かる。大きな Service にメソッドを増やすより、変更したい処理をファイル単位で開けて直しやすいと感じました。

Actions make the job clear from the class name. It feels easier to open one small file than to dig through a large service with many methods.

### 2. Why Query classes for reports?

レポートは Eloquent の作成・更新ではなく Query Builder の集計読み取り。Actionと Queryを分けると役割がはっきりする。

Reports are read-only Query Builder aggregates, not Eloquent create/update. Splitting Actionsfrom Queries keeps responsibilities clear.

### 3. What not to split further yet

注文の単純な GET や、Auth の login/register はまだ Action にしなくてもいい。処理が短く、HTTP とデータ処理の境目も薄いから、今はコントローラのままで十分読みやすい。

Simple order GETs and auth login/register do not need Actions yet. The logic is short and the HTTP/data boundary is thin, so keeping them in the controller is still readable.
