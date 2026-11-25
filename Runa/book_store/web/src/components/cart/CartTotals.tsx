import { Link } from 'react-router-dom';
import { Button } from '../ui/Button';
import { formatPrice } from '../../helper/format';
import { useAuthStore } from '../../stores/authStore';
import { useCartStore, subtotal } from '../../stores/cartStore';

export function CartTotals() {
  const lines = useCartStore((s) => s.lines);
  const token = useAuthStore((s) => s.token);
  const total = subtotal(lines);

  return (
    <div className="rounded-2xl border border-neutral-200 bg-white p-6">
      <h2 className="m-0 mb-4 text-xl font-semibold">Cart totals</h2>

      <div className="mb-3 flex items-center justify-between border-b border-neutral-100 pb-3">
        <span>Subtotal</span>
        <span>{formatPrice(total)}</span>
      </div>

      <div className="mb-6 flex items-center justify-between">
        <span className="font-semibold">Total</span>
        <span className="text-xl font-bold">{formatPrice(total)}</span>
      </div>

      {token ? (
        <>
          <Button variant="primary" fullWidth disabled>
            Proceed to checkout
          </Button>
          <p className="mt-2 text-center text-sm text-neutral-500">
            Available next week
          </p>
        </>
      ) : (
        <Link
          to="/login"
          className="block text-center text-accent no-underline"
        >
          Log in to checkout
        </Link>
      )}
    </div>
  );
}
