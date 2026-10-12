import { createBrowserRouter, Navigate } from "react-router-dom";
import { AppLayout } from "../components/layout/AppLayout";
import { BookDetailPage } from "../pages/BookDetailPage";
import { BooksPage } from "../pages/BooksPage";

export const router = createBrowserRouter([
  {
    path: "/",
    element: <AppLayout />,
    children: [
      { index: true, element: <Navigate to="/books" replace /> },
      { path: "books", element: <BooksPage /> },
      { path: "books/:id", element: <BookDetailPage /> },
    ],
  },
]);
