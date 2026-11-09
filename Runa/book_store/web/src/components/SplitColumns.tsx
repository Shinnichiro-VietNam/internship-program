import type { ReactNode } from 'react';

type SplitColumnsProps = {
  main: ReactNode;
  side: ReactNode;
  columns?: string;
};

export function SplitColumns({
  main,
  side,
  columns = 'grid-cols-[minmax(0,1fr)_300px]',
}: SplitColumnsProps) {
  return (
    <div className={`grid items-start gap-[30px] ${columns}`}>
      <div>{main}</div>
      {side}
    </div>
  );
}
