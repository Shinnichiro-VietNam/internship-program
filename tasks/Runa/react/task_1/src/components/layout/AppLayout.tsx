import type { ReactNode } from "react";
import { Link } from "react-router-dom";

type AppLayoutProps = {
  children: ReactNode;
};

export function AppLayout({ children }: AppLayoutProps) {
  return (
    <div className="layout">
      <header className="header">
        <div className="header-left">
          <h1 className="title">Bookstore</h1>
          <Link to="/books" className="nav-link">
            Books
          </Link>
        </div>
      </header>

      <main className="main">{children}</main>

      <footer className="footer">&copy; Bookstore</footer>
    </div>
  );
}
