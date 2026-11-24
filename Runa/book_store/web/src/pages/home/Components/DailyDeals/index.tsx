import type { Book } from '../../../../types/book';
import { SectionHeader } from '../../../../components/ui/SectionHeader';
import { SplitColumns } from '../SplitColumns';
import { TopWeek } from './TopWeek';
import { TrendingNow } from './TrendingNow';

type DailyDealsProps = {
  books: Book[];
};

export function DailyDeals({ books }: DailyDealsProps) {
  return (
    <section className="pb-20" aria-label="Daily Deals">
      <div className="mx-auto max-w-370 px-3.75">
        <SectionHeader title="Daily Deals" />
        <SplitColumns
          columns="grid-cols-[minmax(0,1fr)_270px]"
          main={<TrendingNow books={books.slice(0, 3)} />}
          side={<TopWeek books={books.slice(3, 8)} />}
        />
      </div>
    </section>
  );
}
