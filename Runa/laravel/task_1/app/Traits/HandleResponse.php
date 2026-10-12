<?php

namespace App\Traits;

use App\Http\Responses\ResponseData;
use Symfony\Component\HttpFoundation\Response;

trait HandleResponse
{
    public function httpOk(mixed $data = null, string $msg = 'OK'): ResponseData
    {
        return new ResponseData(Response::HTTP_OK, $data, $msg);
    }

    public function httpCreated(mixed $data = null, ?string $msg = null): ResponseData
    {
        if (! $msg) {
            $msg = trans('message.create_success');
        }

        return new ResponseData(Response::HTTP_CREATED, $data, $msg);
    }

    public function httpNoContent(mixed $data = null, ?string $msg = null): ResponseData
    {
        if (! $msg) {
            $msg = trans('message.no_content');
        }

        return new ResponseData(Response::HTTP_NO_CONTENT, $data, $msg);
    }

    public function httpBadRequest(array $errors = [], ?string $msg = null): ResponseData
    {
        return new ResponseData(Response::HTTP_BAD_REQUEST, null, $msg, $errors);
    }

    public function httpNotFound(array $errors = [], ?string $msg = null): ResponseData
    {
        return new ResponseData(Response::HTTP_NOT_FOUND, null, $msg, $errors);
    }

    public function httpUnauthorized(?string $msg = null): ResponseData
    {
        return new ResponseData(Response::HTTP_UNAUTHORIZED, null, $msg, ['code' => 'UNAUTHORIZED']);
    }

    public function httpForbid(?string $msg = null): ResponseData
    {
        return new ResponseData(Response::HTTP_FORBIDDEN, null, $msg, ['code' => 'FORBIDDEN']);
    }

    public function httpRateLimit(mixed $data = null, ?string $msg = null, array $errors = []): ResponseData
    {
        return new ResponseData(Response::HTTP_TOO_MANY_REQUESTS, $data, $msg, $errors);
    }

    public function httpUnprocessableContent(array $errors = [], ?string $msg = null): ResponseData
    {
        return new ResponseData(Response::HTTP_UNPROCESSABLE_ENTITY, null, $msg, $errors);
    }
}
