<?php
namespace Controllers;

use Http\Response;

class BookController {
    private $bookService;

    public function __construct($bookService) {
        $this->bookService = $bookService;
    }

    public function index(): void {
        $books = $this->bookService->getBooks($_GET);
        Response::json($books);
    }

    public function show($id): void {
        $book = $this->bookService->getBookById($id);
        if (!$book) {
            Response::error('NOT_FOUND', '見つかりません', 404);
        }
        Response::json($book);
    }

    public function store(): void {
        $data = json_decode(file_get_contents('php://input'), true) ?? [];
        $result = $this->bookService->createBook($data);

        if (isset($result['error'])) {
            Response::error($result['error'], $result['message'], $result['status']);
        }

        Response::json($result['data'], 201);
    }

    public function update($id, $isPatch): void {
        $data = json_decode(file_get_contents('php://input'), true) ?? [];
        $result = $this->bookService->updateBook($id, $data, $isPatch);

        if (isset($result['error'])) {
            Response::error($result['error'], $result['message'] ?? '', $result['status']);
        }

        Response::json($result['data'], 200);
    }

    public function destroy($id): void {
        $success = $this->bookService->deleteBook($id);
        if (!$success) {
            Response::error('NOT_FOUND', '見つかりません', 404);
        }
        Response::json(null, 204);
    }
}