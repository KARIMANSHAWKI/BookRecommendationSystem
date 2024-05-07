<?php

namespace App\Http\Controllers;

use App\Domain\Services\Interfaces\IAuthService;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{

    public function __construct(
        private readonly IAuthService $authService,
    )
    {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return apiResponse(
            data: [
                'token' => $this->authService->login($request->validated())
            ],
            message: trans('message.login-success')
        );

    }

    public function register(RegisterRequest $request): JsonResponse
    {
        return apiResponse(
            data: [
                'token' => $this->authService->register($request->validated())
            ],
            message: trans('message.register-success')
        );
    }

}
