import type { SampleBook } from '../../pages/home/sampleBooks';
import { SectionHeader } from '../SectionHeader';
import { SplitColumns } from '../SplitColumns';
import { TopWeek } from './TopWeek';
import { TrendingNow } from './TrendingNow';

type DailyDealsProps = {
  books: SampleBook[];
};

export function DailyDeals({ books }: DailyDealsProps) {
  return (
    <section className="pb-20" aria-label="Daily Deals">
      <div className="mx-auto max-w-[1290px] px-[30px]">
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
