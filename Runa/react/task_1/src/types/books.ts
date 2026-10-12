export type Book = {
  id: number;
  title: string;
  author: string;
  price: number;
  stock_qty: number;
  published_year: number | null;
};

export type OrderItem = {
  book_id: number;
  quantity: number;
  unit_price: number;
};

export type BookFilters = {
  author: string;
  min_price: string;
  max_price: string;
};

export type ApiListResponse<T> = {
  status: number;
  message: string;
  data: T[];
};

export type ApiItemResponse<T> = {
  status: number;
  message: string;
  data: T;
};
