import type { HeroCover } from './heroSlides';

type HeroCoversProps = {
  variant: HeroCover;
};

const covers: Record<HeroCover, { back: string; front: string }> = {
  best: { back: 'Harbor', front: 'Quill' },
  top: { back: 'North', front: 'Field' },
  picks: { back: 'Lumen', front: 'Ark' },
};

export function HeroCovers({ variant }: HeroCoversProps) {
  const names = covers[variant];

  return (
    <div className={`hero-covers hero-covers-${variant}`} aria-hidden="true">
      <span className="hero-book hero-book-back">
        <span>{names.back}</span>
      </span>
      <span className="hero-book hero-book-front">
        <span>{names.front}</span>
      </span>
    </div>
  );
}
