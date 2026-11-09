import type { SampleBook } from '../../pages/home/sampleBooks';
import { BookCard } from '../BookCard';
import { SectionHeader } from '../SectionHeader';
import { ViewAllLink } from '../ViewAllLink';

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
