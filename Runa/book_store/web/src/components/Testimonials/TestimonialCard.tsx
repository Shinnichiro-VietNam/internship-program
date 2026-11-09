const tones = {
  blue: 'bg-[#e3f4f6]',
  pink: 'bg-[#fdf0ec]',
  mint: 'bg-[#e7f4e8]',
};

type TestimonialCardProps = {
  name: string;
  city: string;
  quote: string;
  tone: keyof typeof tones;
  photo: string;
};

export function TestimonialCard({ name, city, quote, tone, photo }: TestimonialCardProps) {
  return (
    <li
      className={`flex flex-col items-center rounded-[18px] px-7 pt-9 pb-10 text-center ${tones[tone]}`}
    >
      <img
        src={photo}
        alt=""
        className="size-[110px] rounded-full object-cover"
      />
      <p className="mt-5 max-w-[290px] text-[15px] leading-[1.7] font-normal text-[#4a4a4a]">
        “{quote}”
      </p>
      <p className="mt-auto pt-7 text-[12px] font-medium tracking-[0.12em] text-[#8d8d8d] uppercase">
        {name} / {city}
      </p>
    </li>
  );
}
