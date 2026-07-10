# System Design / Architecture — Notes

**Name:**

- Runa Akitake

**Date completed:**

- June 22

---

## Exercise 1 — Layered architecture

1. What is layered architecture?
   Layered architecture is a design pattern that organizes an application's code into distinct chronological layers, where each layer has a specific responsibility. Components within a layer can only communicate with layers beneath them, which promotes a one-way dependency. This strict separation of concerns makes the system much easier to maintain, modify, and test over time.

1. 階層型アーキテクチャとは?
   アプリケーションのコードを明確な時系列上の階層に整理する設計パターンであり、各階層はそれぞれ特定の役割を担う。ある階層内のコンポーネントは、その下位の階層とのみ通信できるため、一方向の依存関係が維持される。このように関心が厳密に分離されているため、システムの保守、変更、テストが長期にわたって容易になる。

---

2. Four classic layers and their roles:

- **UI Layer** Handles presentation concerns, processes incoming HTTP requests, session data, and query parameters, ensuring these technology-specific details do not leak into deeper layers.
- **Application Layer** Coordinates domain objects to fulfill specific use cases or user stories without containing business rules or direct data persistence technology.
- **Domain Layer** Expresses the core business rules, specifications, and data models of the application, completely isolated from both the UI and infrastructure technologies.
- **Infrastructure Layer** Manages the technical implementation of data persistence, such as database operations, memory caching, and mapping external data back into domain objects.

2. 4つの代表的なレイヤーとその役割：

- **UIレイヤー** プレゼンテーションに関する事項を処理し、受信HTTPリクエスト、セッションデータ、クエリパラメータを処理する。これらの技術固有の詳細が下位レイヤーに漏洩しないようにする。

- **アプリケーションレイヤー** ビジネスルールや直接的なデータ永続化技術を含まず、特定のユースケースやユーザーストーリーを満たすようにドメインオブジェクトを調整する。

- **ドメインレイヤー** アプリケーションの中核となるビジネスルール、仕様、データモデルを表現し、UIおよびインフラストラクチャ技術から完全に分離される。

- **インフラストラクチャレイヤー** データベース操作、メモリキャッシュ、外部データをドメインオブジェクトにマッピングするなど、データ永続化の技術的な実装を管理する。

3. Diagram:
   [UI]
   │ (Calls)
   ▼
   [Application]
   │ (Calls)
   ▼
   [Domain]
   │ (Calls)
   ▼
   [Infrastructure]

---

## Exercise 2 — MVC

1. Definitions:

- **Model:** Handles data and database rules.
- **View:** Handles the screen and output (HTML/JSON).
- **Controller:** Connects everything (takes requests, calls Model, sends to View).

1. 定義：

- **モデル**：データとデータベースルールを管理する。

- **ビュー**：画面表示と出力（HTML/JSON）を管理する。

- **コントローラー**：すべてを接続する（リクエストを受け取り、モデルを呼び出し、ビューに渡す）。

2. Pattern for Laravel:

- **MVC**, because Laravel is built exactly as an MVC framework by default (Models, Views, and Controllers).

2. Laravelのパターン：

- **MVC**：LaravelはデフォルトでMVCフレームワーク（モデル、ビュー、コントローラー）として構築されているため。

3. Optional (MVVM & MVP):

- **MVVM:** Used in frontend with automatic data syncing.
- **MVP:** Used in apps where the Presenter completely controls a passive View.

3. オプション（MVVMとMVP）：

- **MVVM**：自動データ同期を行うフロントエンドで使用する。

- **MVP**：プレゼンターが受動的なビューを完全に制御するアプリケーションで使用する。

---

## Exercise 3 — Books API

1. Examples from my API for each layer:

- **Presentation:** Checking `$method` and `$uri` to route requests, and returning JSON using `echo json_encode()`.
- **Business:** Validating requested data, such as checking `empty($data['title'])` or verifying if `$data['price'] <= 0`.
- **Data:** Fetching and saving book records via `file_get_contents($jsonPath)` and `file_put_contents($jsonPath)`.

1. 各レイヤーにおけるAPIの例：

- **プレゼンテーション層:** リクエストをルーティングするために`$method`と`$uri`をチェックし、`echo json_encode()`を使用してJSONを返す。

- **ビジネス層:** リクエストされたデータの検証を行います。例えば、`empty($data['title'])`をチェックしたり、`$data['price'] <= 0`を検証したりする。

- **データ層:** `file_get_contents($jsonPath)`と`file_put_contents($jsonPath)`を使用して書籍レコードを取得、保存する。

2. Is it layered yet?

- No, it is currently contained in a single file where HTTP routing, business validation rules, and JSON file persistent data storage are all grouped and executed together.

