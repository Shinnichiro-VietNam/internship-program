type BookStarProps = {
  className?: string;
};

export function BookStar({ className = 'h-4 w-4' }: BookStarProps) {
  return (
    <svg viewBox="0 0 12 12" aria-hidden="true" className={className}>
      <path
        d="M6 0.8 7.4 4.2l3.6.3-2.8 2.3.9 3.5L6 8.6 3 10.3l.9-3.5L1 4.5l3.6-.3L6 .8Z"
        fill="currentColor"
      />
    </svg>
  );
}
