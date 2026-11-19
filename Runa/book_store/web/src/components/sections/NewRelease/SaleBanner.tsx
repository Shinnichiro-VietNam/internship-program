import { Link } from 'react-router-dom';
import { ShopNow } from '../ShopNow';

export function SaleBanner() {
  return (
    <Link
      to="/"
      className="mb-12 flex min-h-[190px] items-center overflow-hidden rounded-2xl bg-[#fdf3f1] px-9 py-7 text-ink no-underline"
    >
      <span>
        <span className="block text-[12px] font-bold tracking-[0.08em] uppercase">
          Our biggest sale
        </span>
        <span className="mt-2 block max-w-[280px] text-[32px] leading-[1.15] font-bold">
          50% Hundreds Of Top Books
        </span>
        <ShopNow />
      </span>
    </Link>
  );
}
