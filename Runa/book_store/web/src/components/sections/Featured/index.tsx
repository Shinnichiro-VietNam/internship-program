import { SectionHeader } from '../../ui/SectionHeader';
import { ViewAllLink } from '../../ui/ViewAllLink';
import { AuthorList } from './AuthorList';
import { PromoCards } from './PromoCards';

export function Featured() {
  return (
    <section className="pb-20" aria-label="Featured">
      <div className="mx-auto max-w-370 px-3.75">
        <PromoCards />
        <SectionHeader title="Featured Authors" action={<ViewAllLink />} />
        <AuthorList />
      </div>
    </section>
  );
}
