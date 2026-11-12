import { BookStar } from './BookStar';
import { BookStarHalf } from './BookStarHalf';

type BookStarsProps = {
  rating?: number;
};

export function BookStars({ rating = 5 }: BookStarsProps) {
  const value = Number.isFinite(Number(rating)) ? Number(rating) : 5;

  return (
    <p
      className="mt-[6px] flex items-center gap-[2px] text-star"
      aria-label={`${value} stars`}
    >
      {Array.from({ length: 5 }, (_, index) => {
        const fill = value - index;
        if (fill >= 1) return <BookStar key={index} />;
        if (fill >= 0.5) return <BookStarHalf key={index} />;
        return <BookStar key={index} className="h-4 w-4 text-[#d9d9d9]" />;
      })}
      <span className="ml-1 text-[13px] font-normal text-lighter">{value}</span>
    </p>
  );
}
