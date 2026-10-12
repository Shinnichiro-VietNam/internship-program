USE internship_bookstore;

START TRANSACTION;

INSERT INTO
    orders (
        order_id,
        customer_id,
        order_date,
        status
    )
VALUES (
        99,
        1,
        '2026-06-04',
        'pending'
    );

INSERT INTO
    order_items (
        order_id,
        book_id,
        quantity,
        unit_price
    )
VALUES (99, 1, 1, 3000),
    (99, 2, 1, 2500);

UPDATE books SET stock_qty = stock_qty - 1 WHERE book_id = 1;

UPDATE books SET stock_qty = stock_qty - 1 WHERE book_id = 2;

COMMIT;

START TRANSACTION;

INSERT INTO
    orders (
        order_id,
        customer_id,
        order_date,
        status
    )
VALUES (
        100,
        1,
        '2026-06-04',
        'pending'
    );

INSERT INTO
    order_items (
        order_id,
        book_id,
        quantity,
        unit_price
    )
VALUES (100, 999, 1, 5000);

ROLLBACK;