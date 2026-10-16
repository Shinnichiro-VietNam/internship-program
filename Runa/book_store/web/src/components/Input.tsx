import React from 'react';

//label, error string, plus type, value, onChange, name

type InputProps = {
    label: string;
    error?: string;
    type?: string;
    value: string;
    onChange: (e: React.ChangeEvent<HTMLInputElement>) => void;
    name: string;
};

export function Input({ label, error, type = "text", value, onChange, name }: InputProps) {
    return (
    <div>
        <label>
            {label}
            <input
            type={type}
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