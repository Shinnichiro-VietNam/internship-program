import type { ReactNode } from 'react';

type SectionHeaderProps = {
  title: string;
  action?: ReactNode;
  compact?: boolean;
};

export function SectionHeader({ title, action, compact = false }: SectionHeaderProps) {
  const small = compact
    ? 'max-sm:text-[24px] max-sm:leading-[30px]'
    : 'max-sm:text-[28px] max-sm:leading-[34px]';

  return (
    <div className="mb-8 flex items-center">
      <h2
        className={`mr-[65px] font-['Sora',Helvetica,sans-serif] text-[44px] leading-[52px] font-semibold whitespace-nowrap text-black max-sm:mr-5 ${small}`}
      >
        {title}
      </h2>
      <span className="h-px flex-1 bg-border" />
      {action}
    </div>
  );
}
