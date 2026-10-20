<?php

namespace App\Http\Controllers;

use App\Actions\Auth\LoginUserAction;
use App\Actions\Auth\LogoutUserAction;
use App\Actions\Auth\RegisterUserAction;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\UserResource;
use App\Http\Responses\ResponseData;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, RegisterUserAction $action): ResponseData
    {
        $token = $action->handle($request->validated());

        return $this->httpCreated($token);
    }

    public function login(LoginRequest $request, LoginUserAction $action): ResponseData
    {
        $token = $action->handle($request->validated());

        return $this->httpOk($token);
    }

    public function logout(LogoutUserAction $action): ResponseData
    {
        $action->handle();

        return $this->httpNoContent();
    }

    public function user(Request $request): ResponseData
    {
        return $this->httpOk(new UserResource($request->user()));
    }
}
