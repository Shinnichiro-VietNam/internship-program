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
    <div className="inline-flex items-center rounded-full border border-neutral-200 w-[160px] h-[52px] justify-between overflow-hidden">
      <button
        type="button"
        className="h-[52px] w-[47.4px] disabled:cursor-not-allowed disabled:opacity-50 transition-color hover:bg-primary"
        disabled={disabled || value <= min}
        onClick={() => onChange(value - 1)}
      >
        <span className="text-[20px]">−</span>
      </button>
      <span className="min-w-[24px] text-center py-[10px] font-[700] text-int">
        {value}
      </span>
      <button
        type="button"
        className="h-[52px] w-[47.4px] disabled:cursor-not-allowed disabled:opacity-50 transition-color hover:bg-primary"
        disabled={disabled || value >= max}
        onClick={() => onChange(value + 1)}
      >
        <span className="text-[20px]">+</span>
      </button>
    </div>
  );
}
