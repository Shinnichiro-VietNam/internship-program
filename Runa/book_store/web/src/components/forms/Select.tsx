import React from "react";

//label, error, options ({ value, label }[]), value, onChange

type SelectProps = React.SelectHTMLAttributes<HTMLSelectElement> & {
  label: string;
  error?: string;
  options: { value: string; label: string }[];
};

export function Select({
  label,
  error,
  options,
  className = "",
  ...rest
}: SelectProps) {
  return (
    <div>
      <label>
        {label}
        <select
          className={`border px-3 py-2 rounded-md w-full ${className}`.trim()}
          {...rest}
        >
          {options.map((option) => (
            <option key={option.value} value={option.value}>
              {option.label}
            </option>
          ))}
        </select>
      </label>
      {error && <p className="text-red-500 text-sm">{error}</p>}
    </div>
  );
}
