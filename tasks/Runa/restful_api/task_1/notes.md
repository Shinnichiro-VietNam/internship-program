# RESTful API Assignment Notes

## Exercise 1: Concept notes

### 1. What is an API? / APIとは何か？

- An interface that connects software, programs, and web services
- ソフトウェアやプログラム、Webサービスの間をつなぐインターフェースのこと
    - _Hint_: プログラム同士がデータをやり取りするための窓口・仕組み。身近な例：アプリの天気予報データ（気象庁のAPIから取得）、スマホ決済など。

### 2. What is a RESTful API? / RESTful APIとは何か？

- An HTTP interface for a web system built in accordance with REST principles.
- RESTの原則に則って構築されたWebシステムのHTTPでの呼び出しインターフェースのこと。

### 3. Six REST constraints / 6つのREST制約

1. **Client–server**:
    - Completely separate the team responsible for building the interface from the team responsible for managing the data.
    - 画面を作る側と、データを管理する側を完全に分ける。
2. **Stateless**:
    - It is a stateless client-server protocol based on HTTP. It does not manage state, such as sessions, and the information exchanged must be self-contained and interpretable on its own.
    - HTTPをベースにしたステートレスなクライアント/サーバプロトコルであること。セッション等の状態管理はせず、やり取りされる情報はそれ自体で完結して解釈できること。
3. **Cacheable**
    - The client may temporarily store and reuse the response returned by the server.
    - クライアントは、サーバーから返ってきたレスポンスを一時的に保存して再利用していい
4. **Uniform interface**
    - All data operations (retrieval, creation, update, and deletion) must use HTTP methods (GET, POST, PUT, DELETE).
    - 情報の操作(取得、作成、更新、削除)は全てHTTPメソッド(GET、POST、PUT、DELETE)を利用すること。
5. **Layered system**
    - Even if other systems, such as proxies or load balancers, are interposed between the client and the server, the client can communicate as usual without being aware of them.
    - クライアントとサーバーの間に、プロキシやロードバランサーなどの別システムが挟まっても、クライアントはそれを意識せずに同じように通信できる。
6. **Code on demand**
    - Sending a program from the server to the client and having it executed on the client side.
    - サーバーからプログラムをクライアントに送り、クライアント側で実行させること。

### 4. Why noun URLs? Why status codes instead of always 200? / なぜURLに名詞を使うのか？なぜ常に200を返してはいけないのか？

- **Noun URLs**:
    - URLs should represent resources, not actions. Combining nouns with HTTP methods keeps the API simple and clean.
    - URLは住所を表す場所だから。動詞を入れるとURLが無限に増えてややこしくなる。URLは名詞にして、動詞と組み合わせるのがシンプルで綺麗。
- **Status codes**:
    - Status codes let programs instantly understand the result without reading the JSON body. Always returning 200 makes error handling inefficient.
    - 中身のテキストを全部読まなくても、3桁の数字を見るだけで成功かエラーかをプログラムが一瞬で判断できるようにするため。

### 5. HTTP Methods Comparison / HTTPメソッドの比較

| Method | Purpose (目的)            | Idempotent (べき等性) | Safe (安全) |
| ------ | ------------------------- | --------------------- | ----------- |
| GET    | Read (読み取り)           | Yes                   | Yes         |
| POST   | Create (作成)             | No                    | No          |
| PUT    | Replace full (全置換)     | Yes                   | No          |
| PATCH  | Update partial (一部更新) | Usually               | No          |
| DELETE | Remove (削除)             | Yes                   | No          |

---

## Exercise 2: Status codes

| #   | Scenario                                     | Method | Status Code | Reason             |
| --- | -------------------------------------------- | ------ | ----------- | ------------------ |
| 1   | List all books                               | GET    | 200         | Success            |
| 2   | Get book `99`                                | GET    | 404         | Not found          |
| 3   | Create valid book                            | POST   | 201         | Created            |
| 4   | Create with invalid JSON                     | POST   | 400         | Bad request        |
| 5   | Delete existing book                         | DELETE | 204         | No content         |
| 6   | `POST /api/books/5` (not in your API design) | POST   | 405         | Method not allowed |

---

# Exercise 3

