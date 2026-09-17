import type { ReactNode } from "react";

type AppLayoutProps = {
    apiStatus?: ReactNode;
    children: ReactNode;
};

export function AppLayout({ apiStatus, children }: AppLayoutProps) {
    return (
        <div className="flex min-h-screen flex-col">
            <header className="flex items-center justify-between border-b p-4">
                <h1 className="text-lg font-semibold">Bookstore</h1>
                {apiStatus}
            </header>

            <main className="flex-1 p-4">{children}</main>

            <footer className="border-t p-4 text-center text-sm">&copy; Bookstore</footer>
        </div>
);
}