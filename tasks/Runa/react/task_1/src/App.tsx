import { useEffect, useState } from "react";
import { AppLayout } from "./components/layout/AppLayout";
import { BookList } from "./components/books/BookList";
import { API_URL } from "./lib/config";
import type { ApiListResponse, Book } from "./types/books";

function App() {
  const [books, setBooks] = useState<Book[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);
  const [apiOk, setApiOk] = useState(false);

  useEffect(() => {
    async function load() {
      try {
        const healthRes = await fetch(`${API_URL}/health`);
        setApiOk(healthRes.ok);

        const booksRes = await fetch(`${API_URL}/books`);
        if (!booksRes.ok) throw new Error("Failed to load books");

        const json: ApiListResponse<Book> = await booksRes.json();
        setBooks(json.data);
      } catch (e) {
        setError(e instanceof Error ? e.message : "Something went wrong");
      } finally {
        setLoading(false);
      }
    }

    load();
  }, []);

  return (
    <AppLayout apiStatus={<span>API: {apiOk ? "OK" : "offline"}</span>}>
      {loading && <p>Loading…</p>}
      {error && <p>{error}</p>}
      {!loading && !error && <BookList books={books} />}
    </AppLayout>
  );
}

export default App;