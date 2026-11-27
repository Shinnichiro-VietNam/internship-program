type ButtonProps = React.ButtonHTMLAttributes<HTMLButtonElement> & {
  variant?: 'primary' | 'secondary' | 'tertiary';
  size?: 'sm' | 'md' | 'lg';
  fullWidth?: boolean;
  uppercase?: boolean;
};

export function Button({
  type = 'button',
  variant = 'primary',
  size = 'md',
  fullWidth = false,
  disabled,
  uppercase = false,
  className = '',
  children,
  ...rest // get another props default size is md and variant color is primary
}: ButtonProps) {
  const base =
    'inline-flex items-center justify-center rounded-full text-[14px] font-semibold';
  const sizes = {
    sm: 'px-[12px] py-[31px]',
    md: 'h-[42px] px-[31px]',
    lg: 'px-[28px] py-[17px]',
  };
  const variants = {
    primary: 'bg-accent text-white',
    secondary: 'bg-background text-ink',
    tertiary: 'bg-tertiary text-ink',
  };
  const width = fullWidth ? 'w-full' : '';
  const disabledClass = disabled ? 'cursor-not-allowed opacity-50' : '';
  const uppercaseClass = uppercase ? 'uppercase' : '';
  return (
    <button
      type={type}
      disabled={disabled}
      className={`${base} ${sizes[size]} ${variants[variant]} ${width} ${disabledClass} ${uppercaseClass} ${className}`.trim()} // trim() -> remove extra space
      {...rest}
    >
      {children}
    </button>
  );
}
