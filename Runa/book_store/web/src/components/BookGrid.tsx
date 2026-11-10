import type { SampleBook } from '../pages/home/sampleBooks';
import { BookCard } from './BookCard';
import { BookCardSkeleton } from './BookCardSkeleton';
import { EmptyState } from './EmptyState';
import { ErrorState } from './ErrorState';

type BookGridProps = {
  books: SampleBook[];
  status: 'loading' | 'error' | 'empty' | 'ready';
  errorMessage: string;
  onRetry: () => void;
};

export function BookGrid({
  books,
  status,
  errorMessage,
  onRetry,
}: BookGridProps) {
  if (status === 'loading') {
    return (
      <div className="grid grid-cols-2 gap-6 md:grid-cols-3 xl:grid-cols-5">
        {Array.from({ length: 8 }, (_, index) => (
          <BookCardSkeleton key={index} />
        ))}
      </div>
    );
  }

  if (status === 'error') {
    return <ErrorState message={errorMessage} onRetry={onRetry} />;
  }

  if (status === 'empty') {
    return <EmptyState message="No books found." />;
  }

  return (
    <div className="grid grid-cols-2 gap-6 md:grid-cols-3 xl:grid-cols-5">
      {books.map((book) => (
        <BookCard key={book.id} book={book} />
      ))}
    </div>
  );
}
