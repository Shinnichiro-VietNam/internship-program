USE internship_bookstore;

SELECT o.order_id, c.full_name, o.order_date, o.status, SUM(oi.quantity * oi.unit_price) AS order_total
FROM
    orders AS o
    INNER JOIN customers AS c ON o.customer_id = c.customer_id
    INNER JOIN order_items AS oi ON o.order_id = oi.order_id
GROUP BY
    o.order_id,
    c.full_name,
    o.order_date,
    o.status
ORDER BY o.order_date DESC;

SELECT b.title, SUM(oi.quantity) AS total_qty_sold
FROM
    order_items AS oi
    INNER JOIN books AS b ON oi.book_id = b.book_id
    INNER JOIN orders AS o ON oi.order_id = o.order_id
WHERE
    o.status != 'cancelled'
GROUP BY
    b.title
ORDER BY total_qty_sold DESC
LIMIT 1;

SELECT c.customer_id, c.full_name, SUM(oi.quantity * oi.unit_price) AS lifetime_spend
FROM
    customers AS c
    INNER JOIN orders AS o ON c.customer_id = o.customer_id
    INNER JOIN order_items AS oi ON o.order_id = oi.order_id
WHERE
    o.status IN ('paid', 'shipped')
GROUP BY
    c.customer_id,
    c.full_name
ORDER BY lifetime_spend DESC
LIMIT 5;

SELECT LEFT(order_date, 7) AS year_month, COUNT(*) AS order_count
FROM orders
WHERE
    order_date LIKE '2024%'
GROUP BY
    LEFT(order_date, 7)
ORDER BY year_month ASC;