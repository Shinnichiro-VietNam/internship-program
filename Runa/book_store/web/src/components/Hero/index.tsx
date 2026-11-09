import { useState } from 'react';
import { HeroCovers } from './HeroCovers';
import { HeroDots } from './HeroDots';
import { HeroSlide } from './HeroSlide';
import { heroSlides } from './heroSlides';

export function Hero() {
  const [active, setActive] = useState(1);
  const slide = heroSlides[active];

  return (
    <section
      className="hero"
      aria-roledescription="carousel"
      aria-label="Featured books"
    >
      <div className="hero-stage">
        <div className={`hero-card hero-card-${slide.id}`}>
          <HeroSlide slide={slide} />
          <HeroCovers variant={slide.id} />
        </div>
        <HeroDots
          count={heroSlides.length}
          active={active}
          onSelect={setActive}
        />
      </div>
    </section>
  );
}
