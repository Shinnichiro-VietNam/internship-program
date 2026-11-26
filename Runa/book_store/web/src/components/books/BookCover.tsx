type BookCoverProps = {
  src: string;
};

export function BookCover({ src }: BookCoverProps) {
  return (
    <img
      className="block w-full aspect-3/4 object-cover rounded-2xl"
      src={src}
      alt=""
    />
  );
}
