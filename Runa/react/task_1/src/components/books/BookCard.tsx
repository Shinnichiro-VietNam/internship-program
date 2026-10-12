import { Link } from "react-router-dom";
import type { Book } from "../../types/books";
import { formatCurrency } from "../../lib/format";

type BookCardProps = {
  book: Book;
};

export function BookCard({ book }: BookCardProps) {
  return (
    <Link to={`/books/${book.id}`} className="book-card">
      <h3 className="book-card-title">{book.title}</h3>
      <p className="book-card-text">{book.author}</p>
      <p className="book-card-text">{formatCurrency(book.price)}</p>
    </Link>
  );
}
