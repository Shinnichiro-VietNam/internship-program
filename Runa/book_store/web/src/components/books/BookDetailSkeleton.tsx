export function BookDetailSkeleton() {
  return (
    <div className="mx-auto animate-pulse px-[30px] py-10">
      <div className="mb-6 h-3 w-40 rounded bg-neutral-200" />
      <div className="grid gap-6 lg:grid-cols-2">
        <div className="rounded-2xl border border-neutral-200 bg-white p-[30px]">
          <div className="aspect-3/4 w-full rounded-4 bg-neutral-200" />
        </div>
        <div className="rounded-2xl border border-neutral-200 bg-white p-[30px]">
          <div className="mb-5 h-5 w-20 rounded bg-neutral-200" />
          <div className="mb-3 h-8 w-3/4 rounded bg-neutral-200" />
          <div className="mb-4 h-3 w-1/2 rounded bg-neutral-200" />
          <div className="mb-4 h-8 w-28 rounded bg-neutral-200" />
          <div className="mb-6 h-16 w-full rounded bg-neutral-200" />
          <div className="h-10 w-40 rounded bg-neutral-200" />
        </div>
      </div>
    </div>
  );
}
