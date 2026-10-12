<?php

use App\Http\Responses\ApiErrorRenderer;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(function (Request $request) {
            if ($request->is('api/*')) {
                return null;
            }
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $renderer = new ApiErrorRenderer;

        // Laravel converts ModelNotFoundException → NotFoundHttpException before
        // render callbacks run, so both types must be handled for the API envelope.
        $exceptions->render(function (ModelNotFoundException|NotFoundHttpException $e, $request) use ($renderer) {
            if ($request->is('api/*')) {
                return $renderer->renderApiNotFoundResponse($e);
            }
        });

        $exceptions->render(function (ValidationException $e, $request) use ($renderer) {
            if ($request->is('api/*')) {
                return $renderer->renderApiValidationResponse($e);
            }
        });

        $exceptions->render(function (AuthenticationException $e, $request) use ($renderer) {
            if ($request->is('api/*')) {
                return $renderer->renderApiUnauthorizedResponse($e);
            }
        });

        $exceptions->render(function (AuthorizationException|AccessDeniedHttpException $e, $request) use ($renderer) {
            if ($request->is('api/*')) {
                return $renderer->renderApiForbiddenResponse($e);
            }
        });
    })->create();
