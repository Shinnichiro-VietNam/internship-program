<?php

namespace App\Http\Controllers;

use App\Http\Responses\ResponseData;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class Controller
{
    use AuthorizesRequests;

    public function httpOk(array|JsonResource|null $data = null, string $msg = 'OK'): ResponseData
    {
        return new ResponseData(Response::HTTP_OK, $data, $msg);
    }

    public function httpCreated(array|JsonResource|null $data = null, ?string $msg = null): ResponseData
    {
        if (!$msg) $msg = trans('message.create_success');
        return new ResponseData(Response::HTTP_CREATED, $data, $msg);
    }

    public function httpNoContent(array|JsonResource|null $data = null, ?string $msg = null): ResponseData
    {
        if (!$msg) $msg = trans('message.no_content');
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
        return new ResponseData(Response::HTTP_UNAUTHORIZED, null, $msg);
    }

    public function httpForbid(?string $msg = null): ResponseData
    {
        return new ResponseData(Response::HTTP_FORBIDDEN, null, $msg);
    }

    public function httpRateLimit(array|JsonResource|null $data = null, ?string $msg = null, array $errors = []): ResponseData
    {
        return new ResponseData(Response::HTTP_TOO_MANY_REQUESTS, $data, $msg, $errors);
    }

    public function httpUnprocessableContent(array $errors = [], ?string $msg = null): ResponseData
    {
        return new ResponseData(Response::HTTP_UNPROCESSABLE_ENTITY, null, $msg, $errors);
    }
}
