<?php

namespace App\Traits;

use App\Http\Responses\ResponseData;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait HandleErrorException
{
    public function renderApiValidationResponse(ValidationException $exception): ResponseData
    {
        return new ResponseData(
            Response::HTTP_BAD_REQUEST,
            null,
            'The given data was invalid.',
            [
                'code' => 'BAD_REQUEST',
                'fields' => $this->convertApiErrors($exception->errors()),
            ]
        );
    }

    public function renderApiNotFoundResponse(
        ModelNotFoundException|NotFoundHttpException $exception
    ): ResponseData {
        return new ResponseData(
            Response::HTTP_NOT_FOUND,
            null,
            $exception->getMessage() ?: 'Record not found.',
            ['code' => 'NOT_FOUND']
        );
    }

    public function renderApiUnauthorizedResponse(AuthenticationException $exception): ResponseData
    {
        return new ResponseData(
            Response::HTTP_UNAUTHORIZED,
            null,
            $exception->getMessage() ?: 'Unauthenticated.',
            ['code' => 'UNAUTHORIZED']
        );
    }

    public function renderApiForbiddenResponse(
        AuthorizationException|AccessDeniedHttpException $exception
    ): ResponseData {
        return new ResponseData(
            Response::HTTP_FORBIDDEN,
            null,
            $exception->getMessage() ?: 'This action is unauthorized.',
            ['code' => 'FORBIDDEN']
        );
    }

    private function convertApiErrors(array $errors): array
    {
        $converted = [];

        foreach ($errors as $field => $messages) {
            foreach ((array) $messages as $message) {
                $converted[] = [
                    'field' => $field,
                    'message' => $message,
                ];
            }
        }

        return $converted;
    }
}
