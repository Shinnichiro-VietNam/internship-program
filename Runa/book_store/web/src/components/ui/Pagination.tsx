import { Button } from './Button';

type PaginationProps = {
  currentPage: number;
  lastPage: number;
  onChange: (page: number) => void;
};

export function Pagination({
  currentPage,
  lastPage,
  onChange,
}: PaginationProps) {
  if (lastPage <= 1) return null;

  return (
    <nav className="mt-8 flex justify-center gap-4">
      <Button
        type="button"
        variant="secondary"
        className="border border-border"
        disabled={currentPage <= 1}
        onClick={() => onChange(currentPage - 1)}
      >
        Previous
      </Button>
      <p>
        Page {currentPage} of {lastPage}
      </p>

      <Button
        type="button"
        variant="secondary"
        className="border border-border"
        disabled={currentPage >= lastPage}
        onClick={() => onChange(currentPage + 1)}
      >
        Next
      </Button>
    </nav>
  );
}
