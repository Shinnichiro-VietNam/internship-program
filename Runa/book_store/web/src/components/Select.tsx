import React from 'react';

//label, error, options ({ value, label }[]), value, onChange

type SelectProps = {
    label: string;
    error?: string;
    options: { value: string; label: string }[];
    value: string;
    onChange: (e: React.ChangeEvent<HTMLSelectElement>) => void;
}

export function Select({ label, error, options, value, onChange }: SelectProps) {
    return (
    <div>
        <label>
            {label}
            <select
            value={value}
            onChange={onChange}
            className="border px-3 py-2 rounded-md w-full"
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