import { useEffect, useRef, useState } from 'react';
import type { ReactNode } from 'react';
import type { SampleBook } from '../../pages/home/sampleBooks';
import { BookCard } from '../BookCard';
import { SectionHeader } from '../SectionHeader';
import { ViewAllLink } from '../ViewAllLink';

const INTERVAL_MS = 4500;
const SLIDE_MS = 600;
const VISIBLE = 5;

type PopularBooksProps = {
  books: SampleBook[];
  title?: string;
  action?: ReactNode;
};

export function PopularBooks({
  books,
  title = 'Popular Books',
  action = <ViewAllLink />,
}: PopularBooksProps) {
  const [order, setOrder] = useState(books);
  const [shift, setShift] = useState(0);
  const [animate, setAnimate] = useState(false);
  const paused = useRef(false);

  useEffect(() => {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    let slideTimer = 0;
    let frame = 0;
    const timer = window.setInterval(() => {
      if (paused.current) return;
      setAnimate(true);
      window.cancelAnimationFrame(frame);
      frame = window.requestAnimationFrame(() => {
        frame = window.requestAnimationFrame(() => {
          setShift(1);
          window.clearTimeout(slideTimer);
          slideTimer = window.setTimeout(() => {
            setAnimate(false);
            setShift(0);
            setOrder((current) => [...current.slice(1), current[0]]);
          }, SLIDE_MS);
        });
      });
    }, INTERVAL_MS);

    return () => {
      window.clearInterval(timer);
      window.cancelAnimationFrame(frame);
      window.clearTimeout(slideTimer);
    };
  }, []);
  return (
    <section
      className="pt-[70px] pb-20"
      aria-label={title}
      onMouseEnter={() => {
        paused.current = true;
      }}
      onMouseLeave={() => {
        paused.current = false;
      }}
    >
      <div className="mx-auto max-w-[1480px] px-[30px]">
        <SectionHeader title={title} action={action} />
        <div className="overflow-hidden">
          <div
            className={
              'flex gap-[22px] [--gap:22px] [--visible:5] [&>.book-card]:min-w-0 [&>.book-card]:flex-[0_0_calc((100%-(var(--visible)-1)*var(--gap))/var(--visible))]' +
              (animate
                ? ' transition-transform duration-[600ms] ease-in-out'
                : '') +
              (shift
                ? ' -translate-x-[calc((100%-4*var(--gap))/var(--visible)+var(--gap))]'
                : '')
            }
          >
            {order.slice(0, VISIBLE + 1).map((book) => (
              <BookCard key={book.id} book={book} />
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
