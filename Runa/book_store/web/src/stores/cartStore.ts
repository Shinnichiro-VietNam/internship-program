import { create } from 'zustand';
import type { Book } from '../types/book';

export type CartLine = {
  bookId: number;
  title: string;
  author: string;
  price: number;
  stockQty: number;
  quantity: number;
};

type CartState = {
  lines: CartLine[];
  isDrawerOpen: boolean;
  add: (book: Book, quantity: number) => void;
  setQuantity: (bookId: number, quantity: number) => void;
  remove: (bookId: number) => void;
  clear: () => void;
  openDrawer: () => void;
  closeDrawer: () => void;
};

function readCart(): CartLine[] {
  try {
    const raw = localStorage.getItem('cart');
    if (!raw) return [];
    const parsed = JSON.parse(raw);
    return Array.isArray(parsed) ? parsed : [];
  } catch {
    return [];
  }
}

function writeCart(lines: CartLine[]) {
  localStorage.setItem('cart', JSON.stringify(lines));
}

export const useCartStore = create<CartState>((set, get) => ({
  lines: readCart(),
  isDrawerOpen: false,

  add: (book, quantity) => {
    const lines = [...get().lines];
    const index = lines.findIndex((line) => line.bookId === book.id);

    if (index >= 0) {
      const line = lines[index];
      const nextQty = Math.min(line.quantity + quantity, line.stockQty);
      lines[index] = {
        ...line,
        quantity: nextQty,
      };
    } else {
      const stockQty = book.stock_qty;
      if (stockQty <= 0) return;
      lines.push({
        bookId: book.id,
        title: book.title,
        author: book.author,
        price: book.price,
        stockQty,
        quantity: Math.min(quantity, stockQty),
      });
    }
    writeCart(lines);
    set({ lines });
  },
  setQuantity: (bookId, quantity) => {
    const lines = get().lines.map((line) => {
      if (line.bookId !== bookId) return line;
      const next = Math.min(Math.max(quantity, 1), line.stockQty);
      return { ...line, quantity: next };
    });
    writeCart(lines);
    set({ lines });
  },
  remove: (bookId) => {
    const lines = get().lines.filter((line) => line.bookId !== bookId);
    writeCart(lines);
    set({ lines });
  },
  clear: () => {
    writeCart([]);
    set({ lines: [] });
  },

  openDrawer: () => set({ isDrawerOpen: true }),
  closeDrawer: () => set({ isDrawerOpen: false }),
}));

export function lineCount(lines: CartLine[]) {
  return lines.length;
}

export function itemCount(lines: CartLine[]) {
  return lines.reduce((sum, line) => sum + line.quantity, 0);
}

export function subtotal(lines: CartLine[]) {
  return lines.reduce((sum, line) => sum + line.price * line.quantity, 0);
}
