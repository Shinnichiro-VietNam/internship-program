import quoteMark from '../../assets/icons/quote.svg';

type TestimonialCardProps = {
  name: string;
  city: string;
  quote: string;
  photo: string;
  background: string;
};

export function TestimonialCard({
  name,
  city,
  quote,
  photo,
  background,
}: TestimonialCardProps) {
  return (
    <li
      className="relative flex flex-col items-center overflow-hidden rounded-[18px] px-7 pt-9 pb-14 text-center"
      style={{ background }}
    >
      <img
        src={photo}
        alt=""
        className="size-[70px] rounded-full object-cover"
      />
      <p className="mt-5 max-w-[290px] text-[15px] leading-[1.7] font-normal text-[#4a4a4a]">
        “{quote}”
      </p>
      <p className="relative z-10 mt-auto pt-7 text-[12px] font-medium tracking-[0.12em] uppercase">
        <span className="text-[#000]">{name}</span>
        <span className="text-[#999]"> / {city}</span>
      </p>
      <img
        src={quoteMark}
        alt=""
        className="pointer-events-none absolute bottom-1 left-1/2 w-[96px] -translate-x-1/2 select-none"
      />
    </li>
  );
}
