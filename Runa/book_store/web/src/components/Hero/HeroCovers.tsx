import bookBest from '../../assets/images/revslider_book-3.png';
import bookTop from '../../assets/images/revslider_book-2.png';
import bookPicks from '../../assets/images/revslider_book-4.png';
import type { HeroCover } from './heroSlides';

const covers: Record<HeroCover, string> = {
  best: bookBest,
  top: bookTop,
  picks: bookPicks,
};

type HeroCoversProps = {
  variant: HeroCover;
};

export function HeroCovers({ variant }: HeroCoversProps) {
  return <img className="hero-covers" src={covers[variant]} alt="" />;
}
