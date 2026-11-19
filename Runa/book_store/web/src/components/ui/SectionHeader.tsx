import type { ReactNode } from 'react';

type SectionHeaderProps = {
  title: string;
  action?: ReactNode;
  size?: 'sm' | 'md' | 'lg';
  marginBottom?: string;
};

export function SectionHeader({
  title,
  action,
  size = 'lg',
  marginBottom = 'mb-8',
}: SectionHeaderProps) {
  const sizeClasses = {
    sm: 'text-[26px] leading-[1.2307692308]',
    md: 'text-[32px] leading-[40px]',
    lg: 'text-[36px] leading-[44px]',
  };

  const HeadingTag = size === 'lg' ? 'h3' : 'h2';

  return (
    <div className={`flex items-center ${marginBottom}`}>
      <HeadingTag
        className={`font-['Sora',Helvetica,sans-serif] font-semibold whitespace-nowrap text-black ${sizeClasses[size]}`}
      >
        {title}
      </HeadingTag>
      <span className="h-px flex-1 bg-border ml-[55px]" />
      {action}
    </div>
  );
}
