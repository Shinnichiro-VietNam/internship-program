import { useEffect, useState } from 'react';
import { Link, useSearchParams } from 'react-router-dom';
import { BookGrid } from '../../components/BookGrid';
import { Pagination } from '../../components/Pagination';
import { SectionHeader } from '../../components/SectionHeader';
import { Hero } from '../../components/Hero';
import { Featured } from '../../components/Featured';
import { Publishers } from '../../components/Publishers';
import { Testimonials } from '../../components/Testimonials';
import { Book as BookModel } from '../../models/Book';
import type { ApiSuccess } from '../../types/api';
import type { Book, BookListData } from '../../types/book';
import { parseApiError } from '../../helper/errors';

export function HomePage() {
  const [searchParams, setSearchParams] = useSearchParams();
  const title = searchParams.get('title') ?? '';
  const page = Number(searchParams.get('page')) || 1;

  const [books, setBooks] = useState<Book[]>([]);
  const [status, setStatus] = useState<'loading' | 'empty' | 'error' | 'ready'>(
    'loading',
  );
  const [errorMessage, setErrorMessage] = useState('');
  const [lastPage, setLastPage] = useState(1);
  const [total, setTotal] = useState(0);
  const [retryCount, setRetryCount] = useState(0);

  useEffect(() => {
    const load = async () => {
      setStatus('loading');
      try {
        const response = await BookModel.index<ApiSuccess<BookListData>>({
          page,
          per_page: 8,
          ...(title ? { title } : {}),
        });
        const items = response.data.items;
        setBooks(items);
        setLastPage(response.data.last_page);
        setTotal(response.data.total);
        setStatus(items.length === 0 ? 'empty' : 'ready');
      } catch (error) {
        setErrorMessage(parseApiError(error).message);
        setStatus('error');
      }
    };

    load();
  }, [title, page, retryCount]);

  const changePage = (nextPage: number) => {
    const next = new URLSearchParams(searchParams);
    next.set('page', String(nextPage));
    setSearchParams(next);
    window.scrollTo({ top: 0 });
  };

  return (
    <>
      <Hero />
      <section className="pt-[70px] pb-20">
        <div className="mx-auto max-w-[1290px] px-[30px]">
          <SectionHeader
            title={title ? `${total} results for “${title}”` : '人気の本'}
            action={
              title ? (
                <Link to="/" className="ml-6 text-accent no-underline">
                  Clear
                </Link>
              ) : undefined
            }
          />
          <BookGrid
            books={books}
            status={status}
            errorMessage={errorMessage}
            onRetry={() => setRetryCount((count) => count + 1)}
            emptyMessage={
              title ? `No books match “${title}”` : 'No books found.'
            }
            emptyAction={
              title ? undefined : (
                <Link to="/" className="text-accent no-underline">
                  Home
                </Link>
              )
            }
          />
          <Pagination
            currentPage={page}
            lastPage={lastPage}
            onChange={changePage}
          />
        </div>
      </section>
      <Featured />
      <Testimonials />
      <Publishers />
    </>
  );
}
