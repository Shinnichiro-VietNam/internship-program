import type { SampleBook } from '../../pages/home/sampleBooks';
import { BookCard } from '../BookCard';
import { SectionHeader } from '../SectionHeader';
import { SplitColumns } from '../SplitColumns';
import { ViewAllLink } from '../ViewAllLink';
import { MostViewed } from './MostViewed';
import { SaleBanner } from './SaleBanner';

type NewReleaseProps = {
  books: SampleBook[];
};

export function NewRelease({ books }: NewReleaseProps) {
  return (
    <section className="pb-20" aria-label="New Release">
      <div className="mx-auto max-w-[1480px] px-[30px]">
        <SplitColumns
          main={
            <>
              <SaleBanner />
              <SectionHeader title="New Release" action={<ViewAllLink />} />
              <div className="grid grid-cols-3 gap-[22px]">
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
