type ButtonProps = React.ButtonHTMLAttributes<HTMLButtonElement> & {
  variant?: 'primary' | 'secondary';
  size?: 'md' | 'lg';
};

export function Button({
  type = 'button',
  variant = 'primary',
  size = 'md',
  disabled,
  className = '',
  children,
  ...rest
}: ButtonProps) {
  const base =
    "inline-flex items-center justify-center rounded-[50px] text-[14px] font-['Sora',Helvetica,sans-serif] font-semibold w-full";
  const sizes = {
    md: 'h-[42px] px-[31px]',
    lg: 'px-[31px] py-[17px]',
  };
  const variants = {
    primary: 'bg-[#F65D4E] text-white',
    secondary: 'bg-green-500 text-white',
  };
  const disabledClass = disabled ? 'opacity-60 cursor-not-allowed' : '';

  return (
    <button
      type={type}
      disabled={disabled}
      className={`${base} ${sizes[size]} ${variants[variant]} ${disabledClass} ${className}`.trim()}
      {...rest}
    >
      {children}
    </button>
  );
}
