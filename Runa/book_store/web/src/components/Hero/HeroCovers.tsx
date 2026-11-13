import bookBest from '../../assets/images/revslider_book-3.png';
import bookTop from '../../assets/images/revslider_book-2.png';
import bookPicks from '../../assets/images/revslider_book-4.png';
import decor from '../../assets/images/revslider_decor-1.png';
import type { HeroCover } from './heroSlides';

const covers: Record<HeroCover, string> = {
  best: bookBest,
  top: bookTop,
  picks: bookPicks,
};

type HeroCoversProps = {
  variant: HeroCover;
  motion: boolean;
};

export function HeroCovers({ variant, motion }: HeroCoversProps) {
  return (
    <div className="hero-art">
      <div className="hero-figure">
        {variant === 'top' ? (
          <img
            className={motion ? 'hero-decor is-motion' : 'hero-decor'}
            src={decor}
            alt=""
          />
        ) : null}
        <img
          className={motion ? 'hero-covers is-motion' : 'hero-covers'}
          src={covers[variant]}
          alt=""
        />
      </div>
    </div>
  );
}
