<?php
declare(strict_types=1);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

header('Content-Type: application/json; charset=utf-8');

// --- Ex_5---
if ($path === '/api/health') {
    if ($method === 'GET') {
        http_response_code(200);
        echo json_encode(['status' => 'ok']);
        exit;
    }
    http_response_code(405);
    echo json_encode(['error' => ['code' => 'METHOD_NOT_ALLOWED', 'message' => 'Method not allowed']]);
    exit;
}

// --- Ex_6-1 ---
if ($path === '/api/books') {
    if ($method === 'GET') {
        $jsonRaw = file_get_contents(__DIR__ . '/../data/books.json');
        $books = json_decode($jsonRaw, true);

        if (isset($_GET['author']) && $_GET['author'] === 'ミック') {
            $filteredBooks = [];
            foreach ($books as $book) {
                if ($book['author'] === 'ミック') {
                    $filteredBooks[] = $book;
                }
            }
            http_response_code(200);
            echo json_encode($filteredBooks, JSON_UNESCAPED_UNICODE);
            exit;
        }

        http_response_code(200);
        echo json_encode($books, JSON_UNESCAPED_UNICODE);
        exit;
    }

    http_response_code(405);
    echo json_encode(['error' => ['code' => 'METHOD_NOT_ALLOWED', 'message' => 'Method not allowed']]);
    exit;
}

// --- Ex_6-2 ---
$parts = explode('/', $path);

if (isset($parts[1]) && $parts[1] === 'api' && isset($parts[2]) && $parts[2] === 'books' && isset($parts[3]) && $parts[3] !== '') {
    $bookId = (int)$parts[3];

    if ($method === 'GET') {
        $jsonRaw = file_get_contents(__DIR__ . '/../data/books.json');
        $books = json_decode($jsonRaw, true);

        $foundBook = null;
        foreach ($books as $book) {
            if ($book['id'] === $bookId) {
                $foundBook = $book;
            }
        }

        if ($foundBook !== null) {
            http_response_code(200);
            echo json_encode($foundBook, JSON_UNESCAPED_UNICODE);
            exit;
        } else {
            http_response_code(404);
            echo json_encode(['error' => ['code' => 'NOT_FOUND', 'message' => 'Book not found']]);
            exit;
        }
    }

    http_response_code(405);
    echo json_encode(['error' => ['code' => 'METHOD_NOT_ALLOWED', 'message' => 'Method not allowed']]);
    exit;
}

http_response_code(404);
echo json_encode(['error' => ['code' => 'NOT_FOUND', 'message' => 'Not found']]);
exit;