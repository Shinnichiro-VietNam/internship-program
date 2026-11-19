type QuantityInputProps = {
  value: number;
  min: number;
  max: number;
  onChange: (value: number) => void;
  disabled?: boolean;
};

export function QuantityInput({
  value,
  min,
  max,
  onChange,
  disabled = false,
}: QuantityInputProps) {
  return (
    <div className="inline-flex items-center rounded-full border border-neutral-200">
      <button
        type="button"
        className="h-[42px] w-[42px] disabled:cursor-not-allowed disabled:opacity-50"
        disabled={disabled || value <= min}
        onClick={() => onChange(value - 1)}
      >
        −
      </button>
      <span className="min-w-[24px] text-center">{value}</span>
      <button
        type="button"
        className="h-[42px] w-[42px] disabled:cursor-not-allowed disabled:opacity-50"
        disabled={disabled || value >= max}
        onClick={() => onChange(value + 1)}
      >
        +
      </button>
    </div>
  );
}
