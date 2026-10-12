import { Link, Outlet } from "react-router-dom";

export function AppLayout() {
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

      <main className="main">
        <Outlet />
      </main>

      <footer className="footer">&copy; Bookstore</footer>
    </div>
  );
}
