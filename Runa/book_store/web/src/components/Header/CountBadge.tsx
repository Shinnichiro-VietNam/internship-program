export function CountBadge({ count }: { count: number }) {
  return (
    <span className="count-badge absolute flex items-center justify-center bg-accent text-white">
      {count}
    </span>
  );
}
