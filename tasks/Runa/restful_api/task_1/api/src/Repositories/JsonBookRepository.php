<?php
namespace Repositories;

class JsonBookRepository implements BookRepositoryInterface {
    private string $jsonPath;

    public function __construct(string $jsonPath) {
        $this->jsonPath = $jsonPath;
    }

    public function all(): array {
        if (!file_exists($this->jsonPath)) {
            return [];
        }
        $jsonData = file_get_contents($this->jsonPath);
        return json_decode($jsonData, true) ?? [];
    }

    public function save(array $books): bool {
        $jsonData = json_encode($books, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        return file_put_contents($this->jsonPath, $jsonData) !== false;
    }
}