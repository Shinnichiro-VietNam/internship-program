import { useEffect, useState } from 'react';
import { Link, useParams } from 'react-router-dom';
import axios from 'axios';
import { BookCard } from '../../components/books/BookCard';
import { BookDetailSkeleton } from '../../components/books/BookDetailSkeleton';
import { Button } from '../../components/ui/Button';
import { EmptyState } from '../../components/ui/EmptyState';
import { ErrorState } from '../../components/ui/ErrorState';
import { QuantityInput } from '../../components/forms/QuantityInput';
import { SectionHeader } from '../../components/ui/SectionHeader';
import { formatPrice } from '../../helper/format';
import { parseApiError } from '../../helper/errors';
import { Book as BookModel } from '../../models/Book';
import type { ApiSuccess } from '../../types/api';
import type { Book, BookListData } from '../../types/book';
import { Breadcrumb } from '../../components/ui/Breadcrumb';
import { StockBadge } from '../../components/ui/StockBadge';
import { CartIcon } from '../../components/icons/CartIcon';
import { HeartIcon } from '../../components/icons/HeartIcon';
import { FooterFacebookIcon } from '../../components/icons/FooterFacebookIcon';
import { TwitterIcon } from '../../components/icons/TwitterIcon';
import { PinterestIcon } from '../../components/icons/PinterestIcon';
import { LinkedinIcon } from '../../components/icons/LinkedinIcon';
import { useCartStore } from '../../stores/cartStore';

