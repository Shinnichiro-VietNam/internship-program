import { Link } from 'react-router-dom';
import { QuantityInput } from '../forms/QuantityInput';
import { StockBadge } from '../ui/StockBadge';
import { formatPrice } from '../../helper/format';
import {
  useCartStore,
  type CartLine as CartLineType,
} from '../../stores/cartStore';

type Props = {
  line: CartLineType;
};

export function CartLine({ line }: Props) {
  const remove = useCartStore((s) => s.remove);
  const setQuantity = useCartStore((s) => s.setQuantity);

  return (
    <tr className="border-b border-neutral-200">
      <td className="px-2 py-4 align-middle">
        <button
          type="button"
          className="text-lighter hover:text-ink"
          aria-label={`Remove ${line.title}`}
          onClick={() => remove(line.bookId)}
        >
          ×
        </button>
      </td>
      <td className="px-2 py-4 align-middle">
        <div className="flex items-center gap-3">
          <div className="h-20 w-14 shrink-0 rounded bg-neutral-200" />
          <div className="min-w-0">
            <Link
              to={`/books/${line.bookId}`}
              className="font-semibold text-ink no-underline hover:text-accent"
            >
              {line.title}
            </Link>
            <p className="m-0 mt-1 text-sm text-neutral-500">{line.author}</p>
            <div className="mt-2">
              <StockBadge stockQty={line.stockQty} />
            </div>
          </div>
        </div>
      </td>
      <td className="px-2 py-4 align-middle">{formatPrice(line.price)}</td>
      <td className="px-2 py-4 align-middle">
        <QuantityInput
          value={line.quantity}
          min={1}
          max={line.stockQty}
          onChange={(value) => setQuantity(line.bookId, value)}
        />
      </td>
      <td className="px-2 py-4 align-middle font-semibold">
        {formatPrice(line.price * line.quantity)}
      </td>
    </tr>
  );
}
