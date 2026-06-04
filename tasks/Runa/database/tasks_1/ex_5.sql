USE internship_bookstore;

SELECT c.full_name, o.order_id
FROM customers AS c
    LEFT JOIN orders AS o ON c.customer_id = o.customer_id;

SELECT COUNT(*) AS unpaid_customer_count
FROM customers AS c
    LEFT JOIN orders AS o ON c.customer_id = o.customer_id
WHERE
    o.order_id IS NULL;

SELECT b.title, COALESCE(SUM(oi.quantity), 0) AS total_qty_sold
FROM
    books AS b
    LEFT JOIN order_items AS oi ON b.book_id = oi.book_id
    LEFT JOIN orders AS o ON oi.order_id = o.order_id
    AND o.status != 'cancelled'
GROUP BY
    b.title;