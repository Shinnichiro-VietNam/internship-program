import { Link } from 'react-router-dom';
import type { SampleBook } from '../../pages/home/sampleBooks';

type MostViewedProps = {
  books: SampleBook[];
};

export function MostViewed({ books }: MostViewedProps) {
  return (
    <aside className="rounded-[20px] bg-[#f7f7f7] px-6 py-7" aria-label="Most Viewed">
      <h2 className="m-0 mb-[18px] text-[22px] font-bold">Most Viewed</h2>
      <ol className="m-0 flex list-none flex-col gap-4 p-0">
        {books.map((book, index) => (
          <li key={book.id} className="flex gap-2.5">
            <span className="min-w-[22px] font-semibold text-text">{index + 1}.</span>
            <span>
              <Link
                to={`/books/${book.id}`}
                className="block text-[14px] leading-[1.3] font-bold text-ink no-underline"
              >
                {book.title}
              </Link>
              <span className="mt-1 block text-[13px] leading-[1.4] font-normal text-lighter">
                {book.author}
              </span>
            </span>
          </li>
        ))}
      </ol>
    </aside>
  );
}
