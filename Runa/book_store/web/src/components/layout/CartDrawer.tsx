import { useEffect } from 'react';
import { Link } from 'react-router-dom';
import { Button } from '../ui/Button';
import { formatPrice } from '../../helper/format';
import { useAuthStore } from '../../stores/authStore';
import { useCartStore, subtotal } from '../../stores/cartStore';

export function CartDrawer() {
  const lines = useCartStore((s) => s.lines);
  const isDrawerOpen = useCartStore((s) => s.isDrawerOpen);
  const closeDrawer = useCartStore((s) => s.closeDrawer);
  const remove = useCartStore((s) => s.remove);
  const token = useAuthStore((s) => s.token);
  const total = subtotal(lines);

  useEffect(() => {
    if (!isDrawerOpen) return;

    const onKeyDown = (event: KeyboardEvent) => {
      if (event.key === 'Escape') closeDrawer();
    };

    document.addEventListener('keydown', onKeyDown);
    document.body.style.overflow = 'hidden';

    return () => {
      document.removeEventListener('keydown', onKeyDown);
      document.body.style.overflow = '';
    };
  }, [isDrawerOpen, closeDrawer]);

  return (
    <>
      <div
        className={`fixed inset-0 z-40 bg-black/40 transition-opacity ${
          isDrawerOpen ? 'opacity-100' : 'pointer-events-none opacity-0'
        }`}
        onClick={closeDrawer}
        aria-hidden={!isDrawerOpen}
      />

      <aside
        className={`fixed top-0 right-0 z-50 flex h-full w-96 max-w-full flex-col bg-white shadow-xl transition-transform duration-300 ${
          isDrawerOpen ? 'translate-x-0' : 'translate-x-full'
        }`}
        aria-hidden={!isDrawerOpen}
        aria-label="Shopping cart"
      >
        <div className="flex items-center justify-between border-b border-neutral-200 px-5 py-4">
          <h2 className="m-0 text-lg font-semibold text-ink">Shopping cart</h2>
          <button
            type="button"
            className="group inline-flex items-center gap-1 text-sm tracking-wide text-ink uppercase text-[13px] font-bold"
            onClick={closeDrawer}
            aria-label="Close cart"
          >
            Close
            <span
              className="cart-close-icon relative inline-block h-3 w-3"
              aria-hidden="true"
            />
          </button>
        </div>

        <div className="flex-1 overflow-y-auto">
          {lines.length === 0 ? (
            <p className="m-6.25 text-center text-neutral-500 text-[18px]">
              No products in the cart.
            </p>
          ) : (
            <ul className="m-0 flex list-none flex-col gap-4 pt-3.5 pr-7.5 pb-3.75 pl-3.75">
              {lines.map((line) => (
                <li
                  key={line.bookId}
                  className="relative flex gap-3 border-b border-neutral-100 pb-4"
                >
                  <div className="h-20 w-14 shrink-0 rounded bg-neutral-200" />
                  <div className="min-w-0 flex-1 pr-6">
                    <Link
                      to={`/books/${line.bookId}`}
                      className="block truncate font-semibold text-ink no-underline hover:text-accent"
                      onClick={closeDrawer}
                    >
                      {line.title}
                    </Link>
                    <p className="m-0 mt-1 text-sm text-neutral-500">
                      {line.author}
                    </p>
                    <p className="m-0 mt-2 text-sm text-ink text-[18px]">
                      {line.quantity} × {formatPrice(line.price)}
                    </p>
                  </div>
                  <button
                    type="button"
                    className="absolute top-0 right-0 text-lighter hover:text-ink text-[18px]"
                    aria-label={`Remove ${line.title}`}
                    onClick={() => remove(line.bookId)}
                  >
                    ×
                  </button>
                </li>
              ))}
            </ul>
          )}
        </div>

        {lines.length > 0 && (
          <div className="border-t border-neutral-200 px-5 py-4">
            <div className="mb-4 flex items-center justify-between text-[18px]">
              <strong>Subtotal:</strong>
              <span className="font-semibold">{formatPrice(total)}</span>
            </div>

            <Link
              to="/cart"
              className="block no-underline"
              onClick={closeDrawer}
            >
              <Button
                variant="tertiary"
                className="transition-colors hover:bg-tertiary-hover"
                fullWidth
                uppercase
              >
                View Cart
              </Button>
            </Link>

            <div className="mt-3 uppercase">
              {token ? (
                <Button variant="primary" fullWidth uppercase disabled>
                  Checkout
                </Button>
              ) : (
                <Link
                  to="/login"
                  className="block text-center text-accent no-underline"
                  onClick={closeDrawer}
                >
                  <Button variant="primary" fullWidth uppercase>
                    Checkout
                  </Button>
                </Link>
              )}
            </div>
          </div>
        )}
      </aside>
    </>
  );
}
