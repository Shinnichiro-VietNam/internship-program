type ButtonProps = React.ButtonHTMLAttributes<HTMLButtonElement> & {
  variant?: 'primary' | 'secondary';
  size?: 'md' | 'lg';
  fullWidth?: boolean;
};

export function Button({
  type = 'button',
  variant = 'primary',
  size = 'md',
  fullWidth = false,
  disabled,
  className = '',
  children,
  ...rest
}: ButtonProps) {
  const base =
    'inline-flex items-center justify-center rounded-full text-[14px] font-semibold';
  const sizes = {
    md: 'h-[42px] px-[31px]',
    lg: 'px-[31px] py-[17px]',
  };
  const variants = {
    primary: 'bg-accent text-white',
    secondary: 'border border-border bg-background text-ink',
  };
  const width = fullWidth ? 'w-full' : '';
  const disabledClass = disabled ? 'cursor-not-allowed opacity-60' : '';

  return (
    <button
      type={type}
      disabled={disabled}
      className={`${base} ${sizes[size]} ${variants[variant]} ${width} ${disabledClass} ${className}`.trim()}
      {...rest}
    >
      {children}
    </button>
  );
}
