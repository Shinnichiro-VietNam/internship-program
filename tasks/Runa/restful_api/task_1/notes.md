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
| PATCH  | Update partial (一部更新) | Usually No            | No          |
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
