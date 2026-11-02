import { useEffect, useState } from 'react';
import { useSearchParams } from 'react-router-dom';
import { Book as BookModel } from '../../models/Book';
import type { ApiSuccess } from '../../types/api';
import { BookCard } from '../../components/BookCard';
import { Button } from '../../components/Button';
import { parseApiError } from '../../helper/errors';
import type { Book, BookList } from '../../types/book';

export function HomePage() {
  const [searchParams, setSearchParams] = useSearchParams();
  const title = searchParams.get('title') ?? '';
  const page = Number(searchParams.get('page') ?? '1') || 1;
  const [items, setItems] = useState<Book[]>([]);
  const [currentPage, setCurrentPage] = useState(1);
  const [lastPage, setLastPage] = useState(1);
  const [errorMessage, setErrorMessage] = useState<string | null>(null);
  const [reloadKey, setReloadKey] = useState(0);
  const requestKey = `${title}|${page}|${reloadKey}`;
  const [doneKey, setDoneKey] = useState('');
  const loading = doneKey !== requestKey;

  useEffect(() => {
    let ignore = false;
    const params: { page: number; per_page: number; title?: string } = {
      page,
      per_page: 8,
    };
    if (title) params.title = title;

    BookModel.index<ApiSuccess<BookList>>(params)
      .then((result) => {
        if (ignore) return;
        setItems(result.data.items);
        setCurrentPage(result.data.current_page);
        setLastPage(result.data.last_page);
        setErrorMessage(null);
      })
      .catch((err) => {
        if (ignore) return;
        setItems([]);
        setErrorMessage(parseApiError(err).message);
      })
      .finally(() => {
        if (!ignore) setDoneKey(requestKey);
      });

    return () => {
      ignore = true;
    };
  }, [page, title, reloadKey, requestKey]);

  return (
    <div>
      <section>
        <h1>Turn the page, step into another world.</h1>
      </section>
      <section>
        {loading && <p>Loading</p>}
        {errorMessage && (
          <div>
            <p>{errorMessage}</p>
            <Button type="button" onClick={() => setReloadKey((n) => n + 1)}>
              Retry
            </Button>
          </div>
        )}
        {!loading && !errorMessage && items.length === 0 && (
          <p>No books found.</p>
        )}
        {!loading &&
          !errorMessage &&
          items.map((book) => <BookCard key={book.id} book={book} />)}
      </section>
      {!loading && !errorMessage && currentPage < lastPage && (
        <Button
          type="button"
          onClick={() => {
            const next = new URLSearchParams(searchParams);
            next.set('page', String(page + 1));
            setSearchParams(next);
          }}
        >
          Next
        </Button>
      )}
    </div>
  );
}
