import { useId } from 'react';

type BookStarHalfProps = {
  className?: string;
};

export function BookStarHalf({ className = 'h-4 w-4' }: BookStarHalfProps) {
  const clipId = `star-half-${useId().replace(/:/g, '')}`;

  return (
    <svg viewBox="0 0 12 12" aria-hidden="true" className={className}>
      <defs>
        <clipPath id={clipId}>
          <rect width="6" height="12" />
        </clipPath>
      </defs>
      <path
        d="M6 0.8 7.4 4.2l3.6.3-2.8 2.3.9 3.5L6 8.6 3 10.3l.9-3.5L1 4.5l3.6-.3L6 .8Z"
        fill="#d9d9d9"
      />
      <path
        d="M6 0.8 7.4 4.2l3.6.3-2.8 2.3.9 3.5L6 8.6 3 10.3l.9-3.5L1 4.5l3.6-.3L6 .8Z"
        fill="currentColor"
        clipPath={`url(#${clipId})`}
      />
    </svg>
  );
}
