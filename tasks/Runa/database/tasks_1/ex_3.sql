USE internship_bookstore;

START TRANSACTION;

INSERT INTO
    departments (dept_name, location)
VALUES ('インターンシップ', '東京');

INSERT INTO
    employees (
        full_name,
        email,
        dept_id,
        salary,
        hire_date,
        is_active
    )
VALUES (
        '鈴木 次郎',
        'jiro.suzuki@example.co.jp',
        (
            SELECT dept_id
            FROM departments
            WHERE
                dept_name = 'インターンシップ'
        ),
        300000,
        '2026-06-01',
        1
    );

UPDATE books SET stock_qty = stock_qty + 5 WHERE title = 'リーダブルコード';

DELETE FROM employees WHERE email = 'jiro.suzuki@example.co.jp';

ROLLBACK;

DELETE FROM departments WHERE dept_name = '開発';