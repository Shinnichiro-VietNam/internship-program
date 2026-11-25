export function EmptyCartIcon() {
  return (
    <div className="flex h-41 w-full items-center justify-center">
      <svg
        width="164"
        height="144"
        viewBox="0 0 328 288"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        {/* Cart */}
        <path
          d="M0 10H59L84 185H328"
          stroke="#999999"
          strokeWidth="20"
          strokeLinejoin="miter"
        />

        {/* X mark */}
        <path
          d="M146 12L283 149M283 12L146 149"
          stroke="#999999"
          strokeWidth="18"
        />

        {/* Wheels */}
        <circle cx="112" cy="256" r="23" stroke="#999999" strokeWidth="16" />
        <circle cx="266" cy="256" r="23" stroke="#999999" strokeWidth="16" />
      </svg>
    </div>
  );
}
