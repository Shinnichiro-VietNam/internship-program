import React from "react";

//label, error, value, onChange, name. Renders <input type="date">

type DateInputProps = React.InputHTMLAttributes<HTMLInputElement> & {
  label: string;
  error?: string;
};

export function DateInput({
  label,
  error,
  className = "",
  ...rest
}: DateInputProps) {
  return (
    <div>
      <label>
        {label}
        <input
          type="date"
          className={`border px-3 py-2 rounded-md w-full ${className}`.trim()}
          {...rest}
        />
      </label>
      {error && <p className="text-red-500 text-sm">{error}</p>}
    </div>
  );
}
