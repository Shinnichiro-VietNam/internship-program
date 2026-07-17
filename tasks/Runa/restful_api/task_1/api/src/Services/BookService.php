<?php
namespace Services;

use Repositories\BookRepositoryInterface;

class BookService {
    private BookRepositoryInterface $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository) {
        $this->bookRepository = $bookRepository;
    }

    public function getBooks(array $filters = []): array {
        $books = $this->bookRepository->all();

        if (isset($filters['author'])) {
            $filtered = [];
            foreach ($books as $book) {
                if (str_contains($book['author'], $filters['author'])) {
                    $filtered[] = $book;
                }
            }
            $books = $filtered;
        }

        if (isset($filters['min_price'])) {
            $minPrice = (int)$filters['min_price'];
            $filtered = [];
            foreach ($books as $book) {
                if (isset($book['price']) && $book['price'] >= $minPrice) {
                    $filtered[] = $book;
                }
            }
            $books = $filtered;
        }

        if (isset($filters['max_price'])) {
            $maxPrice = (int)$filters['max_price'];
            $filtered = [];
            foreach ($books as $book) {
                if (isset($book['price']) && $book['price'] <= $maxPrice) {
                    $filtered[] = $book;
                }
            }
            $books = $filtered;
        }

        return $books;
    }

    public function getBookById(int $id): ?array {
        $books = $this->bookRepository->all();
        foreach ($books as $book) {
            if ($book['id'] === $id) {
                return $book;
            }
        }
        return null;
    }

    public function createBook(array $data): array {
        if (empty($data['title']) || empty($data['author'])) {
            return ['error' => 'BAD_REQUEST', 'message' => 'Title and Author are required', 'status' => 400];
        }
        if (isset($data['price']) && $data['price'] <= 0) {
            return ['error' => 'BAD_REQUEST', 'message' => 'Price must be positive', 'status' => 400];
        }
        if (isset($data['stock_qty']) && $data['stock_qty'] < 0) {
            return ['error' => 'BAD_REQUEST', 'message' => 'Stock quantity cannot be negative', 'status' => 400];
        }

        $books = $this->bookRepository->all();
        $maxId = 0;
        foreach ($books as $book) {
            if (isset($book['id']) && $book['id'] > $maxId) {
                $maxId = $book['id'];
            }
        }
        $newId = $maxId + 1;

        $newBook = [
            "id" => $newId,
            "title" => $data['title'],
            "author" => $data['author'],
            "price" => $data['price'] ?? 0,
            "stock_qty" => $data['stock_qty'] ?? 0
        ];

        $books[] = $newBook;
        $this->bookRepository->save($books);

        return ['data' => $newBook, 'status' => 201];
    }

    public function updateBook(int $id, array $data, bool $isPatch = false): array {
        $books = $this->bookRepository->all();
        $foundIndex = -1;

        foreach ($books as $index => $book) {
            if ($book['id'] === $id) {
                $foundIndex = $index;
                break;
            }
        }

        if ($foundIndex === -1) {
            return ['error' => 'NOT_FOUND', 'status' => 404];
        }

        if ($isPatch && empty($data)) {
            return ['error' => 'BAD_REQUEST', 'status' => 400];
        }

        if (!$isPatch) {
            if (empty($data['title']) || empty($data['author'])) {
                return ['error' => 'BAD_REQUEST', 'message' => 'Title and Author are required', 'status' => 400];
            }
        }

        if (isset($data['price']) && $data['price'] <= 0) {
            return ['error' => 'BAD_REQUEST', 'message' => 'Price must be positive', 'status' => 400];
        }
        if (isset($data['stock_qty']) && $data['stock_qty'] < 0) {
            return ['error' => 'BAD_REQUEST', 'message' => 'Stock quantity cannot be negative', 'status' => 400];
        }

        if ($isPatch) {
            if (array_key_exists('title', $data)) $books[$foundIndex]['title'] = $data['title'];
            if (array_key_exists('author', $data)) $books[$foundIndex]['author'] = $data['author'];
            if (array_key_exists('price', $data)) $books[$foundIndex]['price'] = $data['price'];
            if (array_key_exists('stock_qty', $data)) $books[$foundIndex]['stock_qty'] = $data['stock_qty'];
        } else {
            $books[$foundIndex]['title'] = $data['title'];
            $books[$foundIndex]['author'] = $data['author'];
            $books[$foundIndex]['price'] = $data['price'] ?? 0;
            $books[$foundIndex]['stock_qty'] = $data['stock_qty'] ?? 0;
        }

        $this->bookRepository->save($books);
        return ['data' => $books[$foundIndex], 'status' => 200];
    }

    public function deleteBook(int $id): bool {
        $books = $this->bookRepository->all();
        $foundIndex = -1;

        foreach ($books as $index => $book) {
            if ($book['id'] === $id) {
                $foundIndex = $index;
                break;
            }
        }

        if ($foundIndex === -1) {
            return false;
        }

        unset($books[$foundIndex]);
        $books = array_values($books);
        $this->bookRepository->save($books);
        return true;
    }
}