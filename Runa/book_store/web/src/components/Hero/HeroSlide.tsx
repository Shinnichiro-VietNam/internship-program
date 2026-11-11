import { Button } from '../Button';
import { ChevronIcon } from '../icons/ChevronIcon';
import type { HeroSlideData } from './heroSlides';

type HeroSlideProps = {
  slide: HeroSlideData;
};

// display the left slide(small screen big title price shop now button)
export function HeroSlide({ slide }: HeroSlideProps) {
  const priced = Boolean(slide.price);

  return (
    <div
      className={`relative z-[1] w-1/2 py-[60px] pr-[30px] pl-[170px] max-[1200px]:pl-[70px] max-[900px]:w-auto max-[900px]:p-0 ${priced ? 'hero-copy-priced' : ''}`}
    >
      <p className="relative mb-5 text-lighter text-3 font-medium leading-5 text-uppercase">
        {slide.eyebrow}
      </p>
      <h2 className="hero-title">
        {slide.lines.map((line) => (
          <span key={line}>{line}</span>
        ))}
      </h2>
      {slide.originalPrice ? (
        <p className="mb-[3px] text-[14px] leading-[24px] text-lighter">
          Original Price <s>{slide.originalPrice}</s>
        </p>
      ) : null}
      {slide.price ? (
        <p className="mb-6 text-[26px] font-semibold leading-[32px] text-accent">
          {slide.price}
        </p>
      ) : null}
      <Button
        type="button"
        variant="secondary"
        className="h-auto! gap-2 px-6! py-[13px] leading-[17px] [&_svg]:size-[14px] [&_svg]:rotate-[-90deg] [&_svg]:text-accent"
      >
        Shop Now
        <ChevronIcon />
      </Button>
    </div>
  );
}
