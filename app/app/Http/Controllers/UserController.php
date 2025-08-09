<?php

namespace App\Http\Controllers;

use App\Domain\Services\Interfaces\IBookService;
use App\Domain\Services\Interfaces\IUserService;
use App\Http\Requests\BookIntervalSubmitRequest;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\MostRecommendedBooksResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{

    public function __construct(
        private readonly IUserService $userService
    )
    {
    }


    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection($this->userService->listUsers());
    }

    public function store(UserCreateRequest $request): JsonResponse
    {
        return apiResponse(data: [], message: $this->userService->createUser($request->validated()));
    }

    // row return statement  , code schema of laravel
    public function update(UserUpdateRequest $request, int $userId): JsonResponse
    {
        $message = $this->userService->updateUser(data: $request->validated(), userId:  $userId);

        return apiResponse(data: [], message: $message);
    }

    public function destroy(User $user): JsonResponse
    {
        $this->authorize('delete', $user);
        return apiResponse(data: [], message: $this->userService->deleteUser(user:  $user));
    }
}
