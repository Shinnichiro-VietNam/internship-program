import brand1 from '../../assets/icons/brand_1.svg';
import brand2 from '../../assets/icons/brand_2.svg';
import brand3 from '../../assets/icons/brand_3.svg';
import brand4 from '../../assets/icons/brand_4.svg';
import brand5 from '../../assets/icons/brand_5.svg';
import brand6 from '../../assets/icons/brand_6.svg';
import { SectionHeader } from '../SectionHeader';
import { ViewAllLink } from '../ViewAllLink';

const publishers = [
  { name: 'North', src: brand1 },
  { name: 'Lumen', src: brand2 },
  { name: 'Field', src: brand3 },
  { name: 'Ark', src: brand4 },
  { name: 'Quill', src: brand5 },
  { name: 'Harbor', src: brand6 },
];

export function Publishers() {
  return (
    <section className="pb-[100px]" aria-label="Featured Publishers">
      <div className="mx-auto max-w-[1290px] px-[30px]">
        <SectionHeader title="Featured Publishers" action={<ViewAllLink />} compact />
        <ul className="mt-2 flex list-none items-center justify-between gap-7 p-0 max-[900px]:grid max-[900px]:grid-cols-3 max-[900px]:gap-x-4 max-[900px]:gap-y-8 max-sm:grid-cols-2">
          {publishers.map(({ name, src }) => (
            <li key={name} className="flex min-w-0 flex-1 items-center justify-center">
              <img src={src} alt={name} className="block h-[88px] w-auto max-w-full" />
            </li>
          ))}
        </ul>
      </div>
    </section>
  );
}
