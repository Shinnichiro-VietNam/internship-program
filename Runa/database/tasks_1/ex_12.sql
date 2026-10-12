USE internship_bookstore;

DROP TABLE IF EXISTS reviews;

CREATE TABLE reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    book_id INT UNSIGNED NOT NULL,
    customer_id INT UNSIGNED NOT NULL,
    rating INT NOT NULL,
    comment TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    -- 外部キー制約
    FOREIGN KEY (book_id) REFERENCES books (book_id),
    FOREIGN KEY (customer_id) REFERENCES customers (customer_id),
    -- 星は1〜5個の間だけというルール
    CONSTRAINT chk_rating CHECK (rating BETWEEN 1 AND 5)
);

INSERT INTO
    reviews (
        book_id,
        customer_id,
        rating,
        comment
    )
VALUES (1, 1, 5, 'とても読みやすくて勉強になった'),
    (1, 2, 4, '初学者におすすめの一冊。'),
    (2, 1, 3, '内容は良いが、少し難しい。');

SELECT book_id, AVG(rating) AS average_rating
FROM reviews
GROUP BY
    book_id
HAVING
    COUNT(review_id) >= 2;

SELECT b.book_id, b.title
FROM books AS b
    LEFT JOIN reviews AS r ON b.book_id = r.book_id
WHERE
    r.review_id IS NULL;