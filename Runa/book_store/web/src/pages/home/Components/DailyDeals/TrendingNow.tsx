import type { Book } from '../../../../types/book';
import { BookCard } from '../../../../components/books/BookCard';
import { SectionHeader } from '../../../../components/ui/SectionHeader';
import { ViewAllLink } from '../ViewAllLink';

type TrendingNowProps = {
  books: Book[];
};

export function TrendingNow({ books }: TrendingNowProps) {
  return (
    <>
      <SectionHeader title="Trending Now" action={<ViewAllLink />} />
      <div className="grid grid-cols-3 gap-5.5">
        {books.map((book) => (
          <BookCard key={book.id} book={book} />
        ))}
      </div>
    </>
  );
}