export function BookDetailPage() {
  const { id } = useParams();
  const [book, setBook] = useState<Book | null>(null);
  const [status, setStatus] = useState<
    'loading' | 'error' | 'notfound' | 'ready'
  >('loading');
  const [errorMessage, setErrorMessage] = useState('');
  const [retryCount, setRetryCount] = useState(0);
  const [tab, setTab] = useState<'description' | 'details'>('description');
  const [quantity, setQuantity] = useState(1);
  const [related, setRelated] = useState<Book[]>([]);
  const add = useCartStore((s) => s.add);
  const openDrawer = useCartStore((s) => s.openDrawer);
  const lines = useCartStore((s) => s.lines);

  useEffect(() => {
    if (!id) return;

    const load = async () => {
      setStatus('loading');
      try {
        const response = await BookModel.show<ApiSuccess<Book>>(id);
        const fetched = response.data;
        setBook(fetched);
        setStatus('ready');
        window.scrollTo({ top: 0 });

        try {
          const list = await BookModel.index<ApiSuccess<BookListData>>({
            author: fetched.author,
            per_page: 5,
          });
          setRelated(
            list.data.items
              .filter((item) => item.id !== fetched.id)
              .slice(0, 4),
          );
        } catch {
          setRelated([]);
        }
      } catch (error) {
        if (axios.isAxiosError(error) && error.response?.status === 404) {
          setStatus('notfound');
          return;
        }
        setErrorMessage(parseApiError(error).message);
        setStatus('error');
      }
    };

    load();
  }, [id, retryCount]);

  if (status === 'loading') {
    return <BookDetailSkeleton />;
  }

  if (status === 'notfound') {
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

  if (status === 'error') {
    return (
      <ErrorState
        message={errorMessage}
        onRetry={() => setRetryCount((c) => c + 1)}
      />
    );
  }

  if (!book) return null;

  const inStock = book.stock_qty > 0;
  const year = book.published_year ?? '—';
  const inCart = lines.find((line) => line.bookId === book.id);
  const inCartQty = inCart?.quantity ?? 0;
  const remaining = book.stock_qty - inCartQty;
  const atMax = inStock && remaining <= 0;
  const canAdd = inStock && !atMax;

  return (
    <div className="mx-auto px-7.5 py-10">
      <Breadcrumb items={[{ label: 'Home', to: '/' }, { label: book.title }]} />
      <div className="grid gap-6 lg:grid-cols-2">
        <div className="rounded-2xl border border-neutral-200 bg-white p-7.5">
          <div className="aspect-3/4 w-full rounded-4 bg-neutral-200" />
        </div>
        <div className="mb-2.5 rounded-2xl border border-neutral-200 bg-white p-7.5">
          <div className="mb-5 flex items-center justify-between">
            <StockBadge stockQty={book.stock_qty} />
            <div className="flex items-center gap-4 text-xs tracking-wider text-lighter uppercase">
              <a
                href="#prev"
                className="inline-flex items-center gap-1 no-underline hover:text-ink"
                onClick={(e) => e.preventDefault()}
              >
                <span aria-hidden>←</span>
                Prev
              </a>
              <a
                href="#next"
                className="inline-flex items-center gap-1 no-underline hover:text-ink"
                onClick={(e) => e.preventDefault()}
              >
                Next
                <span aria-hidden>→</span>
              </a>
            </div>
          </div>
          <h1 className="mb-2.5 text-3xl font-semibold text-black">
            {book.title}
          </h1>
          <div className="mb-5.75">
            <p className="flex items-center text-[12px] pb-2.5">
              <span className="mr-5 mb-1.5">
                <span className="pr-5">
                  <span className="text-lighter">Author: </span>
                  <span className="text-ink transition-colors hover:text-primary">
                    {book.author}
                  </span>
                </span>
                |
              </span>
              <span className="mb-1.5">
                <span className="text-lighter">Published:</span> {year}
              </span>
            </p>
            <hr className="border-neutral-200" />
          </div>
          <p className="text-3xl font-semibold text-accent mb-3.75">
            {formatPrice(book.price)}
          </p>
          <p className="text-neutral-500 mb-5">No description yet.</p>
          <hr className="border-neutral-200" />
          <div className="mb-6.25">
            <div className="py-6.25">
              <div className="flex items-center  flex-wrap ">
                <div className="flex flex-col">
                  <p className="-mt-2.5 text-[12px] text-lighter mb-1.25 block">
                    Quantity
                  </p>
                  <div className="mr-2.5 mb-2.5">
                    <QuantityInput
                      value={inStock ? quantity : 0}
                      min={1}
                      max={book.stock_qty}
                      disabled={!inStock}
                      onChange={setQuantity}
                    />
                  </div>
                </div>
                <div className="flex flex-col items-start">
                  <Button
                    size="lg"
                    disabled={!canAdd}
                    onClick={() => {
                      add(book, quantity);
                      openDrawer();
                    }}
                  >
                    <span className="mr-2">
                      <CartIcon />
                    </span>
                    Add to cart
                  </Button>
                  {atMax ? (
                    <p className="mt-2 text-sm text-neutral-500">
                      Maximum in cart
                    </p>
                  ) : null}
                </div>
              </div>
              <button type="button" className="wishlist-button">
                <div className="flex mt-3 items-center">
                  <span className="mr-2 heart-icon">
                    <HeartIcon />
                  </span>
                  <span className="text-lighter transition-colors hover:text-ink wishlist-text">
                    Add to wishlist
                  </span>
                </div>
              </button>
            </div>
            <hr className="border-neutral-200" />
          </div>
          <div className="leading-[1.8461538462] text-lighter">
            <p>
              SKU: <span className="text-ink">15836496</span>
            </p>
            <p>
              Category:{' '}
              <span className="product-detail">Action & Adventure</span>,{' '}
              <span className="product-detail">Activity Books</span>,{' '}
              <span className="product-detail">Arts & Literature</span>,{' '}
              <span className="product-detail">Cultural</span>
            </p>
            <p>
              Tags: <span className="product-detail">Books</span>,{' '}
              <span className="product-detail">Fiction</span>,{' '}
              <span className="product-detail">Romance-Contemporary</span>
            </p>
          </div>
          <div className="share-social">
            <a
              href="#facebook"
              aria-label="Facebook"
              className="share-facebook"
              onClick={(e) => e.preventDefault()}
            >
              <FooterFacebookIcon />
            </a>
            <a
              href="#twitter"
              aria-label="Twitter"
              className="share-twitter"
              onClick={(e) => e.preventDefault()}
            >
              <TwitterIcon />
            </a>
            <a
              href="#linkedin"
              aria-label="Linkedin"
              className="share-linkedin"
              onClick={(e) => e.preventDefault()}
            >
              <LinkedinIcon />
            </a>
            <a
              href="#pinterest"
              aria-label="Pinterest"
              className="share-pinterest"
              onClick={(e) => e.preventDefault()}
            >
              <PinterestIcon />
            </a>
          </div>
        </div>
      </div>

      <div className="mt-10">
        <div className="flex gap-6 justify-center items-center text-[20px] font-semibold text-lighter">
          <button
            type="button"
            className={`
              tab-underline hover:text-ink px-7.5 pb-2.5
              ${tab === 'description' ? 'active text-ink' : ''}
            `}
            onClick={() => setTab('description')}
          >
            Description
          </button>
          <button
            type="button"
            className={`
              tab-underline hover:text-ink px-7.5 pb-2.5
              ${tab === 'details' ? 'active text-ink' : ''}
            `}
            onClick={() => setTab('details')}
          >
            Details
          </button>
        </div>
        <div className="border border-neutral-200 p-4 rounded-2xl py-8.75 px-7.5">
          {tab === 'description' ? (
            <p className="mt-6 text-neutral-500">No description yet.</p>
          ) : (
            <table className="border border-neutral-200 max-w-212.5 mx-auto w-full">
              <tbody>
                <tr className="border-b border-neutral-200 text-[14px]">
                  <th className="text-left border-r border-neutral-200">
                    Author
                  </th>
                  <td className="text-lighter">{book.author}</td>
                </tr>
                <tr className="border-b border-neutral-200 text-[14px]">
                  <th className="text-left border-r border-neutral-200">
                    Published year
                  </th>
                  <td className="text-lighter">{year}</td>
                </tr>
                <tr className="border-b border-neutral-200 text-[14px]">
                  <th className="text-left border-r border-neutral-200">
                    Stock
                  </th>
                  <td className="text-lighter">{book.stock_qty}</td>
                </tr>
              </tbody>
            </table>
          )}
        </div>
      </div>
      {related.length > 0 && (
        <section className="mt-15">
          <SectionHeader
            title="Related books"
            size="sm"
            marginBottom="mb-7.5"
          />
          <div className="grid grid-cols-2 gap-6 md:grid-cols-4">
            {related.map((item, index) => (
              <div
                key={item.id}
                className={index !== 0 ? 'border-l border-gray-200 pl-6' : ''}
              >
                <BookCard book={item} />
              </div>
            ))}
          </div>
        </section>
      )}
    </div>
  );
}
