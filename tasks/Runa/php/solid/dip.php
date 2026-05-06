<?php

class MySQLDatabase
{
    public function connect(): void
    {
        echo "Connected to MySQL database." . PHP_EOL;
    }

    public function saveUser(string $name): void
    {
        echo "Saved user " . $name . " to MySQL database." . PHP_EOL;
    }
}

class UserService
{
    private MySQLDatabase $database;

    public function __construct()
    {
        $this->database = new MySQLDatabase();
    }

    public function register(string $name): void
    {
        $this->database->connect();
        $this->database->saveUser($name);
        echo "User registration completed." . PHP_EOL;
    }
}

$service = new UserService();
$service->register("Alice");
