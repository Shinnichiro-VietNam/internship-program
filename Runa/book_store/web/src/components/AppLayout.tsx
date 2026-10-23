import { Link, Outlet } from 'react-router-dom';
import { useAuthStore } from '../stores/authStore';

export function AppLayout() {
  const token = useAuthStore((s) => s.token);
  const user = useAuthStore((s) => s.user);

  return (
    <div className="min-h-screen flex flex-col">
      <header className="flex items-center gap-4 p-4 border-b">
        <Link to="/" className="font-bold text-lg">
          Happy Books
        </Link>
        <Link to="/">Home</Link>
        <Link to="/cart">Cart</Link>
        <div className="ml-auto">
          {token ? (
            <Link to="/account">{user?.name ?? 'Account'}</Link>
          ) : (
            <Link to="/login">Login</Link>
          )}
        </div>
      </header>

      <main className="flex-1 p-4">
        <Outlet />
      </main>
      <footer className="p-4 border-t text-sm">
        <p>
          Thanks for visiting Happy Books. <Link to="/account">Account</Link>
        </p>
      </footer>
    </div>
  );
}
