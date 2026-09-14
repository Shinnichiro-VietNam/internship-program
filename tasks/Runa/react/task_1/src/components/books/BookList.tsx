import type { Book } from "../../types/books";
import { BookCard } from "./BookCard";

type BookListProps = {
    books: Book[];
};

export function BookList({ books }: BookListProps) {
  // 本が0
    if (books.length === 0) {
    return (
        <div className="py-12 text-center text-gray-500">
            <p>There are no books</p>
        </div>
    );
    }

  //　本がある場合
    return (
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            {books.map((book) => (
            <BookCard key={book.id} book={book} />
            ))}
        </div>
    );
}