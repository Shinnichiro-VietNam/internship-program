USE internship_bookstore;

SELECT e.full_name, e.email, d.dept_name, d.location
FROM employees AS e
    INNER JOIN departments AS d ON e.dept_id = d.dept_id;

SELECT o.order_id, c.full_name, o.order_date, o.status
FROM orders AS o
    INNER JOIN customers AS c ON o.customer_id = c.customer_id;

SELECT oi.order_id, b.title, oi.quantity, oi.unit_price, (oi.quantity * oi.unit_price) AS line_total
FROM order_items AS oi
    INNER JOIN books AS b ON oi.book_id = b.book_id;

SELECT e.full_name, e.email, d.dept_name
FROM employees AS e
    INNER JOIN departments AS d ON e.dept_id = d.dept_id
WHERE
    d.dept_name = '営業';