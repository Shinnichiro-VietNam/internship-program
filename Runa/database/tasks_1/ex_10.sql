USE internship_bookstore;

EXPLAIN
SELECT *
FROM employees
WHERE
    email = 'jiro.suzuki@example.co.jp';

CREATE INDEX idx_employees_hire_date ON employees (hire_date);

EXPLAIN
SELECT *
FROM employees
WHERE
    hire_date > '2023-01-01'
ORDER BY hire_date;

EXPLAIN
SELECT oi.order_id, c.full_name, c.city
FROM
    order_items AS oi
    INNER JOIN orders AS o ON oi.order_id = o.order_id
    INNER JOIN customers AS c ON o.customer_id = c.customer_id
WHERE
    c.city = '東京';