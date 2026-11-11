import { Link } from 'react-router-dom';
import { ShopNow } from '../ShopNow';

function Kicker({ children }: { children: string }) {
  return (
    <span className="block text-[12px] font-bold tracking-[0.08em] uppercase">{children}</span>
  );
}

export function PromoCards() {
  return (
    <div className="mb-14 grid grid-cols-[0.85fr_1.25fr_0.9fr] gap-[22px]">
      <Link
        to="/"
        className="flex min-h-[250px] flex-col justify-between overflow-hidden rounded-[20px] bg-[#eef6fb] p-7 text-ink no-underline"
      >
        <span>
          <Kicker>Get Extra</Kicker>
          <span className="mt-2 block text-[24px] leading-[1.25] font-bold text-accent">
            Up To 15% Off
          </span>
          <ShopNow />
        </span>
      </Link>

      <Link
        to="/"
        className="flex min-h-[250px] flex-col justify-between overflow-hidden rounded-[20px] bg-[#e7f3ef] p-7 text-center text-ink no-underline"
      >
        <span>
          <Kicker>What hot in August</Kicker>
          <span className="mt-2 block text-[24px] leading-[1.25] font-bold text-accent">
            The Fiction You Need To Read In 2022
          </span>
          <ShopNow />
        </span>
      </Link>

      <Link
        to="/"
        className="flex min-h-[250px] flex-col justify-between overflow-hidden rounded-[20px] bg-[#fdecee] p-7 text-center text-ink no-underline"
      >
        <span>
          <Kicker>Summer's pick</Kicker>
          <span className="mt-2 block text-[24px] leading-[1.25] font-bold text-accent">
            Best Kids Books
          </span>
          <ShopNow />
        </span>
      </Link>
    </div>
  );
}
