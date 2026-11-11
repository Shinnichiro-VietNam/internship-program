import { Link } from 'react-router-dom';
import { formatPrice } from '../helper/format';
import type { SampleBook } from '../pages/home/sampleBooks';
import { BookActions } from './BookActions';
import { BookCover } from './BookCover';
import { BookStars } from './BookStars';

type BookCardProps = {
  book: SampleBook;
};

export function BookCard({ book }: BookCardProps) {
  const price = formatPrice(book.price);

  return (
    <article className="book-card">
      <div className="group relative">
        <Link to={`/books/${book.id}`} aria-label={book.title}>
          <BookCover src={book.cover} />
        </Link>
        <BookActions />
      </div>
      <h3 className="mt-[14px] text-sm font-semibold leading-[1.4]">
        <Link
          to={`/books/${book.id}`}
          className="block truncate text-ink no-underline hover:text-accent"
        >
          {book.title}
        </Link>
      </h3>
      <BookStars />
      <p className="mt-1 text-[13px] font-normal leading-[1.4] text-lighter">
        {book.author}
      </p>
      <p className="mt-[6px] text-accent font-semibold leading-[1.3]">
        {price}
      </p>
    </article>
  );
}
