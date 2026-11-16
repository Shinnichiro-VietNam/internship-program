import { useState } from 'react';
import { Link, useParams } from 'react-router-dom';
import { BookCard } from '../../components/books/BookCard';
import { Button } from '../../components/ui/Button';
import { EmptyState } from '../../components/ui/EmptyState';
import { QuantityInput } from '../../components/forms/QuantityInput';
import { SectionHeader } from '../../components/ui/SectionHeader';
import { formatPrice } from '../../helper/format';
import { sampleBooks } from './sampleBooks';

export function BookDetailPage() {
  const { id } = useParams();
  const book = sampleBooks.find((item) => item.id === Number(id));
  const [tab, setTab] = useState<'description' | 'details'>('description');
  const [quantity, setQuantity] = useState(1);

  if (!book) {
    return (
      <EmptyState
        message="Book not found"
        action={
          <Link to="/" className="text-accent no-underline">
            Home
          </Link>
        }
      />
    );
  }

  const inStock = book.stock_qty > 0;
  const year = book.published_year ?? '—';
  const related = sampleBooks.filter((item) => item.id !== book.id).slice(0, 4);

  return (
    <div className="mx-auto px-[30px] py-10">
      <nav className="mb-6 text-xs uppercase tracking-wider">
        <Link to="/" className="no-underline">
          Home
        </Link>
        <span> → </span>
        <span className="text-accent">{book.title}</span>
      </nav>

      <div className="grid gap-6 lg:grid-cols-2">
        <div className="rounded-2xl border border-neutral-200 bg-white p-[30px]">
          <div className="aspect-3/4 w-full rounded-4 bg-neutral-200" />
        </div>
        <div className="mb-[10px] rounded-2xl border border-neutral-200 bg-white p-[30px]">
          <div className="mb-5 flex gap-4">
            <p
              className={`inline px-[9px] text-xs font-semibold uppercase ${inStock ? 'bg-[rgba(130,209,117,0.2)] text-[#82D175]' : 'bg-[rgba(255,77,79,0.2)] text-[#FF4D4F]'}`}
            >
              {inStock ? 'In stock' : 'Out of stock'}
            </p>
          </div>
          <h1 className="mb-[10px] text-3xl font-semibold text-black">
            {book.title}
          </h1>
          <p className="flex items-center text-[12px]">
            <span className="mr-5 mb-[6px]">
              <span className="pr-5">
                <span className="text-lighter">Author:</span> {book.author}
              </span>
              |
            </span>
            <span className="mb-[6px]">
              <span className="text-lighter">Published:</span> {year}
            </span>
          </p>
          <p className="text-3xl font-semibold text-accent">
            {formatPrice(book.price)}
          </p>
          <p className="text-neutral-500">No description yet.</p>
          <p className="mt-[10px] text-[12px] text-lighter">Quantity</p>
          <QuantityInput
            value={inStock ? quantity : 0}
            min={1}
            max={book.stock_qty}
            disabled={!inStock}
            onChange={setQuantity}
          />
          <Button disabled>Add to cart</Button>
        </div>
      </div>

      <div className="mt-10">
        <div className="flex gap-6 border-b border-neutral-200">
          <button
            type="button"
            className={tab === 'description' ? 'border-b-2 border-accent' : ''}
            onClick={() => setTab('description')}
          >
            Description
          </button>
          <button
            type="button"
            className={tab === 'details' ? 'border-b-2 border-accent' : ''}
            onClick={() => setTab('details')}
          >
            Details
          </button>
        </div>

        {tab === 'description' ? (
          <p className="mt-6 text-neutral-500">No description yet.</p>
        ) : (
          <table className="mt-6 w-full">
            <tbody>
              <tr>
                <th className="text-left">Author</th>
                <td>{book.author}</td>
              </tr>
              <tr>
                <th className="text-left">Published year</th>
                <td>{year}</td>
              </tr>
              <tr>
                <th className="text-left">Stock</th>
                <td>{book.stock_qty}</td>
              </tr>
            </tbody>
          </table>
        )}
      </div>

      <section className="mt-16">
        <SectionHeader title="Related books" />
        <div className="grid grid-cols-2 gap-6 md:grid-cols-4">
          {related.map((item) => (
            <BookCard key={item.id} book={item} />
          ))}
        </div>
      </section>
    </div>
  );
}
