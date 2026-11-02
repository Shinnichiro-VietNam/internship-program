import React from "react";

type InputProps = React.InputHTMLAttributes<HTMLInputElement> & {
  label: React.ReactNode;
  error?: string;
  suffix?: React.ReactNode;
};

export function Input({
  label,
  error,
  suffix,
  type = "text",
  className = "",
  id,
  name,
  ...rest
}: InputProps) {
  const inputId = id ?? name;

  return (
    <p className="form-row">
      <label htmlFor={inputId}>{label}</label>
      {suffix ? (
        <span className="password-input">
          <input
            id={inputId}
            name={name}
            type={type}
            className={["input-text", className].filter(Boolean).join(" ")}
            {...rest}
          />
          {suffix}
        </span>
      ) : (
        <input
          id={inputId}
          name={name}
          type={type}
          className={["input-text", className].filter(Boolean).join(" ")}
          {...rest}
        />
      )}
      {error && <span className="field-error">{error}</span>}
    </p>
  );
}
