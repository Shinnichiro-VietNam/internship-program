import { ChevronIcon } from '../icons/ChevronIcon';
import { HeroEyebrow } from './HeroEyebrow';
import type { HeroSlideData } from './heroSlides';
import underline from '../../assets/images/revslider_vector.png';

type HeroSlideProps = {
  slide: HeroSlideData;
  motion: boolean;
};

const lineMotion = {
  left: 'hero-from-left',
  right: 'hero-from-right',
  bottom: 'hero-rise hero-rise-line',
} as const;

function LineText({
  text,
  mark,
  motion,
}: {
  text: string;
  mark?: string;
  motion: boolean;
}) {
  if (!mark) return text;
  const start = text.indexOf(mark);
  if (start < 0) return text;

  return (
    <>
      {text.slice(0, start)}
      <span className="hero-mark">
        {mark}
        <img
          className={motion ? 'hero-underline is-motion' : 'hero-underline'}
          src={underline}
          alt=""
        />
      </span>
      {text.slice(start + mark.length)}
    </>
  );
}

export function HeroSlide({ slide, motion }: HeroSlideProps) {
  const priced = Boolean(slide.price);

  return (
    <div className={`hero-copy${priced ? ' hero-copy-priced' : ''}`}>
      <HeroEyebrow text={slide.eyebrow} motion={motion} />
      <h2 className="hero-title">
        {slide.lines.map((line) => (
          <span
            key={line.text}
            className={motion ? `hero-line ${lineMotion[line.from]}` : 'hero-line'}
          >
            <LineText text={line.text} mark={line.mark} motion={motion} />
          </span>
        ))}
      </h2>
      {slide.originalPrice ? (
        <p className={motion ? 'hero-original hero-rise hero-rise-original' : 'hero-original'}>
          Original Price <s>{slide.originalPrice}</s>
        </p>
      ) : null}
      {slide.price ? (
        <p className={motion ? 'hero-price hero-rise hero-rise-price' : 'hero-price'}>
          {slide.price}
        </p>
      ) : null}
      <div className={motion ? 'hero-rise hero-rise-button' : undefined}>
        <button type="button" className="hero-shop">
          Shop Now
          <ChevronIcon />
        </button>
      </div>
    </div>
  );
}
