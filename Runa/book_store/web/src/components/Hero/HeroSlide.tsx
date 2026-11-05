import { Button } from '../Button';
import { ChevronIcon } from '../icons/ChevronIcon';
import type { HeroSlideData } from './heroSlides';

type HeroSlideProps = {
  slide: HeroSlideData;
};

export function HeroSlide({ slide }: HeroSlideProps) {
  const priced = Boolean(slide.price);

  return (
    <div className={priced ? 'hero-copy hero-copy-priced' : 'hero-copy'}>
      <p className="hero-eyebrow">
        <svg className="hero-scribble" viewBox="0 0 160 18" aria-hidden="true">
          <path
            d="M2 11c18-9 28 8 46-1s28 9 46-2 30 8 64 0"
            fill="none"
            stroke="currentColor"
            strokeWidth="1.6"
            strokeLinecap="round"
          />
        </svg>
        {slide.eyebrow}
      </p>
      <h2 className="hero-title">
        {slide.lines.map((line) => (
          <span key={line}>{line}</span>
        ))}
      </h2>
      {slide.originalPrice ? (
        <p className="hero-was">
          Original Price <s>{slide.originalPrice}</s>
        </p>
      ) : null}
      {slide.price ? <p className="hero-price">{slide.price}</p> : null}
      <Button type="button" variant="secondary" className="hero-shop">
        Shop Now
        <ChevronIcon />
      </Button>
    </div>
  );
}
