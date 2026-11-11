import { useState } from 'react';
import { Link, useSearchParams } from 'react-router-dom';
import { BookGrid } from '../../components/BookGrid';
import { Pagination } from '../../components/Pagination';
import { SectionHeader } from '../../components/SectionHeader';
import { Hero } from '../../components/Hero';
import { PopularBooks } from '../../components/PopularBooks';
import { DailyDeals } from '../../components/DailyDeals';
import { sampleBooks } from './sampleBooks';
import { NewRelease } from '../../components/NewRelease';
import { Featured } from '../../components/Featured';
import { Publishers } from '../../components/Publishers';
import { Testimonials } from '../../components/Testimonials';

export function HomePage() {
  const [searchParams] = useSearchParams();
  const title = searchParams.get('title') ?? '';
  const books = title
    ? sampleBooks.filter((book) =>
        book.title.toLowerCase().includes(title.toLowerCase()),
      )
    : sampleBooks;
  const perPage = 4;
  const lastPage = Math.max(1, Math.ceil(books.length / perPage));
  const [page, setPage] = useState(1);
  const safePage = Math.min(page, lastPage);
  const visibleBooks = books.slice(
    (safePage - 1) * perPage,
    safePage * perPage,
  );

  return (
    <>
      <Hero />
      {title ? (
        <section className="pt-[70px] pb-20">
          <div className="mx-auto max-w-[1290px] px-[30px]">
            <SectionHeader
              title={`Results for "${title}"`}
              action={
                <Link to="/" className="ml-6 text-accent no-underline">
                  Clear
                </Link>
              }
            />
            <BookGrid
              books={visibleBooks}
              status={visibleBooks.length === 0 ? 'empty' : 'ready'}
              errorMessage=""
              onRetry={() => {}}
            />
            <Pagination
              currentPage={safePage}
              lastPage={lastPage}
              onChange={setPage}
            />
          </div>
        </section>
      ) : (
        <PopularBooks books={books} />
      )}
      <DailyDeals books={sampleBooks} />
      <NewRelease books={sampleBooks} />
      <Featured />
      <Testimonials />
      <Publishers />
    </>
  );
}
