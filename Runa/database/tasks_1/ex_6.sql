USE internship_bookstore;

SELECT d.dept_name, COUNT(e.emp_id) AS employee_count
FROM departments AS d
    INNER JOIN employees AS e ON d.dept_id = e.dept_id
GROUP BY
    d.dept_name;

SELECT d.dept_name, ROUND(AVG(e.salary), 2) AS average_salary
FROM departments AS d
    INNER JOIN employees AS e ON d.dept_id = e.dept_id
GROUP BY
    d.dept_name;

SELECT oi.order_id, SUM(oi.quantity * oi.unit_price) AS total_revenue
FROM order_items AS oi
    INNER JOIN orders AS o ON oi.order_id = o.order_id
WHERE
    o.status != 'cancelled'
GROUP BY
    oi.order_id;

SELECT b.book_id, b.title, COALESCE(
        SUM(
            CASE
                WHEN o.order_id IS NOT NULL
                AND o.status <> 'cancelled' THEN oi.quantity
            END
        ), 0
    ) AS total_qty_sold
FROM
    books AS b
    LEFT JOIN order_items AS oi ON b.book_id = oi.book_id
    LEFT JOIN orders AS o ON oi.order_id = o.order_id
GROUP BY
    b.book_id,
    b.title;

SELECT c.customer_id, c.full_name, COUNT(o.order_id) AS order_count
FROM customers AS c
    LEFT JOIN orders AS o ON c.customer_id = o.customer_id
GROUP BY
    c.customer_id,
    c.full_name;