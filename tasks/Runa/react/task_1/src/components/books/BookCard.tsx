import type { Book } from "../../types/books";
import { formatCurrency } from "../../lib/format";

type BookCardProps = {
    book: Book;
};

export function BookCard({ book }: BookCardProps) {
    return (
        <div className="bg-white rounded-lg shadow-md p-4 border border-gray-100">
            <h3 className="text-lg font-semibold">{book.title}</h3>
            <p className="text-sm text-gray-500">{book.author}</p>
            <p className="text-sm text-gray-500">{formatCurrency(book.price)}</p>
        </div>
    );
}