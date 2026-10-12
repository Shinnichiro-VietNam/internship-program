import { useState } from "react";
import type { FormEvent } from "react";
import type { BookFilters as BookFiltersType } from "../../types/books";
import { Button } from "../ui/button";

type BookFiltersProps = {
  initialFilters: BookFiltersType;
  onApply: (filters: BookFiltersType) => void;
  onClear: () => void;
};

const emptyFilters: BookFiltersType = {
  author: "",
  min_price: "",
  max_price: "",
};

export function BookFilters({ initialFilters, onApply, onClear }: BookFiltersProps) {
  const [draft, setDraft] = useState<BookFiltersType>(initialFilters);



  function handleSubmit(event: FormEvent) {
    event.preventDefault();
    onApply(draft);
  }

  function handleClear() {
    setDraft(emptyFilters);
    onClear();
  }

  return (
    <form onSubmit={handleSubmit} className="filters">
      <label className="field">
        <span className="field-label">Author</span>
        <input
          type="text"
          value={draft.author}
          onChange={(e) => setDraft((prev) => ({ ...prev, author: e.target.value }))}
          className="input"
          placeholder="e.g. Martin"
        />
      </label>

      <label className="field">
        <span className="field-label">Min price</span>
        <input
          type="number"
          min={0}
          value={draft.min_price}
          onChange={(e) => setDraft((prev) => ({ ...prev, min_price: e.target.value }))}
          className="input"
          placeholder="0"
        />
      </label>

      <label className="field">
        <span className="field-label">Max price</span>
        <input
          type="number"
          min={0}
          value={draft.max_price}
          onChange={(e) => setDraft((prev) => ({ ...prev, max_price: e.target.value }))}
          className="input"
          placeholder="10000"
        />
      </label>

      <div className="button-row">
        <Button type="submit">Apply</Button>
        <Button type="button" variant="outline" onClick={handleClear}>
          Clear
        </Button>
      </div>
    </form>
  );
}
