import { useMemo, useState } from "react";
import { BookFilters } from "../components/books/BookFilters";
import { BookList } from "../components/books/BookList";
import { useBooks } from "../hooks/useBooks";
import type { BookFilters as BookFiltersType } from "../types/books";

const emptyFilters: BookFiltersType = {
  author: "",
  min_price: "",
  max_price: "",
};

export function BooksPage() {
  const [filters, setFilters] = useState<BookFiltersType>(emptyFilters);
  const { books, loading, error, apiOk } = useBooks(filters);

  const bookCount = useMemo(() => books.length, [books]);

  return (
    <div>
      <div className="page-header">
        <h2 className="page-title">Books</h2>
        <span className="small-text">API: {apiOk ? "OK" : "offline"}</span>
      </div>

      <BookFilters
        initialFilters={filters}
        onApply={setFilters}
        onClear={() => setFilters(emptyFilters)}
      />

      {!loading && !error && (
        <p className="small-text">{bookCount} book(s) found</p>
      )}

      {loading && <p>Loading…</p>}
      {error && <p>{error}</p>}
      {!loading && !error && <BookList books={books} />}
    </div>
  );
}
