import { Link } from 'react-router-dom';
import { Breadcrumb } from '../../components/ui/Breadcrumb';
import { Button } from '../../components/ui/Button';
import { CartLine } from '../../components/cart/CartLine';
import { CartTotals } from '../../components/cart/CartTotals';
import { useCartStore } from '../../stores/cartStore';
import { EmptyCartIcon } from '../../components/icons/EmptyCartIcon';

export function CartPage() {
  const lines = useCartStore((s) => s.lines);

  return (
    <div>
      <div className="w-full bg-mist">
        <section className="mx-auto flex w-full max-w-370 flex-col items-center justify-center px-3.75 py-5 text-center md:px-7.5 lg:h-50 lg:flex-row lg:justify-between lg:text-left">
          <h1 className="mb-2.5 text-[40px] font-semibold text-ink lg:mb-0 lg:text-[64px]">
            Cart
          </h1>
          <Breadcrumb items={[{ label: 'Home', to: '/' }, { label: 'Cart' }]} />
        </section>
      </div>

      <div className="mx-auto max-w-370 px-4 py-10 md:px-7.5">
        {lines.length === 0 ? (
          <div className="py-16 text-center">
            <div className="mb-7.5 pb-4.5 pt-5.75 px-7.5">
              <EmptyCartIcon />
              <p className="text-ink text-[18px]">
                Your cart is currently empty.
              </p>
            </div>
            <Link to="/" className="inline-block no-underline">
              <Button variant="primary" size="lg">
                Return to shop
              </Button>
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