| #   | Request            | Expect | Status        | Note                                               |
| --- | ------------------ | ------ | ------------- | -------------------------------------------------- |
| 1   | GET /api/health    | 200    | 200 OK        | {"status":"ok"} が返ることを確認                   |
| 2   | GET /api/books     | 200    | 200 OK        | 本の一覧が配列で返ることを確認                     |
| 3   | GET /api/books/1   | 200    | 200 OK        | IDが1の本が1件だけ返ることを確認                   |
| 4   | GET /api/books/999 | 404    | 404 Not Found | NOT_FOUND エラーが返ることを確認                   |
| 5   | POST /api/books    | 201    | 201 Created   | 新しい本が登録され、IDが自動で採番されることを確認 |

---

# Exercise 4: API Design

## 1. エンドポイント一覧 (Endpoints)

| Method | Path              | What it does                                                                  | Success | Response                                           |
| :----- | :---------------- | :---------------------------------------------------------------------------- | :------ | :------------------------------------------------- |
| GET    | `/api/books`      | 本の一覧を取得する Get a list of books                                        | 200     | 本の配列 Book Arrangement                          |
| GET    | `/api/books/{id}` | 特定の本の情報を取得する Retrieve information about a specific book           | 200     | 本1冊のオブジェクト　A book object                 |
| POST   | `/api/books`      | 新しい本を登録する Register a new book                                        | 201     | 登録された本のオブジェクト Registered book objects |
| PUT    | `/api/books/{id}` | 本のすべての情報を丸ごと上書きする Overwrite the entire contents of the book. | 200     | 更新後の本のオブジェクト　Updated book object      |
| PATCH  | `/api/books/{id}` | 本の一部だけを更新する Only a portion of the book will be updated.            | 200     | 更新後の本のオブジェクト Updated book object       |
| DELETE | `/api/books/{id}` | 本を削除する Delete a book                                                    | 204     | なし No                                            |

## 2. バリデーションルール (Validation Rules)

本を登録（POST）したり更新（PUT/PATCH）したりするとき、条件を満たさないデータが送られてきたらエラーにする。When registering (POST) or updating (PUT/PATCH) books, an error should be generated if data that does not meet the specified conditions is sent.

- `title`: 必須 Required　(空文字✕　empty string ✕)
- `author`: 必須 Required (空文字✕　empty string ✕)
- `price`: price > 0 （0より大きい整数 integer greater than 0）
- `stock_qty`: stock_qty >= 0 （0以上の整数 integer greater than or equal to 0）

## 3. エラーレスポンスの形式 (Error JSON Shape)

エラー（400や404など）が発生したときは、シンプルなJSON形式でクライアントに返事をする。
When an error occurs (such as 400 or 404), a simple JSON response is sent to the client.

```json
{
    "error": {
        "code": "BAD_REQUEST",
        "message": "Need to positive number"
    }
}
```

---

# Exercise 8

| #   | Request                   | Expect | Status          | Summary / Note                                       |
| --- | ------------------------- | ------ | --------------- | ---------------------------------------------------- |
| 5   | POST /api/books           | 201    | 201 Created     | 本が登録されLocationヘッダーが返ることを確認         |
| 6   | PUT /api/books/2          | 200    | 200 OK          | 指定したIDの本がすべて上書きされることを確認         |
| 7   | PATCH /api/books/2        | 200    | 200 OK          | 送った項目だけが更新されることを確認                 |
| 8   | DELETE /api/books/2       | 204    | 204 No Content  | データが削除され、中身が空で返ることを確認           |
| 9   | POST /api/books (Invalid) | 400    | 400 Bad Request | バリデーションに引っかかりエラーJSONが返ることを確認 |

## Reflection

### Q1. Auth later? (認証は後回しでよかった？)

- First, we needed to make sure the core CRUD functionality works perfectly. Delaying authentication helped focus on the basic API logic without unnecessary complexity.
- まずはAPIの基本機能を確実に動かすことが最優先なので、認証を後回しにして正解。

### Q2. JSON file vs SQL books table? (JSONファイルとSQLテーブルの違いは？)

- JSON files are easy to use for small projects, but they read and write the whole file every time, which becomes slow with large data. SQL databases handle massive data efficiently, securely, and support complex relations.
- JSONファイルは手軽ですが、データが増えると毎回全読み書きが発生するため遅くなる。SQLを使えば、大量のデータでも高速・安全に管理できます。

### Q3. What would Laravel change (high level)? (Laravelを使ったら何が変わる？)

- Laravel would handle routing, automatic JSON parsing, request validation, and database operations out of the box. This would dramatically reduce the amount of boilerplate code we had to write manually.
- URLの判定やバリデーション、JSONの変換、データの保存処理などをLaravelがすべて自動でやってくれるため、手書きするコードの量が劇的に減る。
