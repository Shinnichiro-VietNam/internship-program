import type { ReactNode } from 'react';

const stroke = {
  fill: 'none',
  stroke: 'currentColor',
  strokeWidth: 1.6,
  strokeLinecap: 'round' as const,
  strokeLinejoin: 'round' as const,
};

const categories: { label: string; icon: ReactNode }[] = [
  {
    label: 'Action & Adventure',
    icon: (
      <svg viewBox="0 0 24 24" aria-hidden="true">
        <circle cx="16.5" cy="6.5" r="2.1" {...stroke} />
        <path d="M3 18.5 8.2 12l3.2 3.6" {...stroke} />
        <path d="M10.2 15.2 14.8 9.2 21 18.5" {...stroke} />
      </svg>
    ),
  },
  {
    label: 'Americas',
    icon: (
      <svg viewBox="0 0 24 24" aria-hidden="true">
        <path
          d="m12 3.4 2.15 4.55 5 .68-3.65 3.45.9 4.95L12 14.7l-4.4 2.33.9-4.95L4.85 8.63l5-.68Z"
          {...stroke}
        />
      </svg>
    ),
  },
  {
    label: 'Arts & Photography',
    icon: (
      <svg viewBox="0 0 24 24" aria-hidden="true">
        <path d="M19.5 4.5c-5.2.6-10.2 5.2-12.6 13.2" {...stroke} />
        <path d="M6.8 17.6c2.6-.7 6.2-3.2 9.4-7.6" {...stroke} />
        <path d="M9.2 15.4c1.8-.5 3.8-1.8 5.6-3.8" {...stroke} />
      </svg>
    ),
  },
  {
    label: 'Biographies',
    icon: (
      <svg viewBox="0 0 24 24" aria-hidden="true">
        <path
          d="M12 6.2c-1.8-1.3-4.1-2-7-2v12.2c2.9 0 5.2.7 7 2 1.8-1.3 4.1-2 7-2V4.2c-2.9 0-5.2.7-7 2Z"
          {...stroke}
        />
        <path d="M12 6.2v12.2" {...stroke} />
      </svg>
    ),
  },
  {
    label: 'Children’s Books',
    icon: (
      <svg viewBox="0 0 24 24" aria-hidden="true">
        <circle cx="12" cy="8" r="3" {...stroke} />
        <path d="M5.5 19.2c.9-3.3 3.3-5 6.5-5s5.6 1.7 6.5 5" {...stroke} />
      </svg>
    ),
  },
  {
    label: 'Classics',
    icon: (
      <svg viewBox="0 0 24 24" aria-hidden="true">
        <path d="M12 20.5c3.6-3.4 6-7.1 6-10.6a6 6 0 0 0-12 0c0 3.5 2.4 7.2 6 10.6Z" {...stroke} />
        <path d="M12 20.2V10.5" {...stroke} />
        <circle cx="12" cy="8.6" r="1" {...stroke} />
      </svg>
    ),
  },
  {
    label: 'Contemporary',
    icon: (
      <svg viewBox="0 0 24 24" aria-hidden="true">
        <path d="M6 20.5V4" {...stroke} />
        <path d="M6 5.2h11.2L15 8.6l2.2 3.4H6" {...stroke} />
      </svg>
    ),
  },
  {
    label: 'Education & Reference',
    icon: (
      <svg viewBox="0 0 24 24" aria-hidden="true">
        <path d="M7 4.5h8.2L18 7.2V19.5H7Z" {...stroke} />
        <path d="M15.2 4.6V7.2H18" {...stroke} />
        <path d="M10 11.2h5M10 14.2h5" {...stroke} />
      </svg>
    ),
  },
  {
    label: 'Genre Fiction',
    icon: (
      <svg viewBox="0 0 24 24" aria-hidden="true">
        <circle cx="12" cy="12" r="1.7" {...stroke} />
        <circle cx="12" cy="5.4" r="2.15" {...stroke} />
        <circle cx="17.7" cy="8.7" r="2.15" {...stroke} />
        <circle cx="17.7" cy="15.3" r="2.15" {...stroke} />
        <circle cx="12" cy="18.6" r="2.15" {...stroke} />
        <circle cx="6.3" cy="15.3" r="2.15" {...stroke} />
        <circle cx="6.3" cy="8.7" r="2.15" {...stroke} />
      </svg>
    ),
  },
  {
    label: 'Historical',
    icon: (
      <svg viewBox="0 0 24 24" aria-hidden="true">
        <path d="M5 19c0-7.2 5.4-13 14.5-14C18.6 12.2 13 19 5 19Z" {...stroke} />
        <path d="M5.5 18.5c3.6-3.4 6.4-6.2 9.6-9" {...stroke} />
      </svg>
    ),
  },
];

export function CategoryMenu() {
  return (
    <div className="header-categories-menu">
      <ul>
        {categories.map((item) => (
          <li key={item.label}>
            <a href="#categories" onClick={(event) => event.preventDefault()}>
              {item.icon}
              {item.label}
            </a>
          </li>
        ))}
      </ul>
    </div>
  );
}
