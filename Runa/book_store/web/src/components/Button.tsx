import React from 'react';

type ButtonProps = React.ButtonHTMLAttributes<HTMLButtonElement> & {
    variant?: "primary" | "secondary";
};

export function Button({
    type = "button",
    variant = "primary",
    disabled,
    className = "",
    children,
    ...rest
}: ButtonProps) {
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
            className={`${base} ${variants[variant]} ${disabledClass} ${className}`.trim()}
            {...rest}
        >
            {children}
        </button>
    );
}
