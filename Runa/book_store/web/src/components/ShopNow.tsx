import { ChevronIcon } from './icons/ChevronIcon';

export function ShopNow() {
  return (
    <span className="mt-3.5 inline-flex items-center gap-1.5 text-[14px] font-semibold">
      Shop Now
      <span className="inline-flex -rotate-90">
        <ChevronIcon />
      </span>
    </span>
  );
}
