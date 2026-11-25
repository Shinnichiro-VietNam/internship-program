import type { ReactNode } from 'react';
import { Link } from 'react-router-dom';

type AuthLayoutProps = {
  title: string;
  children: ReactNode;
};

export function AuthLayout({ title, children }: AuthLayoutProps) {
  return (
    <div className="bg-background font-['Sora',Helvetica,sans-serif] text-[14px] leading-[1.714] font-light text-text">
      <div className="w-full bg-mist">
        <section className="w-full px-3.75 py-5 md:px-7.5 md:py-7.5 lg:px-7.5 lg:py-0">
          <div className="mx-auto flex w-full max-w-370 flex-col items-center justify-center text-center lg:h-50 lg:flex-row lg:justify-between lg:text-left">
            <h1 className="mb-2.5 text-[40px] leading-[1.125] font-semibold text-ink md:text-[46px] lg:mb-0 lg:text-[64px]">
              {title}
            </h1>
            <nav
              aria-label="Breadcrumb"
              className="text-[12px] leading-3.75 font-normal tracking-wide uppercase"
            >
              <Link
                to="/"
                className="text-lighter transition-colors hover:text-text"
              >
                Home
              </Link>
              <span className="mx-2 text-lighter" aria-hidden="true">
                →
              </span>
              <span className="text-accent">{title}</span>
            </nav>
          </div>
        </section>
      </div>

      <div className="mx-auto w-110 max-w-full px-4 py-16">{children}</div>
    </div>
  );
}
