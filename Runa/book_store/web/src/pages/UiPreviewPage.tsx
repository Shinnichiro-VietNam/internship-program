import { useEffect, useState } from 'react';
import { Button } from '../components/ui/Button';
import { Input } from '../components/forms/Input';
import { Select } from '../components/forms/Select';
import { DateInput } from '../components/forms/DateInput';
import api from '../plugins/axios';
import { parseApiError } from '../helper/errors';
import { BookGrid } from '../components/books/BookGrid';
import { sampleBooks } from './books/sampleBooks';
import { Pagination } from '../components/ui/Pagination';
import { QuantityInput } from '../components/forms/QuantityInput';
import { BookDetailSkeleton } from '../components/books/BookDetailSkeleton';
import { Breadcrumb } from '../components/ui/Breadcrumb';
import { StockBadge } from '../components/ui/StockBadge';

export function UiPreviewPage() {
  const [text, setText] = useState<string>('');
  const [selectValue, setSelectValue] = useState<string>('a');
  const [date, setDate] = useState<string>('');
  const [health, setHealth] = useState<string>('Loading...');
  const [page, setPage] = useState(1);
  const perPage = 4;
  const lastPage = Math.ceil(sampleBooks.length / perPage);
  const visibleBooks = sampleBooks.slice((page - 1) * perPage, page * perPage);
  const [qty, setQty] = useState(1);

  useEffect(() => {
    api
      .get('/health')
      .then((res) => {
        setHealth(res.data.status ?? 'OK');
      })
      .catch((err) => {
        setHealth(parseApiError(err).message);
      });
  }, []);

  return (
    <>
      <div className="max-w-md space-y-6 p-8">
        <h1 className="text-2xl font-bold">UI Check</h1>

        <div className="flex gap-2">
          <Button variant="primary">Primary</Button>
          <Button variant="secondary">Secondary</Button>
          <Button variant="primary" disabled>
            Disabled
          </Button>
        </div>

        <Input
          label="Name"
          name="name"
          value={text}
          onChange={(e) => setText(e.target.value)}
          error="This field is required."
        />

        <Select
          label="Choice"
          value={selectValue}
          onChange={(e) => setSelectValue(e.target.value)}
          options={[
            { value: 'a', label: 'Option A' },
            { value: 'b', label: 'Option B' },
          ]}
        />

        <DateInput
          label="Date"
          name="date"
          value={date}
          onChange={(e) => setDate(e.target.value)}
        />

        <p>Health: {health}</p>
      </div>

      <section className="mx-auto max-w-6xl space-y-10 p-8">
        <h2 className="text-2xl font-bold">Grid states</h2>

        <div>
          <h3 className="mb-4 font-semibold">Loading</h3>
          <BookGrid
            books={sampleBooks}
            status="loading"
            errorMessage=""
            onRetry={() => {}}
          />
        </div>

        <div>
          <h3 className="mb-4 font-semibold">Empty</h3>
          <BookGrid
            books={[]}
            status="empty"
            errorMessage=""
            onRetry={() => {}}
          />
        </div>

        <div>
          <h3 className="mb-4 font-semibold">Error</h3>
          <BookGrid
            books={[]}
            status="error"
            errorMessage="Could not load books."
            onRetry={() => {}}
          />
        </div>

        <div>
          <h3 className="mb-4 font-semibold">Ready</h3>
          <BookGrid
            books={visibleBooks}
            status="ready"
            errorMessage=""
            onRetry={() => {}}
          />
          <Pagination
            currentPage={page}
            lastPage={lastPage}
            onChange={setPage}
          />
        </div>
      </section>

      <section className="mx-auto max-w-6xl space-y-4 p-8">
        <h2 className="text-2xl font-bold">Quantity control</h2>
        <QuantityInput value={qty} min={1} max={3} onChange={setQty} />
      </section>

      <section className="mx-auto max-w-6xl space-y-4 p-8">
        <h2 className="text-2xl font-bold">Book detail</h2>
        <BookDetailSkeleton />
      </section>

      <section className="mx-auto max-w-6xl space-y-6 p-8">
        <h2 className="text-2xl font-bold">Book detail pieces</h2>
        <Breadcrumb
          items={[
            { label: 'Home', to: '/' },
            { label: 'Books', to: '/' },
            { label: 'Sample title' },
          ]}
        />
        <div className="flex gap-3">
          <StockBadge stockQty={5} />
          <StockBadge stockQty={0} />
        </div>
        <BookDetailSkeleton />
      </section>
    </>
  );
}
