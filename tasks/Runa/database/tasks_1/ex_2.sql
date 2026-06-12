USE internship_bookstore;

SELECT title, published_year, stock_qty
FROM books
WHERE
    published_year > 2015
    AND stock_qty >= 10
ORDER BY title ASC;

SELECT full_name, salary, is_active
FROM employees
WHERE
    salary BETWEEN 400000 AND 600000
    AND is_active = 1;

SELECT order_id, order_date, status
FROM orders
WHERE
    order_date BETWEEN '2024-01-01' AND '2024-12-31'
    AND status != 'cancelled';

SELECT full_name, email, created_at
FROM customers
WHERE
    email IS NULL
ORDER BY created_at DESC;

SELECT title, price FROM books ORDER BY price DESC LIMIT 3;