import { useEffect, useState } from 'react';
import pattern from '../../assets/images/revslider_bg.jpg';
import { HeroCovers } from './HeroCovers';
import { HeroDots } from './HeroDots';
import { HeroSlide } from './HeroSlide';
import { heroSlides } from './heroSlides';

const SLIDE_MS = 9000;

export function Hero() {
  const [active, setActive] = useState(0);
  const [token, setToken] = useState(0);

  const go = (index: number) => {
    if (index === active) return;
    setActive(index);
    setToken((current) => current + 1);
  };

  useEffect(() => {
    const id = window.setTimeout(() => {
      setActive((active + 1) % heroSlides.length);
      setToken((current) => current + 1);
    }, SLIDE_MS);
    return () => window.clearTimeout(id);
  }, [active, token]);

  const slide = heroSlides[active];

  return (
    <section
      className="hero"
      aria-roledescription="carousel"
      aria-label="Featured books"
    >
      <div className="hero-stage">
        <img className="hero-pattern" src={pattern} alt="" />
        <div className="hero-window">
          <div key={token} className={`hero-card hero-card-in hero-card-${slide.id}`}>
            <HeroSlide slide={slide} motion />
            <HeroCovers variant={slide.id} motion />
          </div>
        </div>
        <HeroDots
          count={heroSlides.length}
          active={active}
          onSelect={go}
        />
      </div>
    </section>
  );
}
