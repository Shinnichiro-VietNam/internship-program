import React from 'react';

//label, error, value, onChange, name. Renders <input type="date">

type DateInputProps = {
    label: string;
    error?: string;
    value: string;
    onChange: (e: React.ChangeEvent<HTMLInputElement>) => void;
    name: string;
};

export function DateInput({ label, error, value, onChange, name }: DateInputProps) {
    return (
    <div>
        <label>
            {label}
            <input
            type="date"
            name={name}
            value={value}
            onChange={onChange}
            className="border px-3 py-2 rounded-md w-full"
            />
        </label>
        {error && <p className="text-red-500 text-sm">{error}</p>}
    </div>
    );
}