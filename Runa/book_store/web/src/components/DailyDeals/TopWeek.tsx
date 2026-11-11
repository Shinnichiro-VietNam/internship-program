import { Link } from 'react-router-dom';
import type { SampleBook } from '../../pages/home/sampleBooks';
import { BookCover } from '../BookCover';

const rankColors = [
  'bg-[#d0d3e3]',
  'bg-[#f2dea8]',
  'bg-[#8edccf]',
  'bg-[#b2e9ff]',
  'bg-[#cdbfff]',
];

type TopWeekProps = {
  books: SampleBook[];
};

export function TopWeek({ books }: TopWeekProps) {
  return (
    <aside
      className="rounded-[28px] bg-[#f0f1f5] px-[22px] pt-8 pb-10"
      aria-label="Top 10 This Week"
    >
      <h2 className="m-0 border-b border-[#e4e5ea] pb-4 text-[20px] leading-[1.2] font-bold text-[#111]">
        Top 10 This Week
      </h2>
      <ol className="m-0 mt-7 flex list-none flex-col gap-9 p-0">
        {books.map((book, index) => (
          <li key={book.id} className="flex items-center gap-3.5">
            <span className="relative w-[62px] shrink-0 [&_img]:rounded-[8px]">
              <span
                className={`absolute -top-2 -left-2 z-[1] flex size-[22px] items-center justify-center rounded-full text-[12px] leading-none font-semibold text-[#2b2b2b] ${rankColors[index]}`}
              >
                {index + 1}
              </span>
              <BookCover src={book.cover} />
            </span>
            <span className="flex min-w-0 flex-col gap-1">
              <Link
                to={`/books/${book.id}`}
                className="line-clamp-2 text-[15px] leading-[1.3] font-bold text-[#111] no-underline"
              >
                {book.title}
              </Link>
              <span className="truncate text-[13px] leading-[1.4] font-normal text-[#9a9a9a]">
                {book.author}
              </span>
            </span>
          </li>
        ))}
      </ol>
    </aside>
  );
}
