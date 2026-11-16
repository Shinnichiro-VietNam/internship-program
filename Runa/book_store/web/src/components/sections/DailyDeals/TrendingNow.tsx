import type { SampleBook } from '../../../pages/books/sampleBooks';
import { BookCard } from '../../books/BookCard';
import { SectionHeader } from '../../ui/SectionHeader';
import { ViewAllLink } from '../../ui/ViewAllLink';

type TrendingNowProps = {
  books: SampleBook[];
};

export function TrendingNow({ books }: TrendingNowProps) {
  return (
    <>
      <SectionHeader title="Trending Now" action={<ViewAllLink />} />
      <div className="grid grid-cols-3 gap-[22px]">
        {books.map((book) => (
          <BookCard key={book.id} book={book} />
        ))}
      </div>
    </>
  );
}
