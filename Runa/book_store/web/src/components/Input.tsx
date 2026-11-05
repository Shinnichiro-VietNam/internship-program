import React from "react";
import { RequiredMark } from "./RequiredMark";

type InputProps = React.InputHTMLAttributes<HTMLInputElement> & {
  label?: React.ReactNode;
  error?: string;
  suffix?: React.ReactNode;
};

export function Input({
  label,
  error,
  suffix,
  required,
  type = "text",
  className = "",
  id,
  name,
  ...rest
}: InputProps) {
  const inputId = id ?? name;
  const inputClass = ["input-text", error ? "has-error" : "", className]
    .filter(Boolean)
    .join(" ");

  const control = (
    <input
      id={inputId}
      name={name}
      type={type}
      className={inputClass}
      aria-invalid={error ? true : undefined}
      {...rest}
    />
  );

  return (
    <p className="form-row">
      {label ? (
        <label htmlFor={inputId}>
          {label}
          {required && <RequiredMark />}
        </label>
      ) : null}
      {suffix ? (
        <span className="password-input">
          {control}
          {suffix}
        </span>
      ) : (
        control
      )}
      {error && <span className="field-error">{error}</span>}
    </p>
  );
}
