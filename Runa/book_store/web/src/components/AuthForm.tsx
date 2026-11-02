import type { ReactNode } from 'react';
import { Link } from 'react-router-dom';

type AuthFormProps = {
  error?: string | null;
  footer: ReactNode;
  children: ReactNode;
};

export function AuthForm({ error, footer, children }: AuthFormProps) {
  return (
    <div className="bg-white font-['Sora',Helvetica,sans-serif] text-[14px] leading-[1.714] font-light text-[#444444]">
      <div className="w-full bg-[#F0F0F0]">
        <section className="w-full px-[15px] py-5 md:px-[30px] md:py-[30px] lg:px-[30px] lg:py-0">
          <div className="mx-auto flex w-full max-w-[1290px] flex-col items-center justify-center text-center lg:h-[200px] lg:flex-row lg:justify-between lg:text-left">
            <h1 className="mb-[10px] text-[40px] leading-[1.125] font-semibold text-black md:text-[46px] lg:mb-0 lg:text-[64px]">
              My Account
            </h1>
            <nav
              aria-label="Breadcrumb"
              className="text-[12px] leading-[15px] font-normal tracking-wide uppercase"
            >
              <Link
                to="/"
                className="text-[#999999] transition-colors hover:text-[#444444]"
              >
                Home
              </Link>
              <span className="mx-2 text-[#999999]" aria-hidden="true">
                →
              </span>
              <span className="text-[#F65D4E]">My Account</span>
            </nav>
          </div>
        </section>
      </div>

      <div className="mx-auto w-[440px] max-w-full px-4 py-16">
        {error && <p className="mb-[14px] text-red-500">{error}</p>}
        {children}
        <div className="mt-[30px] font-light">{footer}</div>
      </div>
    </div>
  );
}
