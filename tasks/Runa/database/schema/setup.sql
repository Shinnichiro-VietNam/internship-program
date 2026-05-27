-- Internship Bookstore — schema (MySQL 8 / MariaDB 10.4+)
-- Practice database for the Database & SQL module (Shinnichiro internship)
--
-- Run from repo root:
--   mysql -u root -p < tasks/Runa/database/schema/setup.sql
--   mysql -u root -p < tasks/Runa/database/schema/seed.sql

DROP DATABASE IF EXISTS internship_bookstore;

CREATE DATABASE internship_bookstore
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE internship_bookstore;

-- ---------------------------------------------------------------------------
-- departments — store organizational units and office location (city)
-- ---------------------------------------------------------------------------
CREATE TABLE departments (
  dept_id     INT UNSIGNED NOT NULL AUTO_INCREMENT,
  dept_name   VARCHAR(80)  NOT NULL,
  location    VARCHAR(120) NOT NULL DEFAULT '東京',
  created_at  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (dept_id),
  UNIQUE KEY uq_departments_name (dept_name)
) ENGINE=InnoDB
  COMMENT = 'Company departments';

-- ---------------------------------------------------------------------------
-- employees — staff; salary is monthly amount in JPY
-- ---------------------------------------------------------------------------
CREATE TABLE employees (
  emp_id      INT UNSIGNED NOT NULL AUTO_INCREMENT,
  full_name   VARCHAR(120) NOT NULL,
  email       VARCHAR(160) NOT NULL,
  dept_id     INT UNSIGNED NOT NULL,
  salary      DECIMAL(12, 2) NOT NULL COMMENT 'Monthly salary in JPY',
  hire_date   DATE         NOT NULL,
  is_active   TINYINT(1)   NOT NULL DEFAULT 1,
  PRIMARY KEY (emp_id),
  UNIQUE KEY uq_employees_email (email),
  KEY idx_employees_dept (dept_id),
  CONSTRAINT fk_employees_department
    FOREIGN KEY (dept_id) REFERENCES departments (dept_id)
    ON UPDATE CASCADE
    ON DELETE RESTRICT,
  CONSTRAINT chk_employees_salary_positive CHECK (salary > 0)
) ENGINE=InnoDB
  COMMENT = 'Employees';

-- ---------------------------------------------------------------------------
-- customers — bookstore customers (city = prefecture-level city in Japan)
-- ---------------------------------------------------------------------------
CREATE TABLE customers (
  customer_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  full_name   VARCHAR(120) NOT NULL,
  email       VARCHAR(160) NULL,
  city        VARCHAR(80)  NOT NULL DEFAULT '東京',
  created_at  DATE         NOT NULL,
  PRIMARY KEY (customer_id),
  UNIQUE KEY uq_customers_email (email),
  KEY idx_customers_city (city)
) ENGINE=InnoDB
  COMMENT = 'Customers';

-- ---------------------------------------------------------------------------
-- books — catalog; price in JPY
-- ---------------------------------------------------------------------------
CREATE TABLE books (
  book_id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  title           VARCHAR(200) NOT NULL,
  author          VARCHAR(120) NOT NULL,
  price           DECIMAL(10, 2) NOT NULL COMMENT 'Price in JPY',
  stock_qty       INT UNSIGNED NOT NULL DEFAULT 0,
  published_year  SMALLINT UNSIGNED NULL,
  PRIMARY KEY (book_id),
  KEY idx_books_author (author),
  KEY idx_books_title (title),
  KEY idx_books_published_year (published_year),
  CONSTRAINT chk_books_price_positive CHECK (price > 0),
  CONSTRAINT chk_books_stock_non_negative CHECK (stock_qty >= 0)
) ENGINE=InnoDB
  COMMENT = 'Book catalog';

-- ---------------------------------------------------------------------------
-- orders — one row per customer order
-- ---------------------------------------------------------------------------
CREATE TABLE orders (
  order_id    INT UNSIGNED NOT NULL AUTO_INCREMENT,
  customer_id INT UNSIGNED NOT NULL,
  order_date  DATE         NOT NULL,
  status      ENUM('pending', 'paid', 'shipped', 'cancelled') NOT NULL DEFAULT 'pending',
  PRIMARY KEY (order_id),
  KEY idx_orders_customer (customer_id),
  KEY idx_orders_date (order_date),
  KEY idx_orders_status (status),
  CONSTRAINT fk_orders_customer
    FOREIGN KEY (customer_id) REFERENCES customers (customer_id)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
) ENGINE=InnoDB
  COMMENT = 'Customer orders';

-- ---------------------------------------------------------------------------
-- order_items — line items; unit_price is price at time of order (JPY)
-- Composite PK: one row per (order, book)
-- ---------------------------------------------------------------------------
CREATE TABLE order_items (
  order_id    INT UNSIGNED NOT NULL,
  book_id     INT UNSIGNED NOT NULL,
  quantity    INT UNSIGNED NOT NULL,
  unit_price  DECIMAL(10, 2) NOT NULL,
  PRIMARY KEY (order_id, book_id),
  KEY idx_order_items_book (book_id),
  CONSTRAINT fk_order_items_order
    FOREIGN KEY (order_id) REFERENCES orders (order_id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk_order_items_book
    FOREIGN KEY (book_id) REFERENCES books (book_id)
    ON UPDATE CASCADE
    ON DELETE RESTRICT,
  CONSTRAINT chk_order_items_quantity CHECK (quantity > 0),
  CONSTRAINT chk_order_items_unit_price CHECK (unit_price > 0)
) ENGINE=InnoDB
  COMMENT = 'Order line items';
