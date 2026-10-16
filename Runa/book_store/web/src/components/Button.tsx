import React from 'react';

//type (button or submit), variants primary and secondary, disabled, children
type ButtonProps = {
    type?: "button" | "submit";
    variant?: "primary" | "secondary";
    disabled?: boolean;
    children: React.ReactNode;
}

export function Button({ type = "button", variant = "primary", disabled, children }: ButtonProps) {
    const base = "px-4 py-2 rounded-md";
    const variants = {
        primary: "bg-blue-500 text-white",
        secondary: "bg-green-500 text-white",
    };
    const disabledClass = disabled ? "opacity-60 cursor-not-allowed" : "";

    return (
        <button
        type={type}
        disabled={disabled}
        className={`${base} ${variants[variant]} ${disabledClass}`}
        >
        {children}
        </button>
    );
}