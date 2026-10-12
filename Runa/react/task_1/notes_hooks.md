# React hooks — usage notes

| Hook          | Used in            | Purpose                                      | Notes                                              |
| ------------- | ------------------ | -------------------------------------------- | -------------------------------------------------- |
| useState      | App.tsx (week 1)   | books, loading, error                        | moved into `useBooks` / pages in week 2            |
| useEffect     | App.tsx (week 1)   | fetch books on mount                         | deps: `[]` — runs once                             |
| useState      | BooksPage          | filter values applied to API                 | draft inputs live in `BookFilters`                 |
| useState      | BookFilters        | controlled author / min / max inputs         | Apply copies draft → parent filters                |
| useState      | BookDetailPage     | book, orderItems, loading, notFound, errors  | separate flags for 404 vs other errors             |
| useState      | useBooks           | books, loading, error, apiOk                 | custom hook owns list fetch state                  |
| useCallback   | useBooks           | stable `fetchBooks`                          | deps: filter fields; used by useEffect + refetch   |
| useEffect     | useBooks           | refetch when filters / fetchBooks change     | hits real API with `?author=` etc.                 |
| useEffect     | BookDetailPage     | load book + order-items when `id` changes    | cleanup cancels stale updates                      |
| useMemo       | BooksPage          | derived `bookCount` from filtered list       | cheap, but documents derived-data pattern          |
| useParams     | BookDetailPage     | read `:id` from `/books/:id`                 | string id passed to API path                       |
| custom hook   | useBooks           | list fetch with filter params                | returns `{ books, loading, error, apiOk, refetch }` |

## 日本語メモ

| Hook          | 使っている場所         | 目的                                           | メモ                                                         |
| ------------- | ---------------------- | ---------------------------------------------- | ------------------------------------------------------------ |
| useState      | App.tsx（Week 1）      | books / loading / error の管理                 | Week 2 では `useBooks` や各ページへ移した                  |
| useEffect     | App.tsx（Week 1）      | マウント時に本一覧を取得                       | 依存配列 `[]` — 一度だけ実行                                 |
| useState      | BooksPage              | API に送るフィルタ条件                         | 入力中の下書きは `BookFilters` 側で持つ                      |
| useState      | BookFilters            | author / min / max の入力値（controlled）      | Apply で下書きを親の filters にコピー                        |
| useState      | BookDetailPage         | book・orderItems・loading・notFound・error     | 404 とその他エラーをフラグで分けて扱う                       |
| useState      | useBooks               | books / loading / error / apiOk                | 一覧取得の状態はカスタムフックが持つ                         |
| useCallback   | useBooks               | `fetchBooks` を安定した関数にする              | 依存はフィルタ項目。useEffect と refetch で使う              |
| useEffect     | useBooks               | フィルタや fetchBooks が変わったら再取得       | 本物の API に `?author=` などを付けて叩く                    |
| useEffect     | BookDetailPage         | `id` が変わったら本＋注文履歴を取得            | cleanup で古いレスポンスの反映をキャンセル                   |
| useMemo       | BooksPage              | 絞り込み後リストから `bookCount` を作る        | 軽い処理だが、派生データのパターンとして使う                 |
| useParams     | BookDetailPage         | `/books/:id` から `id` を読む                  | 文字列の id を API のパスに渡す                              |
| custom hook   | useBooks               | フィルタ付きで一覧を取得する                   | `{ books, loading, error, apiOk, refetch }` を返す           |
