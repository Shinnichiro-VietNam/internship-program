export type HeroCover = 'best' | 'top' | 'picks';

export type HeroSlideData = {
  id: HeroCover;
  eyebrow: string;
  lines: string[];
  originalPrice?: string;
  price?: string;
};

export const heroSlides: HeroSlideData[] = [
  {
    id: 'best',
    eyebrow: 'The best of 2021',
    lines: ['Meet Your Next', 'Favorite Book.'],
    originalPrice: '$45.55',
    price: '$24.55',
  },
  {
    id: 'top',
    eyebrow: 'Editor choice',
    lines: ['Top 10 Books', 'To Make It A', 'Great Year'],
  },
  {
    id: 'picks',
    eyebrow: 'Editor choice',
    lines: ['Our Sci-Fi &', 'Fantasy Picks'],
    originalPrice: '$45.55',
    price: '$24.55',
  },
];
