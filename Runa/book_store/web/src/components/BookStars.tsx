export function BookStars() {
  return (
    <p
      className="flex items-center gap-[2px] mt-[6px] text-star"
      aria-label="5 stars"
    >
      {Array.from({ length: 5 }, (_, index) => (
        <svg
          key={index}
          viewBox="0 0 12 12"
          aria-hidden="true"
          className="w-4 h-4"
        >
          <path
            d="M6 0.8 7.4 4.2l3.6.3-2.8 2.3.9 3.5L6 8.6 3 10.3l.9-3.5L1 4.5l3.6-.3L6 .8Z"
            fill="currentColor"
          />
        </svg>
      ))}
      <span className="ml-1 text-lighter font-normal text-[13px]">5</span>
    </p>
  );
}
