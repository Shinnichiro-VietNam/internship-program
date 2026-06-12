USE internship_bookstore;

SHOW TABLES;

DESCRIBE books;

DESCRIBE customers;

DESCRIBE departments;

DESCRIBE employees;

DESCRIBE orders;

DESCRIBE order_items;

SELECT * FROM books ORDER BY price DESC;

SELECT full_name, city FROM customers WHERE city = '東京';