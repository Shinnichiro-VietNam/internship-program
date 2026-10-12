<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

class ResponseData implements Responsable
{
    public function __construct(
        protected int $status,
        protected mixed $data = null,
        protected ?string $message = null,
        protected array $errors = []
    ) {}

    public function toResponse($request): JsonResponse
    {
        $response = [
            'status'  => $this->status,
            'message' => $this->message,
        ];

        if ($this->data !== null) {
            $response['data'] = $this->data;
        }

        if (!empty($this->errors)) {
            $response['errors'] = $this->errors;
        }

        return response()->json($response, $this->status);
    }
}