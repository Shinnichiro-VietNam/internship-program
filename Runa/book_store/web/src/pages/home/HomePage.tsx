import { Hero } from '../../components/Hero';
import { PopularBooks } from '../../components/PopularBooks';
import { DailyDeals } from '../../components/DailyDeals';
import { sampleBooks } from './sampleBooks';
import { NewRelease } from '../../components/NewRelease';
import { Featured } from '../../components/Featured';
import { Publishers } from '../../components/Publishers';
import { Testimonials } from '../../components/Testimonials';

export function HomePage() {
  const books = sampleBooks;

  return (
    <>
      <Hero />
      <PopularBooks books={books} />
      <DailyDeals books={books} />
      <NewRelease books={books} />
      <Featured />
      <Testimonials />
      <Publishers />
    </>
  );
}
