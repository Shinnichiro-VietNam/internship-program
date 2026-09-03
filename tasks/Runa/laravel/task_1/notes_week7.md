# Week 7 Notes

## Exercise 1: Why snapshot `unit_price` from the book?

The client must not set `unit_price` in JSON.
クライアントが JSON で `unit_price` を送れないようにする。

The price at order time is copied from `books.price` so later price changes do not rewrite history.
注文時点の価格を `books.price` からコピーし、あとから本の価格が変わっても履歴が変わらない。

---

## Exercise 2: Transaction + event dispatch

Dispatch `OrderPlaced` **after** `DB::transaction` returns, not inside the closure.
`OrderPlaced` は `DB::transaction` の**外**（戻ったあと）で dispatch する。クロージャの中ではない。

If the event runs inside the transaction and a later step throws, the DB rolls back but listeners/jobs may already have run for an order that no longer exists.
イベントをトランザクション内で投げると、あとで例外でロールバックしても、リスナーやジョブは「存在しない注文」向けに動いてしまう。

---

## Exercise 3: Action vs listener

`CreateOrder` only writes data and commits the transaction.
`CreateOrder` はデータの書き込みとコミットだけ。

`HandleOrderPlaced` handles side effects (log, queue jobs) after the order exists.
`HandleOrderPlaced` は注文ができたあとの副作用（ログ、ジョブ投入）を担当する。

---

## Exercise 4: `sync` vs `database` queue

`sync` runs jobs immediately in the same request — good for tests, hides async failures.
`sync` は同じリクエスト内で即実行 — テスト向き。非同期の失敗が見えにくい。

`database` stores jobs in `jobs` until `queue:work` runs — closer to production; bugs in serialization or worker-only code show up.
`database` は `queue:work` まで `jobs` に残る — 本番に近い。シリアライズやワーカー専用のバグが見える。

---

## Exercise 5: Low-stock threshold

`WarnLowStock::THRESHOLD = 5` — warn when `stock_qty < 5` after the order.
`WarnLowStock::THRESHOLD = 5` — 注文後 `stock_qty < 5` で警告。

---

## Exercise 6: `register()` vs `boot()`

`register()`: bind interfaces to implementations before anything is resolved from the container.
`register()`: コンテナが解決する前にインターフェースと実装を bind する。

`boot()`: run after all providers registered — routes, events, etc.
`boot()`: 全 Provider 登録後に実行 — ルートやイベントなど。

The Job type-hints `Notifier`, not `LogNotifier`, so we can swap implementations without editing the Job.
Job は `LogNotifier` ではなく `Notifier` を型指定するので、Job を触らず実装を差し替えられる。

---

## Planted job failure (manual)

Temporarily `throw new \RuntimeException('planted failure');` in `WarnLowStock::handle`, place an order, run `queue:work --once --stop-when-empty` — row appears in `failed_jobs`. Revert and optionally `php artisan queue:retry all`.
（手動確認）`WarnLowStock::handle` に例外を仕込み → 注文 → `queue:work` → `failed_jobs` に行 → 元に戻す。

---

## Checklist (Exercise 8)

| # | Check | Result |
| - | ----- | ------ |
| 1 | `php artisan test` (incl. week 6) | green |
| 2 | Guest POST | 401 |
| 3 | Reader POST | 403 |
| 4 | Admin valid order | 201, Location, stock down |
| 5 | Admin oversell | 400, stock unchanged |
| 6 | Two-item partial oversell | 400, both stocks unchanged |
| 7 | `order.placed` in log after valid order | manual |
| 8 | `QUEUE_CONNECTION=database` + `queue:work` | manual |
| 9 | Planted job → `failed_jobs` | manual |
| 10 | `Notifier` from container | yes |
| 11 | Week-6 tests still pass | yes |

---

## Reflection (Exercise 8)

1. Oversell needs a transaction so order + stock + items commit or roll back together — not separate queries.
   在庫不足はトランザクションで、注文・在庫・明細をまとめてコミットかロールバックする必要がある。

2. Easier to change notification (swap `LogNotifier` for mail) than to change how orders are stored — Provider + interface isolate that.
   通知方法（Log → メール）は Provider と interface で差し替えやすい。注文の保存ロジックより変更が楽。

3. Wrong binding in `register()` breaks container resolution; wrong code in `boot()` breaks startup side effects.
   `register()` の bind ミスは解決失敗、`boot()` のミスは起動時の副作用の失敗。

4. Without tests/policies/Actions, week-2 `POST /api/orders` would be harder to refactor safely and easy to break stock rules.
   テスト・Policy・Action がなければ、在庫ルールを壊しやすく安全にリファクタも難しい。
