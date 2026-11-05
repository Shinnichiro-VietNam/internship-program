import { Link } from 'react-router-dom';
import { formatPrice } from '../helper/format';
import type { Book } from '../types/book';

const coverColors = ['#f65d4e', '#3d9cd2', '#0f834d', '#e2a03d', '#6b5b95'];

type BookCardProps = {
  book: Book;
};

export function BookCard({ book }: BookCardProps) {
  const letter = book.title.trim().charAt(0).toUpperCase();
  const color = coverColors[Math.abs(book.id) % coverColors.length];
  const inStock = book.stock_qty > 0;

  return (
    <Link to={`/books/${book.id}`} className="block text-text">
      <div
        className="flex aspect-[3/4] items-center justify-center text-5xl font-semibold text-white"
        style={{ backgroundColor: color }}
      >
        {letter}
      </div>
      <h3 className="mt-3 line-clamp-2 font-bold text-ink">{book.title}</h3>
      <p className="mt-1 text-sm text-lighter">{book.author}</p>
      <p className="mt-2 font-bold text-accent">{formatPrice(book.price)}</p>
      <p className={`mt-1 text-sm ${inStock ? 'text-[#0f834d]' : 'text-[#e2401c]'}`}>
        {inStock ? 'In stock' : 'Out of stock'}
      </p>
    </Link>
  );
}
