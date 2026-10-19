import React from 'react';

//label, error string, plus type, value, onChange, name

type InputProps = React.InputHTMLAttributes<HTMLInputElement> & {
    label: string;
    error?: string;
};

export function Input({
    label,
    error,
    type = "text",
    className = "",
    ...rest
}: InputProps) {
    return (
    <div>
        <label>
            {label}
            <input
            type={type}
            className={`border px-3 py-2 rounded-md w-full ${className}`.trim()}
            {...rest}
            />
        </label>
        {error && <p className="text-red-500 text-sm">{error}</p>}
    </div>
    );
}