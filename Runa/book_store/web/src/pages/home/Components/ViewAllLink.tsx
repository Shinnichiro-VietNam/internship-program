import { Link } from 'react-router-dom';
import { ChevronIcon } from '../../../components/icons/ChevronIcon';

export function ViewAllLink() {
  return (
    <Link
      to="/"
      className="ml-6 inline-flex h-10.5 shrink-0 items-center gap-0.75 rounded-full bg-accent px-7.75 font-['Sora',Helvetica,sans-serif] text-[14px] leading-4.5 font-normal whitespace-nowrap text-white no-underline hover:bg-primary-hover"
    >
      View All
      <span className="inline-flex -rotate-90 [&_svg]:h-2.5 [&_svg]:w-2.5">
        <ChevronIcon />
      </span>
    </Link>
  );
}
