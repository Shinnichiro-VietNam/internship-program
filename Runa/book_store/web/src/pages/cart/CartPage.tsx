import { Link } from 'react-router-dom';
import { Breadcrumb } from '../../components/ui/Breadcrumb';
import { Button } from '../../components/ui/Button';
import { CartLine } from '../../components/cart/CartLine';
import { CartTotals } from '../../components/cart/CartTotals';
import { useCartStore } from '../../stores/cartStore';

function EmptyCartIcon() {
  return (
    <svg
      className="mx-auto mb-4 h-16 w-16 text-neutral-300"
      viewBox="0 0 24 24"
      fill="none"
      stroke="currentColor"
      strokeWidth="1.5"
      aria-hidden="true"
    >
      <path d="M3 3h2l.4 2M7 13h10l3-8H6.4" />
      <circle cx="9" cy="19" r="1.5" />
      <circle cx="17" cy="19" r="1.5" />
    </svg>
  );
}

export function CartPage() {
  const lines = useCartStore((s) => s.lines);

  return (
    <div>
      <div className="w-full bg-mist">
        <section className="mx-auto flex w-full max-w-[1480px] flex-col items-center justify-center px-[15px] py-5 text-center md:px-[30px] lg:h-[200px] lg:flex-row lg:justify-between lg:text-left">
          <h1 className="mb-[10px] text-[40px] font-semibold text-ink lg:mb-0 lg:text-[64px]">
            Cart
          </h1>
          <Breadcrumb items={[{ label: 'Home', to: '/' }, { label: 'Cart' }]} />
        </section>
      </div>

      <div className="mx-auto max-w-[1480px] px-4 py-10 md:px-[30px]">
        {lines.length === 0 ? (
          <div className="py-16 text-center">
            <EmptyCartIcon />
            <p className="mb-6 text-neutral-500">
              Your cart is currently empty.
            </p>
            <Link to="/" className="inline-block no-underline">
              <Button variant="primary">Return to shop</Button>
            </Link>
          </div>
        ) : (
          <div className="grid gap-8 lg:grid-cols-[1fr_20rem]">
            <div>
              <div className="overflow-x-auto">
                <table className="w-full border-collapse text-left">
                  <thead>
                    <tr className="border-b border-neutral-200 text-xs tracking-wide text-neutral-500 uppercase">
                      <th className="px-2 py-3 font-normal" />
                      <th className="px-2 py-3 font-normal">Product</th>
                      <th className="px-2 py-3 font-normal">Price</th>
                      <th className="px-2 py-3 font-normal">Quantity</th>
                      <th className="px-2 py-3 font-normal">Subtotal</th>
                    </tr>
                  </thead>
                  <tbody>
                    {lines.map((line) => (
                      <CartLine key={line.bookId} line={line} />
                    ))}
                  </tbody>
                </table>
              </div>
              <Link
                to="/"
                className="mt-6 inline-block text-accent no-underline hover:underline"
              >
                Continue shopping
              </Link>
            </div>
            <CartTotals />
          </div>
        )}
      </div>
    </div>
  );
}
