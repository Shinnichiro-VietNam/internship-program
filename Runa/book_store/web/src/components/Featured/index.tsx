import { SectionHeader } from '../SectionHeader';
import { ViewAllLink } from '../ViewAllLink';
import { AuthorList } from './AuthorList';
import { PromoCards } from './PromoCards';

export function Featured() {
  return (
    <section className="pb-20" aria-label="Featured">
      <div className="mx-auto max-w-[1480px] px-[30px]">
        <PromoCards />
        <SectionHeader title="Featured Authors" action={<ViewAllLink />} />
        <AuthorList />
      </div>
    </section>
  );
}
