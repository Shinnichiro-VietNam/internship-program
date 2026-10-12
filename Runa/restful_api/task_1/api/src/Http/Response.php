<?php
namespace Http;

class Response {
    public static function json(mixed $data, int $status = 200, array $headers = []): void {
        header("Content-Type: application/json; charset=utf-8");
        foreach ($headers as $name => $value) {
            header("$name: $value");
        }
        http_response_code($status);
        if ($status === 204) {
            exit;
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    public static function error(string $code, string $message = '', int $status = 400): void {
        $body = ["error" => ["code" => $code]];
        if ($message) {
            $body["error"]["message"] = $message;
        }
        self::json($body, $status);
    }
}