import { useEffect, useState } from "react";
import { Link, useParams } from "react-router-dom";
import axios from "axios";
import { API_URL } from "../lib/config";
import { formatCurrency } from "../lib/format";
import type { ApiItemResponse, ApiListResponse, Book, OrderItem } from "../types/books";

export function BookDetailPage() {
  const { id } = useParams<{ id: string }>();

  const [book, setBook] = useState<Book | null>(null);
  const [orderItems, setOrderItems] = useState<OrderItem[]>([]);
  const [loading, setLoading] = useState(true);
  const [notFound, setNotFound] = useState(false);
  const [error, setError] = useState<string | null>(null);
  const [orderItemsError, setOrderItemsError] = useState<string | null>(null);

  useEffect(() => {
    if (!id) return;

    let cancelled = false;

    async function load() {
      setLoading(true);
      setNotFound(false);
      setError(null);
      setOrderItemsError(null);
      setBook(null);
      setOrderItems([]);

      try {
        const bookRes = await axios.get<ApiItemResponse<Book>>(`${API_URL}/books/${id}`);
        if (cancelled) return;
        setBook(bookRes.data.data);

        try {
          const itemsRes = await axios.get<ApiListResponse<OrderItem>>(
            `${API_URL}/books/${id}/order-items`,
          );
          if (!cancelled) setOrderItems(itemsRes.data.data);
        } catch (e) {
          if (!cancelled) {
            if (axios.isAxiosError(e)) {
              setOrderItemsError(
                e.response?.data?.message || "Failed to load order items",
              );
            } else {
              setOrderItemsError("Failed to load order items");
            }
          }
        }
      } catch (e) {
        if (cancelled) return;
        if (axios.isAxiosError(e) && e.response?.status === 404) {
          setNotFound(true);
        } else if (axios.isAxiosError(e)) {
          setError(e.response?.data?.message || "Failed to load book");
        } else {
          setError(e instanceof Error ? e.message : "Something went wrong");
        }
      } finally {
        if (!cancelled) setLoading(false);
      }
    }

    void load();

    return () => {
      cancelled = true;
    };
  }, [id]);

  if (loading) {
    return <p>Loading…</p>;
  }

  if (notFound) {
    return (
      <div>
        <p className="message">Book not found</p>
        <Link to="/books" className="nav-link">
          Back to list
        </Link>
      </div>
    );
  }

  if (error || !book) {
    return (
      <div>
        <p className="message">{error ?? "Something went wrong"}</p>
        <Link to="/books" className="nav-link">
          Back to list
        </Link>
      </div>
    );
  }

  return (
    <div className="detail">
      <div>
        <Link to="/books" className="nav-link">
          Back to list
        </Link>

        <h2 className="detail-title">{book.title}</h2>

        <div className="detail-list">
          <div className="detail-row">
            <span className="detail-label">ID</span>
            <span>{book.id}</span>
          </div>
          <div className="detail-row">
            <span className="detail-label">Author</span>
            <span>{book.author}</span>
          </div>
          <div className="detail-row">
            <span className="detail-label">Price</span>
            <span>{formatCurrency(book.price)}</span>
          </div>
          <div className="detail-row">
            <span className="detail-label">Stock</span>
            <span>{book.stock_qty}</span>
          </div>
          <div className="detail-row">
            <span className="detail-label">Published year</span>
            <span>{book.published_year ?? "—"}</span>
          </div>
        </div>
      </div>

      <section>
        <h3 className="section-title">Order items</h3>

        {orderItemsError && <p>{orderItemsError}</p>}

        {!orderItemsError && orderItems.length === 0 && (
          <p className="small-text">No orders for this book yet</p>
        )}

        {!orderItemsError && orderItems.length > 0 && (
          <table className="table">
            <thead>
              <tr>
                <th>Quantity</th>
                <th>Unit price</th>
              </tr>
            </thead>
            <tbody>
              {orderItems.map((item, index) => (
                <tr key={`${item.book_id}-${index}`}>
                  <td>{item.quantity}</td>
                  <td>{formatCurrency(item.unit_price)}</td>
                </tr>
              ))}
            </tbody>
          </table>
        )}
      </section>
    </div>
  );
}
