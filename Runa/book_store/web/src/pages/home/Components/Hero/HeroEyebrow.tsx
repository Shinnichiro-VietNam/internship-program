type HeroEyebrowProps = {
  text: string;
  motion: boolean;
};

function charOffset(index: number) {
  const seed = Math.sin(index * 12.9898) * 43758.5453;
  const unit = seed - Math.floor(seed);
  return -Math.round(36 + unit * 48);
}

export function HeroEyebrow({ text, motion }: HeroEyebrowProps) {
  if (!motion) {
    return <p className="hero-eyebrow">{text}</p>;
  }

  const chars = Array.from(text);
  const middle = (chars.length - 1) / 2;

  return (
    <p className="hero-eyebrow is-motion" aria-label={text}>
      {chars.map((char, index) => (
        <span
          key={`${char}-${index}`}
          className="hero-char"
          style={{
            ['--char-y' as string]: `${charOffset(index)}px`,
            animationDelay: `${(0.95 + Math.abs(index - middle) * 0.028).toFixed(3)}s`,
          }}
          aria-hidden="true"
        >
          {char === ' ' ? '\u00A0' : char}
        </span>
      ))}
    </p>
  );
}
