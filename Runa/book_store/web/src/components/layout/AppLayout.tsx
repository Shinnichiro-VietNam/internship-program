import { Outlet } from 'react-router-dom';
import { Footer } from './Footer';
import { Header } from './Header';
import { CartDrawer } from './CartDrawer';

export function AppLayout() {
  return (
    <div className="flex min-h-screen flex-col bg-background font-['Sora',Helvetica,sans-serif] text-[14px] font-light text-text">
      <Header />

      <main className="flex-1">
        <Outlet />
      </main>

      <Footer />
      <CartDrawer />
    </div>
  );
}
