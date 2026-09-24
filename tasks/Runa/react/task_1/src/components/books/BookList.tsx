import type { Book } from "../../types/books";
import { BookCard } from "./BookCard";

type BookListProps = {
  books: Book[];
};

export function BookList({ books }: BookListProps) {
  if (books.length === 0) {
    return (
      <div className="empty">
        <p>There are no books</p>
      </div>
    );
  }

  return (
    <div className="book-list">
      {books.map((book) => (
        <BookCard key={book.id} book={book} />
      ))}
    </div>
  );
}
