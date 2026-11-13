import { ChevronIcon } from './icons/ChevronIcon';

export function ShopNow() {
  return (
    <span className="shop-now mt-3.5 inline-flex items-center gap-1.5 text-[14px] font-semibold">
      Shop Now
      <span className="shop-now-arrow">
        <ChevronIcon />
      </span>
    </span>
  );
}
