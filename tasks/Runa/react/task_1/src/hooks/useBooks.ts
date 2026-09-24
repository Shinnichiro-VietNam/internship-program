import { useCallback, useEffect, useState } from "react";
import axios from "axios";
import { API_URL } from "../lib/config";
import type { ApiListResponse, Book, BookFilters } from "../types/books";

export function useBooks(filters: BookFilters) {
  const [books, setBooks] = useState<Book[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);
  const [apiOk, setApiOk] = useState(false);

  const fetchBooks = useCallback(async () => {
    setLoading(true);
    setError(null);

    try {
      await axios.get(`${API_URL}/health`);
      setApiOk(true);

      const params: Record<string, string> = {};
      if (filters.author.trim()) params.author = filters.author.trim();
      if (filters.min_price.trim()) params.min_price = filters.min_price.trim();
      if (filters.max_price.trim()) params.max_price = filters.max_price.trim();

      const booksRes = await axios.get<ApiListResponse<Book>>(`${API_URL}/books`, {
        params,
      });
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
  }, [filters.author, filters.min_price, filters.max_price]);

  useEffect(() => {
    void fetchBooks();
  }, [fetchBooks]);

  return { books, loading, error, apiOk, refetch: fetchBooks };
}
