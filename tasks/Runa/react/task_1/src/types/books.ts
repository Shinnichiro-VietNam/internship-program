export type Book = {
    id: number;
    title: string;
    author: string;
    price: number;
    stock_qty: number;
    published_year: number | null;
};

export type ApiListResponse<T> = {
    status: number;
    message: string;
    data: T[];
};