USE internship_bookstore;

CREATE OR REPLACE VIEW v_order_summary AS
SELECT
    order_id,
    full_name,
    order_date,
    status
FROM orders
    INNER JOIN customers ON orders.customer_id = customers.customer_id;

SELECT * FROM v_order_summary ORDER BY order_date DESC;

SELECT city, SUM(quantity * unit_price) AS total_spend
FROM
    customers
    INNER JOIN orders ON customers.customer_id = orders.customer_id
    INNER JOIN order_items ON orders.order_id = order_items.order_id
WHERE
    status IN ('paid', 'shipped')
GROUP BY
    city
ORDER BY total_spend DESC;