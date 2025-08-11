<?php

namespace App\Http\Controllers;

use App\Domain\DTOs\UserDTO;
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
        $token = $this->authService->login($request->validated());

        return apiResponse(
            data: [
                'token' => $token
            ],
            message: trans('message.login-success')
        );

    }

    public function register(RegisterRequest $request): JsonResponse
    {
        /** @var \App\Domain\DTOs\UserDTO $requestData */
        $requestData = UserDTO::fromRequest($request->validated());
        $token = $this->authService->register($requestData);

        return apiResponse(
            data: [
                'token' => $token
            ],
            message: trans('message.register-success')
        );
    }
}
