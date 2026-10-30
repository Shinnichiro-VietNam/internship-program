import { Link } from 'react-router-dom';
import type { Book } from '../types/book';
import { formatPrice } from '../helper/format';

type BookCardProps = {
  book: Book;
};

export function BookCard({ book }: BookCardProps) {
  const inStock = book.stock_qty > 0;

  return (
    <Link to={`/books/${book.id}`}>
      <h2>{book.title}</h2>
      <p>{book.author}</p>
      <p>{formatPrice(book.price)}</p>
      <p>{inStock ? 'In stock' : 'Out of stock'}</p>
    </Link>
  );
}
