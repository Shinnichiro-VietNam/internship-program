export type Book = {
  id: number;
  title: string;
  author: string;
  price: number;
  stock_qty: number;
  published_year: number | null;
};

export type BookList = {
  items: Book[];
  current_page: number;
  last_page: number;
  per_page: number;
  total: number;
};
