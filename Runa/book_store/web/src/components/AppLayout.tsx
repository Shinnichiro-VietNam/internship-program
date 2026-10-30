import { useEffect, useState } from 'react';
import { Link, Outlet, useSearchParams } from 'react-router-dom';
import { Auth } from '../models/Auth';
import { useAuthStore } from '../stores/authStore';
import { Input } from './Input';
import { Button } from './Button';

export function AppLayout() {
  const [searchParams, setSearchParams] = useSearchParams();
  const [draft, setDraft] = useState(searchParams.get('title') ?? '');
  const token = useAuthStore((s) => s.token);
  const user = useAuthStore((s) => s.user);

  useEffect(() => {
    if (!token || user) return;
    Auth.me()
      .then((res) => useAuthStore.getState().setUser(res.data))
      .catch(() => {});
  }, [token, user]);

  return (
    <div>
      <header>
        <Link to="/">Bookstore</Link>
        <form
          onSubmit={(event) => {
            event.preventDefault();
            const next = new URLSearchParams();
            const value = draft.trim();
            if (value) next.set('title', value);
            setSearchParams(next);
          }}
        >
          <Input
            label="Search"
            value={draft}
            onChange={(event) => setDraft(event.target.value)}
          />
          <Button type="submit">Search</Button>
        </form>
        <Link to="/cart">Cart</Link>
        {user ? (
          <Link to="/account">{user.name}</Link>
        ) : (
          <Link to="/login">Login</Link>
        )}
      </header>
      <main>
        <Outlet />
      </main>
      <footer>
        <p>Your store line</p>
        <Link to="/account">Account</Link>
      </footer>
    </div>
  );
}
