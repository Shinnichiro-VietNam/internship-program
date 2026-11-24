import type { Book } from '../../../../types/book';
import { BookCard } from '../../../../components/books/BookCard';
import { SectionHeader } from '../../../../components/ui/SectionHeader';
import { SplitColumns } from '../SplitColumns';
import { ViewAllLink } from '../ViewAllLink';
import { MostViewed } from './MostViewed';
import { SaleBanner } from './SaleBanner';

type NewReleaseProps = {
  books: Book[];
};

export function NewRelease({ books }: NewReleaseProps) {
  return (
    <section className="pb-20" aria-label="New Release">
      <div className="mx-auto max-w-370 px-7.5">
        <SplitColumns
          main={
            <>
              <SaleBanner />
              <SectionHeader title="New Release" action={<ViewAllLink />} />
              <div className="grid grid-cols-3 gap-5.5">
                {books.slice(0, 3).map((book) => (
                  <BookCard key={book.id} book={book} />
                ))}
              </div>
            </>
          }
          side={<MostViewed books={books} />}
        />
      </div>
    </section>
  );
}
