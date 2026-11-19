export function StockBadge({ stockQty }: { stockQty: number }) {
  const inStock = stockQty > 0;
  return (
    <p
      className={`inline px-[9px] text-xs uppercase rounded-[3px] leading-[1.6666666667] ${inStock ? 'bg-[rgba(130,209,117,0.2)] text-[#82D175]' : 'bg-[rgba(255,77,79,0.2)] text-[#FF4D4F]'}`}
    >
      {inStock ? 'In stock' : 'Out of stock'}
    </p>
  );
}
