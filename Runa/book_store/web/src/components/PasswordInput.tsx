import { useState, type ComponentProps } from 'react';
import { EyeIcon } from './icons/EyeIcon';
import { Input } from './Input';

type PasswordInputProps = Omit<ComponentProps<typeof Input>, 'type' | 'suffix'>;

export function PasswordInput(props: PasswordInputProps) {
  const [showPassword, setShowPassword] = useState(false);

  return (
    <Input
      {...props}
      type={showPassword ? 'text' : 'password'}
      suffix={
        <button
          type="button"
          className="show-password-input"
          aria-label={showPassword ? 'Hide password' : 'Show password'}
          aria-describedby={props.id ?? props.name}
          onClick={() => setShowPassword((current) => !current)}
        >
          <EyeIcon />
        </button>
      }
    />
  );
}
