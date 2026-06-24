<?php
namespace Http;

class Router {
    private string $method;
    private string $path;

    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    public function dispatch($healthController, $bookController): void {

        if ($this->path === '/api/health') {
            if ($this->method === 'GET') {
                $healthController->check();
            } else {
                $this->methodNotAllowed(['GET']);
            }
        }

        if ($this->path === '/api/books') {
            if ($this->method === 'GET') {
                $bookController->index();
            } elseif ($this->method === 'POST') {
                $bookController->store();
            } else {
                $this->methodNotAllowed(['GET', 'POST']);
            }
        }

        if (str_starts_with($this->path, '/api/books/')) {
            $id = (int)substr($this->path, 11);
            if ($id <= 0) {
                Response::error('NOT_FOUND', 'Invalid ID', 404);
            }

            if ($this->method === 'GET') {
                $bookController->show($id);
            } elseif ($this->method === 'PUT') {
                $bookController->update($id, false);
            } elseif ($this->method === 'PATCH') {
                $bookController->update($id, true);
            } elseif ($this->method === 'DELETE') {
                $bookController->destroy($id);
            } else {
                $this->methodNotAllowed(['GET', 'PUT', 'PATCH', 'DELETE']);
            }
        }

        Response::error('NOT_FOUND', 'URL not found', 404);
    }

    private function methodNotAllowed(array $allowedMethods): void {
        header('Allow: ' . implode(', ', $allowedMethods));
        Response::error('METHOD_NOT_ALLOWED', 'Method not allowed', 405);
    }
}