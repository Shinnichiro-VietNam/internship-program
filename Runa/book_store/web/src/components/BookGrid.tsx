import type { ReactNode } from 'react';
import type { Book } from '../types/book';
import { BookCard } from './BookCard';
import { BookCardSkeleton } from './BookCardSkeleton';
import { EmptyState } from './EmptyState';
import { ErrorState } from './ErrorState';

type BookGridProps = {
  books: Book[];
  status: 'loading' | 'error' | 'empty' | 'ready';
  errorMessage: string;
  onRetry: () => void;
  emptyMessage?: string;
  emptyAction?: ReactNode;
};

export function BookGrid({
  books,
  status,
  errorMessage,
  onRetry,
  emptyMessage,
  emptyAction,
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
    return (
      <EmptyState
        message={emptyMessage ?? 'No books found.'}
        action={emptyAction}
      />
    );
  }

  return (
    <div className="grid grid-cols-2 gap-6 md:grid-cols-3 xl:grid-cols-5">
      {books.map((book) => (
        <BookCard key={book.id} book={book} />
      ))}
    </div>
  );
}
