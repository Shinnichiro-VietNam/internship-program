export type HeroCover = 'best' | 'top' | 'picks';

export type HeroLineFrom = 'left' | 'right' | 'bottom';

export type HeroLine = {
  text: string;
  from: HeroLineFrom;
  mark?: string;
};

export type HeroSlideData = {
  id: HeroCover;
  eyebrow: string;
  lines: HeroLine[];
  originalPrice?: string;
  price?: string;
};

export const heroSlides: HeroSlideData[] = [
  {
    id: 'best',
    eyebrow: 'The best of 2021',
    lines: [
      { text: 'Meet Your Next', from: 'left' },
      { text: 'Favorite Book.', from: 'right', mark: 'Favorite' },
    ],
    originalPrice: '$45.55',
    price: '$24.55',
  },
  {
    id: 'top',
    eyebrow: 'Editor choice',
    lines: [
      { text: 'Top 10 Books', from: 'left', mark: 'Top 10' },
      { text: 'To Make It A', from: 'right' },
      { text: 'Great Year', from: 'bottom' },
    ],
  },
  {
    id: 'picks',
    eyebrow: 'Editor choice',
    lines: [
      { text: 'Our Sci-Fi &', from: 'left' },
      { text: 'Fantasy Picks', from: 'right', mark: 'Fantasy' },
    ],
    originalPrice: '$45.55',
    price: '$24.55',
  },
];
