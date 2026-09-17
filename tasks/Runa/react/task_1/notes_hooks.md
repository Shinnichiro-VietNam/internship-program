# React hooks — usage notes

| Hook      | Used in | Purpose               | Notes                         |
| --------- | ------- | --------------------- | ----------------------------- |
| useState  | App.tsx | books, loading, error | separate state vs one object? |
| useEffect | App.tsx | fetch books on mount  | deps: `[]` — runs once        |
