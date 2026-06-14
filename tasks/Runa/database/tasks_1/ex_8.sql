USE internship_bookstore;

SELECT title, price
FROM books
WHERE
    price > (
        SELECT AVG(price)
        FROM books
    );

SELECT e1.full_name, e1.salary, e1.dept_id
FROM employees AS e1
WHERE
    e1.salary > (
        SELECT AVG(e2.salary)
        FROM employees AS e2
        WHERE
            e2.dept_id = e1.dept_id
    );

SELECT customer_id, full_name
FROM customers
WHERE
    customer_id IN (
        SELECT customer_id
        FROM orders
        WHERE
            status = 'shipped'
    );

SELECT title, stock_qty
FROM books
WHERE
    stock_qty = (
        SELECT MAX(stock_qty)
        FROM books
    );