2. レイヤー化は完了しているか？

- いいえ、現在はHTTPルーティング、ビジネス検証ルール、JSONファイルによる永続データ保存がすべて1つのファイルにまとめられ、まとめて実行されている。

---

## Exercise 4 — Monolith vs microservices

1. Definitions:

- **Monolith:** An architectural pattern where all features and components of an application are bundled and deployed together as a single unit.
- **Microservices:** An architectural pattern where an application is split into multiple small, independent services that communicate over a network.

1. 定義：

- **モノリス:** アプリケーションのすべての機能とコンポーネントを単一のユニットとしてまとめてデプロイするアーキテクチャパターン。

- **マイクロサービス:** アプリケーションを複数の独立した小さなサービスに分割し、ネットワーク経由で通信させるアーキテクチャパターン。

2. Pros and Cons:

- **Monolith Pro:** Easy to develop, test, and deploy at the beginning.
- **Monolith Con:** Becoming large and complex makes code changes slower and partial updates difficult.
- **Microservices Pro:** Highly scalable and allows different teams to develop and deploy services independently.
- **Microservices Con:** High complexity in system deployment, monitoring, and network communication overhead.

2. メリットとデメリット：

- **モノリスのメリット:** 初期段階では開発、テスト、デプロイが容易。

- **モノリスのデメリット:** 規模が大きくなり複雑化すると、コードの変更が遅くなり、部分的な更新が困難になる。

​​ **マイクロサービスのメリット:** 拡張性が高く、異なるチームが独立してサービスを開発・デプロイできる。

- **マイクロサービスのデメリット:** システムのデプロイ、監視、ネットワーク通信のオーバーヘッドが大きくなる。

3. Is your Books API a monolith?

- **Yes** because all endpointsand functions run together within one single codebase and execution environment.

​​3. あなたのBooks APIはモノリスですか？

- **はい** なぜなら、すべてのエンドポイントと機能が単一のコードベースと実行環境内で連携して動作するから。

4. Bonus (Difference between Layered and Monolith/Microservices):

- Layered architecture is about how you organize code _inside_ an application, while monolith vs microservices is about how you split and deploy the system _physically_ across servers.

4. ボーナス（レイヤードアーキテクチャとモノリス／マイクロサービスアーキテクチャの違い）：

- レイヤードアーキテクチャは、アプリケーション内部のコードの構成方法に関するもので、モノリスアーキテクチャとマイクロサービスアーキテクチャは、システムを物理的にサーバー間でどのように分割・展開するかに関するもの。

---

## Exercise 5 — Request lifecycle

1. Five main steps from request to response:

- **1. Entry (`public/index.php`):** The starting point for all requests, loading the Composer autoloader.
- **2. HTTP Kernel:** Loads basic environment configurations and handles error logging.
- **3. Service Providers:** Bootstraps and configures all core components of the framework.
- **4. Routing & Middleware:** Filters the request (e.g., authentication) and finds the matching controller.
- **5. Controller & Response:** Executes the logic and returns a proper JSON or view response.

1. リクエストからレスポンスまでの5つの主要ステップ：

- **1. エントリ（`public/index.php`）：** すべてのリクエストの開始点であり、Composerオートローダーをロードする。

- **2. HTTPカーネル：** 基本的な環境設定をロードし、エラーログを処理する。

- **3. サービスプロバイダ：** フレームワークのすべてのコアコンポーネントをブートストラップおよび構成する。

- **4. ルーティングとミドルウェア：** リクエストをフィルタリングし（認証など）、対応するコントローラを見つける。

- **5. コントローラとレスポンス：** ロジックを実行し、適切なJSONまたはビューレスポンスを返す。

2. Where do middleware and routing fit in?

- They sit between Step 3 (Service Providers) and Step 5 (Controller), filtering the request right before it hits the application logic.

2. ミドルウェアとルーティングはどこに位置づけられるのか？

- ステップ3（サービスプロバイダとステップ5（コントローラ）の間に位置し、アプリケーションロジックに到達する直前にリクエストをフィルタリングする。

3. Optional (Laravel vs plain PHP index.php):

- **Automatic Routing:** Plain PHP requires manual URL string parsing, while Laravel handles complex URLs automatically via a dedicated router.
- **Global Middleware:** Laravel has a clean pipeline structure to filter requests globally, unlike plain PHP where checks must be hardcoded inside conditional logic.

3. オプション（Laravel vs プレーンなPHP index.php）：

- **自動ルーティング:** プレーンなPHPではURL文字列の解析を手動で行う必要があるが、Laravelは専用ルーターを介して複雑なURLを自動的に処理する。

