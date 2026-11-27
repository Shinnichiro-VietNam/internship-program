import { Link } from 'react-router-dom';

type Crumb = { label: string; to?: string };

export function Breadcrumb({ items }: { items: Crumb[] }) {
  return (
    <nav
      aria-label="Breadcrumb"
      className="mb-6 flex flex-wrap text-xs uppercase leading-[1.6666666667] font-[500]"
    >
      {items.map((item, i) => {
        const isLast = i === items.length - 1;
        return (
          <span key={`${item.label}-${i}`} className="flex items-center">
            {i > 0 && (
              <span className="mx-[15px] text-lighter" aria-hidden>
                →
              </span>
            )}
            {isLast || !item.to ? (
              <span className={isLast ? 'text-accent' : undefined}>
                {item.label}
              </span>
            ) : (
              <Link
                to={item.to}
                className="no-underline text-lighter transition-colors hover:text-ink"
              >
                {item.label}
              </Link>
            )}
          </span>
        );
      })}
    </nav>
  );
}
