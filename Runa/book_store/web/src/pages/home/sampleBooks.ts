import cover1 from '../../assets/images/1.jpg';
import cover2 from '../../assets/images/2.jpg';
import cover3 from '../../assets/images/3.jpg';
import cover4 from '../../assets/images/4.jpg';
import cover5 from '../../assets/images/5.jpg';
import cover6 from '../../assets/images/6.jpg';
import cover7 from '../../assets/images/7.jpg';
import cover8 from '../../assets/images/8.jpg';
import type { Book } from '../../types/book';

export type SampleBook = Book & {
  cover: string;
  rating: number;
};

export const sampleBooks: SampleBook[] = [
  {
    id: 1,
    title: 'The Art of Readable Code',
    author: 'Dustin Boswell',
    price: 3200,
    stock_qty: 30,
    published_year: 2018,
    rating: 5,
    cover: cover1,
  },
  {
    id: 2,
    title: 'The Pragmatic Programmer',
    author: 'Andy Hunt',
    price: 3800,
    stock_qty: 22,
    published_year: 2020,
    rating: 4.5,
    cover: cover2,
  },
  {
    id: 3,
    title: 'Design Patterns',
    author: 'GoF',
    price: 5200,
    stock_qty: 14,
    published_year: 1994,
    rating: 5,
    cover: cover3,
  },
  {
    id: 4,
    title: 'Refactoring',
    author: 'Martin Fowler',
    price: 4800,
    stock_qty: 18,
    published_year: 2019,
    rating: 4.5,
    cover: cover4,
  },
  {
    id: 5,
    title: 'Database System Concepts',
    author: 'Silberschatz',
    price: 6500,
    stock_qty: 10,
    published_year: 2021,
    rating: 5,
    cover: cover5,
  },
  {
    id: 6,
    title: 'SQL Performance Explained',
    author: 'Markus Winand',
    price: 3600,
    stock_qty: 20,
    published_year: 2015,
    rating: 4.5,
    cover: cover6,
  },
  {
    id: 7,
    title: 'Clean Code',
    author: 'Robert C. Martin',
    price: 4200,
    stock_qty: 25,
    published_year: 2008,
    rating: 5,
    cover: cover7,
  },
  {
    id: 8,
    title: 'Unpublished Prototype Notes',
    author: 'Editorial',
    price: 1000,
    stock_qty: 0,
    published_year: 2025,
    rating: 4.5,
    cover: cover8,
  },
];
