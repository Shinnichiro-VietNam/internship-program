import { createBrowserRouter, Navigate, Outlet } from "react-router-dom";
import { AppLayout } from "../components/layout/AppLayout";
import { BookDetailPage } from "../pages/BookDetailPage";
import { BooksPage } from "../pages/BooksPage";

function RootLayout() {
  return (
    <AppLayout>
      <Outlet />
    </AppLayout>
  );
}

export const router = createBrowserRouter([
  {
    path: "/",
    element: <RootLayout />,
    children: [
      { index: true, element: <Navigate to="/books" replace /> },
      { path: "books", element: <BooksPage /> },
      { path: "books/:id", element: <BookDetailPage /> },
    ],
  },
]);
