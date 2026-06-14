<?php
header("Content-Type: application/json; charset=utf-8");

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$jsonPath = __DIR__ . '/../data/books.json';

if ($uri === '/api/health') {
    if ($method !== 'GET') {
        http_response_code(405);
        echo json_encode(["error" => ["code" => "METHOD_NOT_ALLOWED"]]);
        exit;
    }
    http_response_code(200);
    echo json_encode(["status" => "ok"]);
    exit;
}

if ($uri === '/api/books' || str_starts_with($uri, '/api/books?')) {

    if ($method === 'GET') {
        $books = json_decode(file_get_contents($jsonPath), true);
        if (isset($_GET['author'])) {
            $filtered = [];
            foreach ($books as $book) {
                if (str_contains($book['author'], $_GET['author'])) {
                    $filtered[] = $book;
                }
            }
            $books = $filtered;
        }

        if (isset($_GET['min_price'])) {
            $minPrice = (int)$_GET['min_price'];
            $filtered = [];
            foreach ($books as $book) {
                if (isset($book['price']) && $book['price'] >= $minPrice) {
                    $filtered[] = $book;
                }
            }
            $books = $filtered;
        }

        if (isset($_GET['max_price'])) {
            $maxPrice = (int)$_GET['max_price'];
            $filtered = [];
            foreach ($books as $book) {
                if (isset($book['price']) && $book['price'] <= $maxPrice) {
                    $filtered[] = $book;
                }
            }
            $books = $filtered;
        }

        http_response_code(200);
        echo json_encode($books, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    if ($method === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['title']) || empty($data['author'])) {
            http_response_code(400);
            echo json_encode(["error" => ["code" => "BAD_REQUEST", "message" => "Title and Author are required"]]);
            exit;
        }
        if (isset($data['price']) && $data['price'] <= 0) {
            http_response_code(400);
            echo json_encode(["error" => ["code" => "BAD_REQUEST", "message" => "Price must be positive"]]);
            exit;
        }
        if (isset($data['stock_qty']) && $data['stock_qty'] < 0) {
            http_response_code(400);
            echo json_encode(["error" => ["code" => "BAD_REQUEST", "message" => "Stock quantity cannot be negative"]]);
            exit;
        }

        $books = json_decode(file_get_contents($jsonPath), true);
        $newId = count($books) + 1;

        $newBook = [
            "id" => $newId,
            "title" => $data['title'],
            "author" => $data['author'],
            "price" => $data['price'] ?? 0,
            "stock_qty" => $data['stock_qty'] ?? 0
        ];

        $books[] = $newBook;
        file_put_contents($jsonPath, json_encode($books, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        header("Location: /api/books/" . $newId);
        http_response_code(201);
        echo json_encode($newBook, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }
}

if (str_starts_with($uri, '/api/books/')) {
    $id = (int)substr($uri, 11);

    if ($id > 0) {
        $books = json_decode(file_get_contents($jsonPath), true);

        $foundIndex = -1;
        foreach ($books as $index => $book) {
            if ($book['id'] === $id) {
                $foundIndex = $index;
                break;
            }
        }

        if ($foundIndex === -1) {
            http_response_code(404);
            echo json_encode(["error" => ["code" => "NOT_FOUND"]]);
            exit;
        }

        if ($method === 'GET') {
            http_response_code(200);
            echo json_encode($books[$foundIndex], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            exit;
        }

        if ($method === 'PUT') {
            $data = json_decode(file_get_contents('php://input'), true);

            if (empty($data['title']) || empty($data['author'])) {
                http_response_code(400);
                echo json_encode(["error" => ["code" => "BAD_REQUEST"]]);
                exit;
            }

            $books[$foundIndex]['title'] = $data['title'];
            $books[$foundIndex]['author'] = $data['author'];
            $books[$foundIndex]['price'] = $data['price'] ?? 0;
            $books[$foundIndex]['stock_qty'] = $data['stock_qty'] ?? 0;

            file_put_contents($jsonPath, json_encode($books, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            http_response_code(200);
            echo json_encode($books[$foundIndex], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            exit;
        }

        if ($method === 'PATCH') {
            $data = json_decode(file_get_contents('php://input'), true);

            if (empty($data)) {
                http_response_code(400);
                echo json_encode(["error" => ["code" => "BAD_REQUEST"]]);
                exit;
            }

            if (array_key_exists('title', $data)) $books[$foundIndex]['title'] = $data['title'];
            if (array_key_exists('author', $data)) $books[$foundIndex]['author'] = $data['author'];
            if (array_key_exists('price', $data)) $books[$foundIndex]['price'] = $data['price'];
            if (array_key_exists('stock_qty', $data)) $books[$foundIndex]['stock_qty'] = $data['stock_qty'];

            file_put_contents($jsonPath, json_encode($books, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            http_response_code(200);
            echo json_encode($books[$foundIndex], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            exit;
        }

        if ($method === 'DELETE') {
            unset($books[$foundIndex]);
            $books = array_values($books);

            file_put_contents($jsonPath, json_encode($books, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

            http_response_code(204);
            exit;
        }
    }
}

http_response_code(404);
echo json_encode(["error" => ["code" => "NOT_FOUND"]]);