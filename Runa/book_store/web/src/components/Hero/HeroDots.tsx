type HeroDotsProps = {
  count: number;
  active: number;
  onSelect: (index: number) => void;
};

export function HeroDots({ count, active, onSelect }: HeroDotsProps) {
  return (
    <div className="hero-dots">
      {Array.from({ length: count }, (_, index) => (
        <button
          key={index}
          type="button"
          className={index === active ? 'hero-dot is-active' : 'hero-dot'}
          aria-label={`Slide ${index + 1}`}
          aria-current={index === active ? 'true' : undefined}
          onClick={() => onSelect(index)}
        >
          <span />
        </button>
      ))}
    </div>
  );
}
