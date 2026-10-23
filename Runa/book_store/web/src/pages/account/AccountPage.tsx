import { useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { Button } from '../../components/Button';
import { Auth } from '../../models/Auth';
import { useAuthStore } from '../../stores/authStore';

export function AccountPage() {
  const navigate = useNavigate();
  const user = useAuthStore((s) => s.user);

  useEffect(() => {
    if (user) return;
    Auth.me()
      .then((res) => useAuthStore.getState().setUser(res.data))
      .catch(() => {});
  }, [user]);

  const handleLogout = async () => {
    try {
      await Auth.logout();
    } finally {
      useAuthStore.getState().setToken(null);
      useAuthStore.getState().setUser(null);
      navigate('/login');
    }
  };

  return (
    <div className="p-8 max-w-md mx-auto space-y-4">
      <h1 className="text-2xl font-bold">Account</h1>
      <p>Name: {user?.name}</p>
      <p>Email: {user?.email}</p>
      <Button type="button" onClick={handleLogout}>
        Logout
      </Button>
    </div>
  );
}
