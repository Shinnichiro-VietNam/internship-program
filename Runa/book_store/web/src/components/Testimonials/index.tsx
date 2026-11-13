import { useEffect, useRef, useState, type CSSProperties } from 'react';
import test01 from '../../assets/images/test_01.png';
import test02 from '../../assets/images/test_02.png';
import test03 from '../../assets/images/test_03.png';
import { SectionHeader } from '../SectionHeader';
import { TestimonialCard } from './TestimonialCard';

const backgrounds = ['#E9F7FA', '#F5F7FE', '#FEF5F5', '#F4FBF2'];

const DESKTOP_VISIBLE = 3;

type Review = {
  id: string;
  name: string;
  city: string;
  quote: string;
  photo: string;
};

const reviews: Review[] = [
  {
    id: 'john',
    name: 'John Doe',
    city: 'New York',
    photo: test01,
    quote:
      'I am so happy to find a site where I can shop for unusual items. The packaging was phenomenal and my book arrived on time in perfect condition.',
  },
  {
    id: 'pam',
    name: 'Pam Pruitt',
    city: 'New York',
    photo: test02,
    quote:
      'This is the best book store! The prices are great, and there is always a sale of some kind going on. You can find just what you are looking for. So great!',
  },
  {
    id: 'joel',
    name: 'Joel M.',
    city: 'New York',
    photo: test03,
    quote:
      'I am so happy to find a site where I can shop for unusual items. The packaging was phenomenal and my book arrived on time in perfect condition.',
  },
  {
    id: 'lena',
    name: 'Lena Ortiz',
    city: 'Brooklyn',
    photo: test01,
    quote:
      'Every order feels carefully packed. I found two out-of-print titles here that I could not get anywhere else, and both arrived looking new.',
  },
  {
    id: 'chris',
    name: 'Chris Hale',
    city: 'Chicago',
    photo: test02,
    quote:
      'The prices are fair, the descriptions are honest, and the sale shelf is always worth a look. I keep coming back for another stack.',
  },
];

function visibleCount() {
  return window.matchMedia('(max-width: 900px)').matches ? 1 : DESKTOP_VISIBLE;
}

export function Testimonials() {
  const [visible, setVisible] = useState(() =>
    window.matchMedia('(max-width: 900px)').matches ? 1 : DESKTOP_VISIBLE,
  );
  const [page, setPage] = useState(0);
  const paused = useRef(false);
  const pageCount = Math.max(reviews.length - visible + 1, 1);
  const safePage = Math.min(page, pageCount - 1);

  useEffect(() => {
    const query = window.matchMedia('(max-width: 900px)');
    const update = () => setVisible(visibleCount());
    update();
    query.addEventListener('change', update);
    return () => query.removeEventListener('change', update);
  }, []);

  useEffect(() => {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    const timer = window.setInterval(() => {
      if (paused.current) return;
      setPage((current) => (Math.min(current, pageCount - 1) + 1) % pageCount);
    }, 6000);

    return () => window.clearInterval(timer);
  }, [pageCount]);

  const trackStyle = {
    '--visible': visible,
    transform: `translateX(calc(${safePage} * -1 * ((100% - (${visible} - 1) * var(--gap)) / var(--visible) + var(--gap))))`,
  } as CSSProperties;

  return (
    <section
      className="pb-[88px]"
      aria-roledescription="carousel"
      aria-label="What Client Says"
      onMouseEnter={() => {
        paused.current = true;
      }}
      onMouseLeave={() => {
        paused.current = false;
      }}
    >
      <div className="mx-auto max-w-[1480px] px-[30px]">
        <SectionHeader
          title="What Client Says"
          compact
          action={
            <div className="ml-6 flex shrink-0 items-center gap-0.5">
              {Array.from({ length: pageCount }, (_, index) => {
                const active = index === safePage;
                return (
                  <button
                    key={index}
                    type="button"
                    className={`grid h-4 cursor-pointer place-items-center border-0 bg-transparent p-0 focus-visible:rounded-full focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent ${active ? 'w-7' : 'w-4'}`}
                    aria-label={`Testimonials ${index + 1}`}
                    aria-current={active ? 'true' : undefined}
                    onClick={() => setPage(index)}
                  >
                    <span
                      className={`block rounded-full ${active ? 'h-1 w-[22px] bg-accent' : 'size-1.5 bg-[#cfcfcf]'}`}
                    />
                  </button>
                );
              })}
            </div>
          }
        />

        <div className="overflow-hidden">
          <ul
            className="m-0 flex list-none gap-6 p-0 transition-transform duration-500 ease-in-out [--gap:24px] motion-reduce:transition-none [&>li]:min-w-0 [&>li]:flex-[0_0_calc((100%-(var(--visible)-1)*var(--gap))/var(--visible))]"
            style={trackStyle}
          >
            {reviews.map((review, index) => (
              <TestimonialCard
                key={review.id}
                {...review}
                background={backgrounds[index % backgrounds.length]}
              />
            ))}
          </ul>
        </div>
      </div>
    </section>
  );
}
