USE internship_bookstore;

SELECT d.dept_name, COUNT(e.emp_id) AS active_employee_count
FROM departments AS d
    INNER JOIN employees AS e ON d.dept_id = e.dept_id
WHERE
    e.is_active = 1
GROUP BY
    d.dept_name
HAVING
    COUNT(e.emp_id) > 1;

SELECT c.customer_id, c.full_name, COUNT(o.order_id) AS order_count
FROM customers AS c
    INNER JOIN orders AS o ON c.customer_id = o.customer_id
WHERE
    o.status != 'cancelled'
GROUP BY
    c.customer_id,
    c.full_name
HAVING
    COUNT(o.order_id) > 1;

SELECT b.book_id, b.title, SUM(oi.quantity) AS total_qty_sold
FROM
    books AS b
    INNER JOIN order_items AS oi ON b.book_id = oi.book_id
    INNER JOIN orders AS o ON oi.order_id = o.order_id
WHERE
    o.status != 'cancelled'
GROUP BY
    b.book_id,
    b.title
HAVING
    SUM(oi.quantity) > 1;

SELECT author, ROUND(AVG(price), 2) AS average_price
FROM books
GROUP BY
    author
HAVING
    AVG(price) > 3500;