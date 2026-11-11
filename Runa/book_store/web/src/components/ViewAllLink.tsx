import { Link } from 'react-router-dom';
import { ChevronIcon } from './icons/ChevronIcon';

export function ViewAllLink() {
  return (
    <Link
      to="/"
      className="ml-6 inline-flex h-[42px] shrink-0 items-center gap-[3px] rounded-full bg-accent px-[31px] font-['Sora',Helvetica,sans-serif] text-[14px] leading-[18px] font-normal whitespace-nowrap text-white no-underline hover:bg-primary-hover"
    >
      View All
      <span className="inline-flex -rotate-90 [&_svg]:h-2.5 [&_svg]:w-2.5">
        <ChevronIcon />
      </span>
    </Link>
  );
}
