import { useEffect, useState } from "react";
import axios from "axios";
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
        await axios.get(`${API_URL}/health`);
        setApiOk(true);

        const booksRes = await axios.get<ApiListResponse<Book>>(`${API_URL}/books`);
        setBooks(booksRes.data.data);
      } catch (e) {
        setApiOk(false);
        if (axios.isAxiosError(e)) {
          setError(e.response?.data?.message || "Failed to load books");
        } else {
          setError(e instanceof Error ? e.message : "Something went wrong");
        }
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