- **グローバルミドルウェア:** Laravelは、プレーンなPHPのように条件ロジック内にチェックをハードコーディングする必要がなく、リクエストをグローバルにフィルタリングするためのクリーンなパイプライン構造を備えている。

---

## Exercise 6 — Providers and container

1. What does a service provider do?

- A service provider acts as the central bootstrapping agent that binds and configures core services and classes into Laravel's service container.

1. サービスプロバイダの役割とは？

- サービスプロバイダは、コアサービスとクラスをLaravelのサービスコンテナにバインドして設定する中心的なブートストラップエージェントとして機能する。

2. Difference between `register()` and `boot()`:

- **`register()`:** Used exclusively to bind services to the container, and you must not call other services here because they might not be loaded yet.
- **`boot()`:** Called after all services are registered, allowing you to safely call methods and use any services configured by the framework.

2. `register()`と`boot()`の違い：

- **`register()`:** サービスをコンテナにバインドするためだけに使用されます。まだロードされていないサービスがあるため、ここで他のサービスを呼び出すことはできない。

- **`boot()`:** すべてのサービスが登録された後に呼び出され、フレームワークによって設定されたメソッドを安全に呼び出し、サービスを使用できるようになる。

3. What is the service container / dependency injection?

- The service container is a powerful tool for managing class dependencies and performing dependency injection automatically. Instead of manually creating instances with `new`, the container automatically resolves and injects required objects into your classes. This drastically reduces tight coupling between different parts of your application.

3. サービスコンテナ／依存性注入とは？

- サービスコンテナは、クラスの依存関係を管理し、依存性注入を自動的に実行するための強力なツールです。`new`でインスタンスを手動で作成する代わりに、コンテナは必要なオブジェクトを自動的に解決し、クラスに注入します。そして、アプリケーションの異なる部分間の密結合が大幅に軽減される。

4. Connection to DIP from SOLID:

- It connects to DIP by allowing us to bind abstract interfaces to concrete implementations in the container, ensuring that high-level logic depends on abstractions rather than hardcoded, low-level classes.

4. SOLIDからDIへの関連性：

- コンテナ内で抽象インターフェースを具体的な実装にバインドすることで、高レベルのロジックがハードコードされた低レベルクラスではなく抽象化に依存するようにし、DIPとの関連性を実現する。

---

## Exercise 7 — Facades

1. What is a Laravel facade?

- A Laravel facade is a static-like proxy interface that provides easy access to underlying services registered inside the service container.

1. Laravelのファサードとは？

- Laravelのファサードは、サービスコンテナに登録された基盤となるサービスへの容易なアクセスを提供する、静的メソッドのようなプロキシインターフェース。

2. Facade vs Constructor Injection (One advantage each):

- **Facade Advantage:** Extremely convenient and fast to write, allowing you to call services anywhere in one line without declaring dependencies in a constructor.
- **Constructor Injection Advantage:** Makes a class's dependencies clear and explicit, making the code more predictable and much easier to test with mocks.

2. ファサードとコンストラクタインジェクションの比較（それぞれの利点）：

- **ファサードの利点：** 非常に便利で高速なコード記述が可能で、コンストラクタで依存関係を宣言することなく、1行で任意の場所からサービスを呼び出すことができる。
- **コンストラクタインジェクションの利点：** クラスの依存関係が明確かつ明示的になるため、コードの予測可能性が高まり、モックを使ったテストがはるかに容易になる。

---

## Final reflection

1. Two things Laravel handles automatically:

- **Routing:** Laravel automatically parses URLs and HTTP methods to find the right controller, removing the need for manual `$_SERVER['REQUEST_URI']` and `str_starts_with` checks.
- **JSON Input/Output Handling:** Laravel automatically parses incoming JSON payloads and sets proper response headers (`Content-Type: application/json`), replacing manual `file_get_contents('php://input')` and `header()` calls.

1. Laravelが自動的に処理してくれる2つの機能：

- **ルーティング** LaravelはURLとHTTPメソッドを自動的に解析して適切なコントローラーを見つけるため、手動で`$_SERVER['REQUEST_URI']`や`str_starts_with`をチェックする必要がなくなる。

- **JSON入出力処理** Laravelは受信したJSONペイロードを自動的に解析し、適切なレスポンスヘッダー（`Content-Type: application/json`）を設定するため、手動で`file_get_contents('php://input')`や`header()`を呼び出す必要がなくなる。

2. One topic to ask my trainer about:

- When breaking down a custom Books API into layers, which layer is generally the most difficult to define?

- もし自作のBooks APIをレイヤー分けするとき、一般的にどの層に分けるのが一番難しいですか？
