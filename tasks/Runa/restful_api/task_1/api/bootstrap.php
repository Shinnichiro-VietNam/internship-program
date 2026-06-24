<?php
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/src/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

$jsonPath = __DIR__ . '/../data/books.json';

$repository = new \Repositories\JsonBookRepository($jsonPath);
$service    = new \Services\BookService($repository);

$healthController = new \Controllers\HealthController();
$bookController   = new \Controllers\BookController($service);

$router = new \Http\Router();