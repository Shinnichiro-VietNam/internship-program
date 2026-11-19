export function BookCardSkeleton() {
  return (
    <article className="animate-pulse">
      <div className="aspect-3/4 w-full rounded-[16px] bg-neutral-200" />
      <div className="mt-[14px] h-4 w-3/4 rounded bg-neutral-200" />
      <div className="mt-1 h-3 w-1/2 rounded bg-neutral-200" />
      <div className="mt-[6px] h-4 w-1/4 rounded bg-neutral-200" />
    </article>
  );
}
